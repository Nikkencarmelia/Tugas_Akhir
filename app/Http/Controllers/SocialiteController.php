<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Batch;

class SocialiteController extends Controller
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
     * Merge dengan session cart yang ada jika ada
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

        // Ambil cart dari database
        $cartFromDb = [];
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

            $cartFromDb[$cartKey] = [
                'product_id' => $produk->id,
                'batch_id' => $keranjang->id_batch,
                'nama_produk' => $produk->nama_produk,
                'harga' => $batchTertua->harga_saat_ini,
                'gambar' => $produk->gambar ? asset('storage/' . $produk->gambar) : asset('images/default-product.jpg'),
                'satuan_berat' => ($produk->jumlah_satuan ?? 1) . ' ' . ($produk->satuan?->nama_satuan ?? 'pcs'),
                'quantity' => min($keranjang->quantity, $totalStok) // Pastikan tidak melebihi stok
            ];
        }

        // Merge dengan session cart yang ada (session cart diutamakan jika ada konflik)
        $sessionCart = Session::get('cart', []);
        $mergedCart = $cartFromDb;

        foreach ($sessionCart as $key => $item) {
            if (isset($mergedCart[$key])) {
                // Jika item sudah ada di database, gunakan yang dari database (lebih up-to-date)
                // Tapi bisa juga merge quantity jika diperlukan
                continue;
            } else {
                // Item baru di session yang belum ada di database, tambahkan
                $mergedCart[$key] = $item;
            }
        }

        Session::put('cart', $mergedCart);
        
        // Sync kembali ke database untuk memastikan session cart yang baru juga tersimpan
        $this->syncCartToDatabase();
    }

    /**
    *
    * @param NA
    * @return void
    */
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
    *
    * @param NA
    * @return void
    */
    public function googleAuthentication()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('id_google', $googleUser->id)->first();

            if ($user) {
                Auth::login($user);
                // Load cart dari database
                $this->loadCartFromDatabase();
                return redirect()->route('beranda');
            }

            $userData = User::create([
                'nama_lengkap' => $googleUser->name,
                'email' => $googleUser->email,
                'role' => 'user',
                'id_google' => $googleUser->id,
                'password' => Hash::make('Password@1234'),
            ]);

            Auth::login($userData);
            // Load cart dari database (kosong untuk user baru)
            $this->loadCartFromDatabase();
            return redirect()->route('beranda');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
