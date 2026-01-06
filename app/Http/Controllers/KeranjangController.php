<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;  // Untuk debug
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Batch;
use App\Models\Alamat;
use App\Models\Kecamatan;
use App\Models\Keranjang;

class KeranjangController extends Controller
{
    /**
     * Sync cart dari session ke database (untuk user yang login)
     */
    private function syncCartToDatabase()
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();
        $cart = Session::get('cart', []);

        // Ambil semua cart keys yang ada di session
        $sessionCartKeys = [];
        foreach ($cart as $key => $item) {
            $sessionCartKeys[] = [
                'id_produk' => $item['product_id'],
                'id_batch' => $item['batch_id'] ?? null,
            ];
        }

        // Hapus item yang tidak ada lagi di session
        $existingKeranjangs = Keranjang::where('id_user', $user->id)->get();
        foreach ($existingKeranjangs as $keranjang) {
            $found = false;
            foreach ($sessionCartKeys as $key) {
                if ($keranjang->id_produk == $key['id_produk'] && 
                    $keranjang->id_batch == $key['id_batch']) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $keranjang->delete();
            }
        }

        // Update atau create item dari session ke database
        foreach ($cart as $item) {
            Keranjang::updateOrCreate(
                [
                    'id_user' => $user->id,
                    'id_produk' => $item['product_id'],
                    'id_batch' => $item['batch_id'] ?? null,
                ],
                [
                    'quantity' => $item['quantity'],
                ]
            );
        }
    }

    /**
     * Load cart dari database ke session (untuk user yang login)
     */
    private function loadCartFromDatabase()
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();
        $keranjangs = Keranjang::with(['produk.satuan', 'batch'])
            ->where('id_user', $user->id)
            ->get();

        $cart = [];
        foreach ($keranjangs as $keranjang) {
            $produk = $keranjang->produk;
            if (!$produk || $produk->status_tampil !== 'Ditampilkan') {
                continue; // Skip produk yang tidak ditampilkan
            }

            // Cek stok masih tersedia
            $batchQuery = Batch::where('id_produk', $produk->id)->where('stok', '>', 0);
            if ($keranjang->id_batch) {
                $batchQuery->where('id', $keranjang->id_batch);
            }
            $totalStok = $batchQuery->sum('stok');

            if ($totalStok <= 0) {
                continue; // Skip jika stok habis
            }

            // Ambil batch untuk harga
            $batchQueryForPrice = Batch::where('id_produk', $produk->id)->where('stok', '>', 0);
            if ($keranjang->id_batch) {
                $batchQueryForPrice->where('id', $keranjang->id_batch);
            } else {
                $batchQueryForPrice->orderBy('tgl_masuk', 'asc');
            }
            $batchTertua = $batchQueryForPrice->first();

            if (!$batchTertua) {
                continue;
            }

            $cartKey = $produk->id;
            if ($keranjang->id_batch) {
                $cartKey = $produk->id . '_' . $keranjang->id_batch;
            }

            $cart[$cartKey] = [
                'product_id' => $produk->id,
                'batch_id' => $keranjang->id_batch,
                'nama_produk' => $produk->nama_produk,
                'harga' => $batchTertua->harga_saat_ini,
                'gambar' => $produk->gambar ? asset('storage/' . $produk->gambar) : asset('images/default-product.jpg'),
                'satuan_berat' => ($produk->jumlah_satuan ?? 1) . ' ' . ($produk->satuan?->nama_satuan ?? 'pcs'),
                'quantity' => min($keranjang->quantity, $totalStok) // Pastikan tidak melebihi stok
            ];
        }

        Session::put('cart', $cart);
    }

    public function index()
    {
        // Load cart dari database jika user login
        if (Auth::check()) {
            $this->loadCartFromDatabase();
        }

        // Bersihkan session buy_now jika masuk ke halaman keranjang biasa
        if (session()->has('buy_now')) {
            session()->forget('buy_now');
        }

        $keranjang = Session::get('cart', []);

        $totalProduk = count($keranjang);
        $subtotal = 0;
        foreach ($keranjang as $item) {
            $subtotal += $item['harga'] * $item['quantity'];
        }

        return view('User.keranjang', compact('keranjang', 'totalProduk', 'subtotal'));
    }

    public function addToCart(Request $request)
    {
        try {
            Log::info('Add to cart request:', $request->all());  // Debug input

            // Normalize batch_id: convert empty string to null before validation
            $requestData = $request->all();
            if (isset($requestData['batch_id']) && ($requestData['batch_id'] === '' || $requestData['batch_id'] === null)) {
                $requestData['batch_id'] = null;
            }

            $validator = Validator::make($requestData, [
                'product_id' => 'required|integer|exists:produks,id',
                'batch_id' => 'nullable|integer|exists:batches,id',
                'quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed:', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all())
                ], 422);
            }

            $productId = $request->input('product_id');
            $batchId = $requestData['batch_id'] ?? null;
            
            // Convert empty string/non-numeric to null
            if ($batchId === '' || !is_numeric($batchId)) {
                $batchId = null;
            } else {
                $batchId = (int) $batchId;
            }
            $quantity = (int) $request->input('quantity', 1);

            Log::info('Querying product', ['id' => $productId, 'batch_id' => $batchId]);

            // FIX: whereHas('batch') pakai relation yang benar
            $produk = Produk::with(['satuan'])
                ->where('status_tampil', 'Ditampilkan')
                ->whereHas('batch', function ($q) use ($batchId) {
                    $q->where('stok', '>', 0);
                    if ($batchId) {
                        $q->where('id', $batchId);
                    }
                })
                ->find($productId);

            Log::info('Product found?', ['id' => $productId, 'produk' => $produk ? 'yes' : 'no']);

            if (!$produk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan atau tidak tersedia (stok habis).'
                ], 404);
            }

            // FIX: Ganti 'produk_id' ke 'id_produk' di semua query Batch
            $batchQuery = Batch::where('id_produk', $productId)->where('stok', '>', 0);
            if ($batchId) {
                $batchQuery->where('id', $batchId);
            }
            $totalStok = $batchQuery->sum('stok');
            Log::info('Total stok check', ['stok' => $totalStok, 'requested_qty' => $quantity]);

            if ($quantity > $totalStok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $totalStok
                ], 400);
            }

            $batchQueryForPrice = Batch::where('id_produk', $productId)->where('stok', '>', 0);
            if ($batchId) {
                $batchQueryForPrice->where('id', $batchId);
            } else {
                $batchQueryForPrice->orderBy('tgl_masuk', 'asc');
            }
            $batchTertua = $batchQueryForPrice->first();
            Log::info('Batch for price', ['batch_id' => $batchTertua?->id ?? 'none']);

            $hargaSaatIni = $batchTertua->harga_saat_ini ?? 0;

            if ($hargaSaatIni <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Harga produk tidak valid (Rp 0).'
                ], 400);
            }

            if (!Session::has('cart')) {
                Session::put('cart', []);
            }

            $cart = Session::get('cart', []);

            // Check total cart quantity limit (99 products max)
            $currentTotalQuantity = array_sum(array_column($cart, 'quantity'));
            $cartKey = $productId;
            if ($batchId) {
                $cartKey = $productId . '_' . $batchId;
            }

            // Calculate new total quantity
            $quantityToAdd = $quantity;
            if (isset($cart[$cartKey])) {
                // Item already exists, calculate new total
                $newItemQuantity = $cart[$cartKey]['quantity'] + $quantity;
                $newTotalQuantity = $currentTotalQuantity - $cart[$cartKey]['quantity'] + $newItemQuantity;
            } else {
                // New item, just add quantity
                $newTotalQuantity = $currentTotalQuantity + $quantity;
            }

            // Check limit 99 products
            if ($newTotalQuantity > 99) {
                $available = 99 - $currentTotalQuantity;
                if ($available <= 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Keranjang sudah penuh! Maksimal 99 produk. Silakan checkout atau hapus beberapa item terlebih dahulu.'
                    ], 400);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "Keranjang hampir penuh! Hanya bisa menambahkan {$available} produk lagi (maksimal 99 produk)."
                    ], 400);
                }
            }

            if (isset($cart[$cartKey])) {
                $newQuantity = $cart[$cartKey]['quantity'] + $quantity;
                if ($newQuantity > $totalStok) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok tidak mencukupi setelah penambahan. Stok tersedia: ' . $totalStok
                    ], 400);
                }
                $cart[$cartKey]['quantity'] = $newQuantity;
            } else {
                // Check stock before adding new item
                if ($quantity > $totalStok) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $totalStok
                    ], 400);
                }
                $cart[$cartKey] = [
                    'product_id' => $productId,
                    'batch_id' => $batchId,
                    'nama_produk' => $produk->nama_produk,
                    'harga' => $hargaSaatIni,
                    'gambar' => $produk->gambar ? asset('storage/' . $produk->gambar) : asset('images/default-product.jpg'),
                    'satuan_berat' => ($produk->jumlah_satuan ?? 1) . ' ' . ($produk->satuan?->nama_satuan ?? 'pcs'),
                    'quantity' => $quantity
                ];
            }

            Session::put('cart', $cart);
            
            // Sync ke database jika user login
            if (Auth::check()) {
                $this->syncCartToDatabase();
            }
            
            Log::info('Cart updated successfully', ['key' => $cartKey, 'cart_size' => count($cart)]);

            $cartCount = array_sum(array_column($cart, 'quantity'));

            return response()->json([
                'success' => true,
                'message' => "Berhasil ditambahkan {$quantity} {$produk->nama_produk} ke keranjang!",
                'cart_count' => $cartCount
            ]);
        } catch (\Exception $e) {
            Log::error('Add to cart error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan ke keranjang: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Beli Sekarang - Meloncati keranjang, langsung ke checkout dengan 1 produk saja.
     */
    public function buyNow(Request $request)
    {
        try {
            Log::info('Buy now request:', $request->all());

            $requestData = $request->all();
            if (isset($requestData['batch_id']) && ($requestData['batch_id'] === '' || $requestData['batch_id'] === null)) {
                $requestData['batch_id'] = null;
            }

            $validator = Validator::make($requestData, [
                'product_id' => 'required|integer|exists:produks,id',
                'batch_id' => 'nullable|integer|exists:batches,id',
                'quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all())
                ], 422);
            }

            $productId = $requestData['product_id'];
            $batchId = $requestData['batch_id'] ?? null;
            $quantity = (int) $requestData['quantity'];

            // Cek produk & stok
            $produk = Produk::with(['satuan'])
                ->where('status_tampil', 'Ditampilkan')
                ->whereHas('batch', function ($q) use ($batchId) {
                    $q->where('stok', '>', 0);
                    if ($batchId) $q->where('id', $batchId);
                })
                ->find($productId);

            if (!$produk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak tersedia.'
                ], 404);
            }

            // Ambil batch tertua untuk harga
            $batchQuery = Batch::where('id_produk', $productId)->where('stok', '>', 0);
            if ($batchId) $batchQuery->where('id', $batchId);
            else $batchQuery->orderBy('tgl_masuk', 'asc');
            
            $batchTertua = $batchQuery->first();
            $totalStok = $batchQuery->sum('stok');

            if ($quantity > $totalStok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Tersedia: ' . $totalStok
                ], 400);
            }

            // Siapkan data Tunggal untuk session 'buy_now'
            // Formatnya adalah array of items agar sama dengan 'cart' tapi isinya cuma 1
            $buyNowData = [
                'item_direct' => [
                    'product_id' => $productId,
                    'batch_id' => $batchTertua->id, // Spesifik batch ID dari batch tertua jika tidak diinput
                    'nama_produk' => $produk->nama_produk,
                    'harga' => $batchTertua->harga_saat_ini,
                    'gambar' => $produk->gambar ? asset('storage/' . $produk->gambar) : asset('images/default-product.jpg'),
                    'satuan_berat' => ($produk->jumlah_satuan ?? 1) . ' ' . ($produk->satuan?->nama_satuan ?? 'pcs'),
                    'quantity' => $quantity
                ]
            ];

            // Simpan ke session mandiri
            session(['buy_now' => $buyNowData]);
            session()->save(); // Paksa simpan sebelum redirect di client-side

            Log::info('Buy now data stored', [
                'session_id' => session()->getId(), 
                'buy_now_content' => $buyNowData,
                'cart_content' => session('cart')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lanjut ke pembayaran...'
            ]);

        } catch (\Exception $e) {
            Log::error('Buy now error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pembelian: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|integer|exists:produks,id',
                'batch_id' => 'nullable|integer|exists:batches,id',
                'quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all())
                ], 422);
            }

            $productId = $request->input('product_id');
            $batchId = $request->input('batch_id');
            $quantity = $request->input('quantity');

            if (!Session::has('cart')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang kosong.'
                ], 400);
            }

            $cart = Session::get('cart');

            $cartKey = $productId;
            if ($batchId) {
                $cartKey = $productId . '_' . $batchId;
            }

            if (!isset($cart[$cartKey])) {
                // Try flexible search (find by product_id regardless of batch key mismatch)
                $foundKey = null;
                foreach ($cart as $key => $item) {
                    if ($item['product_id'] == $productId) {
                        $foundKey = $key;
                        break;
                    }
                }

                if ($foundKey) {
                    $cartKey = $foundKey;
                    // Update batchId to match the found item's batch_id for stock check
                    $batchId = $cart[$cartKey]['batch_id'] ?? null; 
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Item tidak ditemukan di keranjang.'
                    ], 404);
                }
            }

            // FIX: Ganti 'produk_id' ke 'id_produk' + pakai relation
            $produk = Produk::find($productId);
            if (!$produk) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
            }

            $batchQuery = $produk->batch()->where('stok', '>', 0);  // Pakai relation batch()
            if ($batchId) {
                $batchQuery->where('id', $batchId);
            }
            $totalStok = $batchQuery->sum('stok');
            if ($quantity > $totalStok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $totalStok
                ], 400);
            }

            $cart[$cartKey]['quantity'] = $quantity;
            Session::put('cart', $cart);

            // Sync ke database jika user login
            if (Auth::check()) {
                $this->syncCartToDatabase();
            }

            return response()->json([
                'success' => true,
                'message' => 'Quantity berhasil diupdate!'
            ]);

        } catch (\Exception $e) {
            Log::error('Update cart error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus multiple item dari keranjang
     */
    public function deleteMultiple(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'string'  // Karena key bisa product_id atau product_id_batch_id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all())
            ], 422);
        }

        $ids = $request->input('ids');

        if (!Session::has('cart')) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong.'
            ], 400);
        }

        $cart = Session::get('cart');

        foreach ($ids as $id) {
            if (isset($cart[$id])) {
                unset($cart[$id]);
            }
        }

        Session::put('cart', $cart);

        // Sync ke database jika user login
        if (Auth::check()) {
            $this->syncCartToDatabase();
        }

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang!'
        ]);
    }

    /**
     * Hapus item dari keranjang (single)
     */
    public function delete($id)
    {
        if (!Session::has('cart')) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong.'
            ], 400);
        }

        $cart = Session::get('cart');
        if (!isset($cart[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan.'
            ], 404);
        }

        unset($cart[$id]);
        Session::put('cart', $cart);

        // Sync ke database jika user login
        if (Auth::check()) {
            $this->syncCartToDatabase();
        }

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang!'
        ]);
    }

    /**
     * Hapus semua item dari keranjang
     */
    public function clear()
    {
        Session::forget('cart');

        // Hapus dari database juga jika user login
        if (Auth::check()) {
            Keranjang::where('id_user', Auth::id())->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan!'
        ]);
    }

}
