<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\DetailPesanan;
use App\Models\Alamat;        // pastikan model ini ada
use App\Models\Kecamatan;    // pastikan model ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\TugasKurir;

class PemesananController extends Controller
{
    /**
     * Halaman Dashboard Staff Purchasing
     */
    public function dashboardPurchasing()
    {
        // Fetch raw data for stats
        // We can optimize this by using counts instead of fetching all records if only counts are needed, 
        // but the view currently uses array filters on a collection. To match the view logic or improve it?
        // Let's optimize it by fetching counts directly or mapping statuses.
        
        // However, the view expects '$pesanan' as an array with 'status' key. 
        // Wait, the current dashboard view code provided by user has specific array filtering logic:
        // $p['status'] === 'Masuk', 'Konfirmasi Pembayaran', 'Belum Dapat Kurir'
        // This implies the view expects a transformed array, or I should update the view to use standard Eloquent counts.
        
        // BETTER APPROACH: Update the view to use standard Eloquent variables, 
        // and here pass those variables.
        
        $pesanan_masuk_count = Pemesanan::where('status_pesanan', 'menunggu_konfirmasi')->count();
        $konfirmasi_pembayaran_count = Pemesanan::where('status_pesanan', 'menunggu_konfirmasi_pembayaran')->count();
        $menunggu_pembayaran_count = Pemesanan::where('status_pesanan', 'menunggu_pembayaran')->count();
        $belum_kurir_count = Pemesanan::where('status_pesanan', 'menunggu_cari_kurir')->count();
        $ditolak_kurir_count = Pemesanan::where('status_pesanan', 'ditolak_kurir')->count();
        
        $kecamatans_count = \App\Models\Kecamatan::count();

        return view('Staff_Purchasing.dashboard', compact(
            'pesanan_masuk_count', 
            'konfirmasi_pembayaran_count', 
            'menunggu_pembayaran_count',
            'belum_kurir_count', 
            'ditolak_kurir_count',
            'kecamatans_count'
        ));
    }

    /**
     * Halaman daftar pesanan user (riwayat)
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $search = $request->get('search');
        $sort = $request->get('sort', 'terbaru'); // default terbaru

        $query = function($statuses) use ($userId, $search, $sort) {
            $q = Pemesanan::with('detailPesanan')
                ->where('id_user', $userId)
                ->whereIn('status_pesanan', (array)$statuses);

            if ($search) {
                $q->where(function($sq) use ($search) {
                    $sq->where('kode_pesanan', 'LIKE', "%{$search}%")
                       ->orWhereHas('detailPesanan', function($dq) use ($search) {
                           $dq->where('nama_produk', 'LIKE', "%{$search}%");
                       });
                });
            }

            if ($sort === 'terlama') {
                $q->orderBy('updated_at', 'asc');
            } else {
                $q->orderBy('updated_at', 'desc');
            }

            return $q;
        };

        $konfirmasi_pesanan = $query(['menunggu_konfirmasi'])
            ->paginate(10, ['*'], 'page_konfirmasi');

        $menunggu_pembayaran = $query(['menunggu_pembayaran'])
            ->paginate(10, ['*'], 'page_menunggu');

        $diproses = $query(['menunggu_konfirmasi_pembayaran', 'menunggu_verifikasi_pembayaran', 'menunggu_cari_kurir', 'menunggu_konfirmasi_kurir', 'diproses', 'siap_diambil', 'pesanan_telah_diambil'])
            ->paginate(10, ['*'], 'page_proses');

        $dikirim = $query(['dikirim', 'sedang_diantar'])
            ->paginate(10, ['*'], 'page_dikirim');

        $selesai = $query(['selesai'])
        ->paginate(10, ['*'], 'page_selesai');

    $dibatalkan = $query(['dibatalkan', 'ditolak_staff'])
        ->paginate(10, ['*'], 'page_dibatalkan');

        $counts = [
            'konfirmasi' => $query(['menunggu_konfirmasi'])->count(),
            'menunggu' => $query(['menunggu_pembayaran'])->count(),
            'proses' => $query(['menunggu_konfirmasi_pembayaran', 'menunggu_verifikasi_pembayaran', 'menunggu_cari_kurir', 'menunggu_konfirmasi_kurir', 'diproses', 'siap_diambil', 'pesanan_telah_diambil'])->count(),
            'dikirim' => $query(['dikirim', 'sedang_diantar'])->count(),
            'selesai' => $query(['selesai'])->count(),
            'dibatalkan' => $query(['dibatalkan', 'ditolak_staff'])->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'konfirmasi' => view('User.partials._order_list', ['collection' => $konfirmasi_pesanan, 'title' => 'menunggu konfirmasi'])->render(),
                'menunggu' => view('User.partials._order_list', ['collection' => $menunggu_pembayaran, 'title' => 'menunggu pembayaran'])->render(),
                'proses' => view('User.partials._order_list', ['collection' => $diproses, 'title' => 'sedang diproses'])->render(),
                'dikirim' => view('User.partials._order_list', ['collection' => $dikirim, 'title' => 'sedang dikirim'])->render(),
                'selesai' => view('User.partials._order_list', ['collection' => $selesai, 'title' => 'selesai'])->render(),
                'dibatalkan' => view('User.partials._order_list', ['collection' => $dibatalkan, 'title' => 'dibatalkan atau ditolak'])->render(),
                'counts' => $counts
            ]);
        }

        return view('User.riwayat', compact(
            'konfirmasi_pesanan',
            'menunggu_pembayaran',
            'diproses',
            'dikirim',
            'selesai',
            'dibatalkan',
            'counts'
        ));
    }

    /**
     * Halaman pesanan masuk untuk Staff Purchasing
     */
    public function pesananMasuk()
    {
        // Ambil semua pesanan dengan status 'menunggu_konfirmasi'
        $pengiriman_masuk = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'menunggu_konfirmasi')
            ->latest('updated_at')
            ->get();

        return view('Staff_Purchasing.pesananMasuk', compact('pengiriman_masuk'));
    }

    public function cariKurir()
    {
        // Pesanan Baru (Menunggu Cari Kurir) - Renamed to match view expectation
        $pesanan_baru = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'menunggu_cari_kurir')
            ->latest('updated_at')
            ->get();

        // Menunggu Konfirmasi Kurir (Sudah diassign, tapi belum diterima kurir) - Added
        $menunggu_konfirmasi = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat', 'kurir'])
            ->where('status_pesanan', 'menunggu_konfirmasi_kurir')
            ->latest('updated_at')
            ->get();

        // Pesanan Ditolak Kurir (Cari Kurir Lagi)
        $ditolak_kurir = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'ditolak_kurir')
            ->latest('updated_at')
            ->get();

        // List Kurir untuk Modal (Only those with vehicle info)
        $kurirs = User::where('role', 'kurir')
            ->whereHas('kurir', function($query) {
                $query->whereNotNull('jenis_kendaraan');
            })->with('kurir')->get();

        return view('Staff_Purchasing.cariKurir', compact('pesanan_baru', 'menunggu_konfirmasi', 'ditolak_kurir', 'kurirs'));
    }

    public function assignKurir(Request $request)
    {
        $request->validate([
            'kode_pesanan' => 'required',
            'id_kurir' => 'required|exists:users,id'
        ]);

        $pemesanan = Pemesanan::where('kode_pesanan', $request->kode_pesanan)->firstOrFail();
        
        Log::info('Assigning Kurir', [
            'kode_pesanan' => $request->kode_pesanan,
            'id_kurir' => $request->id_kurir,
            'old_status' => $pemesanan->status_pesanan
        ]);

        $updated = $pemesanan->update([
            'id_kurir' => $request->id_kurir,
            'status_pesanan' => 'menunggu_konfirmasi_kurir'
        ]);

        Log::info('Assign Kurir Result', [
            'updated' => $updated,
            'new_status' => $pemesanan->refresh()->status_pesanan,
            'assigned_kurir' => $pemesanan->id_kurir
        ]);

        return back()->with('success', 'Kurir berhasil dipilih (ID: ' . $request->id_kurir . '). Menunggu konfirmasi kurir.');
    }

    /**
     * Halaman Pengiriman Masuk untuk Kurir (Status: menunggu_konfirmasi_kurir)
     * Hanya menampilkan pesanan yang ditugaskan ke kurir yang sedang login.
     */
    public function pengirimanMasukKurir()
    {
        $userId = Auth::id();
        
        Log::info('Kurir Checking Inbox', ['user_id' => $userId]);

        $pengiriman_masuk = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('id_kurir', $userId) // Filter by logged-in courier
            ->where('status_pesanan', 'menunggu_konfirmasi_kurir') // Waiting for courier confirmation
            ->latest('updated_at')
            ->get();
            
        Log::info('Inbox Result', ['count' => $pengiriman_masuk->count()]);

        return view('Kurir.pengirimanMasuk', compact('pengiriman_masuk'));
    }

    /**
     * Halaman Status Pengiriman (Pesanan Aktif Kurir)
     */
    public function statusPengirimanKurir()
    {
        $userId = Auth::id();

        // 1. Menunggu Pengiriman (Siap Diambil/Dikirim)
        // User requested to hide "menunggu_pembayaran" details from courier and just show "Meniapkan Pesanan".
        // So we include all these statuses in 'menunggu_pengiriman'.
        $menunggu_pengiriman = Pemesanan::with(['user', 'detailPesanan.produk', 'alamat'])
            ->where('id_kurir', $userId)
            ->whereIn('status_pesanan', [
                'menunggu_pembayaran',
                'menunggu_konfirmasi_pembayaran',
                'menunggu_verifikasi_pembayaran',
                'diproses', 
                'siap_diambil',
                'pesanan_telah_diambil'
            ]) 
            ->latest('updated_at')
            ->get()
            ->sortByDesc(function($order) {
                // Sort pesanan_telah_diambil (ready to be sent) to the top
                return $order->status_pesanan === 'pesanan_telah_diambil' ? 1 : 0;
            });

    // 2. Dikirim / Pengiriman
    $dikirim = Pemesanan::with(['user', 'detailPesanan.produk', 'alamat'])
        ->where('id_kurir', $userId)
        ->whereIn('status_pesanan', ['dikirim', 'sedang_diantar'])
        ->latest('updated_at')
        ->get();

        return view('Kurir.statusPengiriman', compact('menunggu_pengiriman', 'dikirim'));
    }

    public function kurirKirimSekarang(Pemesanan $pemesanan)
    {
        if ($pemesanan->status_pesanan !== 'pesanan_telah_diambil') {
            return back()->with('error', 'Pesanan belum diserahkan ke kurir.');
        }


        $pemesanan->update(['status_pesanan' => 'dikirim']);

        // Set kurir status (syncStatus will handle it)
        $kurir = \App\Models\Kurir::where('id_user', Auth::id())->first();
        if ($kurir) { $kurir->syncStatus(); }

        return back()->with('success', 'Pesanan berhasil dikirim.');
    }

    // Action: Sudah Sampai (Selesai)
    public function kurirSelesai(Pemesanan $pemesanan)
    {
        $pemesanan->update(['status_pesanan' => 'selesai']);

        // Sync kurir status
        $kurir = \App\Models\Kurir::where('id_user', Auth::id())->first();
        if ($kurir) { $kurir->syncStatus(); }

        return back()->with('success', 'Pesanan selesai (sudah sampai).');
    }

    public function riwayatPengirimanKurir()
    {
        $userId = Auth::id();
        
        // 1. Ambil dari Pemesanan (Selesai, Dibatalkan)
        $riwayat = Pemesanan::with(['user', 'detailPesanan.produk', 'alamat'])
            ->where('id_kurir', $userId)
            ->whereIn('status_pesanan', ['selesai', 'dibatalkan'])
            ->latest('updated_at')
            ->get();

        // 2. Ambil Riwayat Ditolak dari tugas_kurir
        $riwayat_ditolak = TugasKurir::with(['pemesanan.user', 'pemesanan.detailPesanan.produk', 'pemesanan.alamat'])
            ->where('id_kurir', $userId)
            ->latest('updated_at')
            ->get();

        return view('Kurir.riwayat', compact('riwayat', 'riwayat_ditolak'));
    }

    public function kurirTerima(Request $request, Pemesanan $pemesanan)
    {
        // Update status to 'menunggu_pembayaran' as requested
        $pemesanan->update(['status_pesanan' => 'menunggu_pembayaran']); 
        
        return back()->with('success', 'Pengiriman diterima. Menunggu pembayaran user.');
    }

    public function kurirTolak(Request $request, Pemesanan $pemesanan)
    {
        // Riwayat ditolak masuk ke tabel tugas_kurir
        TugasKurir::create([
            'id_pemesanan' => $pemesanan->id,
            'id_kurir' => Auth::id()
        ]);

        $pemesanan->update([
            'status_pesanan' => 'ditolak_kurir',
            'id_kurir' => null // Unassign so it can be reassigned
        ]);
        return back()->with('success', 'Pengiriman ditolak. Pesanan kembali ke purchasing.');
    }

    public function kurirTerimaDipilih(Request $request)
    {
        $request->validate(['order_ids' => 'required|array']);
        
        Pemesanan::whereIn('id', $request->order_ids)
            ->where('id_kurir', Auth::id())
            ->where('status_pesanan', 'menunggu_konfirmasi_kurir')
            ->update(['status_pesanan' => 'menunggu_pembayaran']);

        return back()->with('success', 'Pesanan dipilih berhasil diterima.');
    }

    public function kurirTolakDipilih(Request $request)
    {
        $request->validate(['order_ids' => 'required|array']);

        $orders = Pemesanan::whereIn('id', $request->order_ids)
            ->where('id_kurir', Auth::id())
            ->where('status_pesanan', 'menunggu_konfirmasi_kurir')
            ->get();

        foreach($orders as $order) {
            TugasKurir::create([
                'id_pemesanan' => $order->id,
                'id_kurir' => Auth::id()
            ]);
            
            $order->update([
                'status_pesanan' => 'ditolak_kurir',
                'id_kurir' => null
            ]);
        }

        return back()->with('success', 'Pesanan yang dipilih berhasil ditolak.');
    }

    public function kurirTerimaSemua()
    {
        $user = Auth::user();
        Pemesanan::where('id_kurir', $user->id)
            ->where('status_pesanan', 'menunggu_konfirmasi_kurir')
            ->update(['status_pesanan' => 'menunggu_pembayaran']);

        return back()->with('success', 'Semua pesanan berhasil diterima.');
    }

    public function kurirTolakSemua()
    {
        $user = Auth::user();
        Pemesanan::where('id_kurir', $user->id)
            ->where('status_pesanan', 'menunggu_konfirmasi_kurir')
            ->update([
                'status_pesanan' => 'ditolak_kurir',
                'id_kurir' => null
            ]);

        return back()->with('success', 'Semua pesanan berhasil ditolak.');
    }

    /**
     * Halaman Pesanan Berjalan (Status: menunggu_pembayaran, siap_diambil, diproses, dll)
     */
    public function pesananBerjalan()
    {
        // 1. Menunggu Pembayaran
        $menunggu_pembayaran = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->whereIn('status_pesanan', ['menunggu_pembayaran', 'menunggu_verifikasi_pembayaran'])
            ->latest('updated_at')
            ->get();

        // 2. Siapkan Pesanan (Diproses)
        $siapkan_pesanan = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'diproses')
            ->latest('updated_at')
            ->get();

        // 3. Siap Diambil / Dikirim
        $siap_diambil = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'siap_diambil')
            ->latest('updated_at')
            ->get();

        return view('Staff_Purchasing.pesananBerjalan', compact('menunggu_pembayaran', 'siapkan_pesanan', 'siap_diambil'));
    }

    /**
     * Proses Terima Pesanan Satuan
     */
    public function terimaPesanan(Request $request, Pemesanan $pemesanan)
    {
        if ($pemesanan->status_pesanan == 'menunggu_konfirmasi') {
            if ($pemesanan->opsi_pengiriman == 'dipick_up') {
                $pemesanan->update(['status_pesanan' => 'menunggu_pembayaran']);
                return redirect()->route('staff_purchasing.pesanan_berjalan')->with('success', 'Pesanan Pick Up diterima. Menunggu pembayaran user.');
            } else {
                $pemesanan->update(['status_pesanan' => 'menunggu_cari_kurir']);
                return redirect()->route('staff_purchasing.cari_kurir')->with('success', 'Pesanan diterima. Silakan cari kurir.');
            }
        }

        return back()->with('error', 'Status pesanan tidak valid untuk diterima.');
    }

    /**
     * Proses Terima SEMUA Pesanan
     */
    public function terimaSemuaPesanan()
    {
        DB::transaction(function () {
            // Update Pick Up -> Menunggu Pembayaran
            Pemesanan::where('status_pesanan', 'menunggu_konfirmasi')
                ->where('opsi_pengiriman', 'dipick_up')
                ->update(['status_pesanan' => 'menunggu_pembayaran']);

            // Update Diantar -> Menunggu Kurir
            Pemesanan::where('status_pesanan', 'menunggu_konfirmasi')
                ->where('opsi_pengiriman', '!=', 'dipick_up')
                ->update(['status_pesanan' => 'menunggu_cari_kurir']);
        });

        return redirect()->route('staff_purchasing.cari_kurir')->with('success', 'Semua pesanan berhasil diterima.');
    }

    /**
     * Proses Terima Pesanan DIPILIH (Bulk Action)
     */
    public function terimaDipilih(Request $request)
    {
        $request->validate(['order_ids' => 'required|array']);
        $orderIds = $request->order_ids;

        DB::transaction(function () use ($orderIds) {
            // Update Pick Up
            Pemesanan::whereIn('id', $orderIds)
                ->where('status_pesanan', 'menunggu_konfirmasi')
                ->where('opsi_pengiriman', 'dipick_up')
                ->update(['status_pesanan' => 'menunggu_pembayaran']);

            // Update Diantar
            Pemesanan::whereIn('id', $orderIds)
                ->where('status_pesanan', 'menunggu_konfirmasi')
                ->where('opsi_pengiriman', '!=', 'dipick_up')
                ->update(['status_pesanan' => 'menunggu_cari_kurir']);
        });

        return redirect()->route('staff_purchasing.cari_kurir')->with('success', 'Pesanan terpilih berhasil diterima.');
    }

    /**
     * Proses Tolak Pesanan DIPILIH (Bulk Action) oleh Staff
     */
    public function tolakDipilihStaff(Request $request)
    {
        $request->validate(['order_ids' => 'required|array']);
        $orderIds = $request->order_ids;

        DB::transaction(function () use ($orderIds) {
            // Update status to 'ditolak_staff'
            Pemesanan::whereIn('id', $orderIds)
                ->where('status_pesanan', 'menunggu_konfirmasi')
                ->update(['status_pesanan' => 'ditolak_staff']);
                
            // Restore stock logic for each order
            $orders = Pemesanan::whereIn('id', $orderIds)->with('detailPesanan')->get();
            foreach ($orders as $order) {
                foreach ($order->detailPesanan as $detail) {
                    if ($detail->id_batch) {
                        $batch = \App\Models\Batch::find($detail->id_batch);
                        if ($batch) {
                            $batch->stok += $detail->quantity;
                            
                            // Update status stok
                            if ($batch->stok <= 0) {
                                $batch->status_stok = 'habis';
                            } elseif ($batch->stok <= 10) {
                                $batch->status_stok = 'menipis';
                            } else {
                                $batch->status_stok = 'tersedia';
                            }
                            $batch->save();
                        }
                    }
                }
            }
        });

        return back()->with('success', 'Pesanan terpilih berhasil ditolak.');
    }

    /**
     * Halaman detail pesanan untuk Staff Purchasing
     */
    public function showPurchasing(Pemesanan $pemesanan)
    {
        // Add authorization check here if needed, e.g., if(Auth::user()->role !== 'staff_purchasing') abort(403);
        
        return view('Staff_Purchasing.detailPesanan', compact('pemesanan'));
    }

    public function checkout(Request $request)
    {
        Log::info('Entering checkout', [
            'session_id' => session()->getId(),
            'has_buy_now' => session()->has('buy_now'),
            'has_cart' => session()->has('cart'),
            'buy_now_data' => session('buy_now'),
            'selected_items' => $request->get('selected_items')
        ]);

        // 1. Prioritaskan session 'buy_now' (untuk fitur Beli Sekarang yang mandiri)
        $checkout = session('buy_now', []);
        
        // 2. Jika buy_now kosong, baru ambil dari keranjang belanja
        if (empty($checkout)) {
            $keranjang = session('cart', []);
            $selectedKeys = $request->get('selected_items', []);

            if (empty($selectedKeys)) {
                $checkout = $keranjang;
            } else {
                $checkout = [];
                foreach ($selectedKeys as $key) {
                    if (isset($keranjang[$key])) {
                        $checkout[$key] = $keranjang[$key];
                    }
                }
            }
        }

        if (empty($checkout)) {
            Log::warning('Checkout source is empty, redirecting to cart.');
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong atau tidak ada item yang dipilih.');
        }

        // Hitung subtotal
        $subtotal = 0;
        $originalSubtotal = 0;
        foreach ($checkout as $item) {
            $harga_satuan = $item['harga'] ?? $item['harga_satuan'] ?? 0;
            $subtotal += $harga_satuan * $item['quantity'];
        }

        // Ambil ID produk untuk query DB
        $productIds = array_unique(array_filter(array_map(function($item) {
            return $item['product_id'] ?? $item['id_produk'] ?? null;
        }, $checkout)));

        $products = \App\Models\Produk::with('satuan')->whereIn('id', $productIds)->get()->keyBy('id');

        // Siapkan itemsCheckout untuk JavaScript
        $itemsCheckout = [];
        foreach ($checkout as $key => &$item) {
            $pid = $item['product_id'] ?? $item['id_produk'] ?? null;
            $bid = $item['batch_id'] ?? $item['id_batch'] ?? null;
            $product = $products[$pid] ?? null;
            
            $namaSatuan = $product && $product->satuan ? $product->satuan->nama_satuan : ($item['satuan_berat'] ?? 'pcs');
            $jumlahSatuan = $product ? $product->jumlah_satuan : 1;

            // Ambil harga asli dari batch jika ada
            $batch = null;
            if ($bid) {
                $batch = \App\Models\Batch::find($bid);
            }
            
            $hargaNormal = $batch ? $batch->harga_normal : ($item['harga'] ?? $item['harga_satuan'] ?? 0);
            $hargaSaatIni = $item['harga'] ?? $item['harga_satuan'] ?? 0;
            $hargaAwal = ($hargaNormal > $hargaSaatIni) ? $hargaNormal : null;

            // Update item in $checkout for Blade
            $item['harga_awal'] = $hargaAwal;
            $originalSubtotal += ($hargaAwal ?? $hargaSaatIni) * ($item['quantity'] ?? 1);

            $itemsCheckout[] = [
                'id_produk'     => $pid,
                'id_batch'      => $bid,
                'nama_produk'   => $item['nama_produk'] ?? '',
                'gambar'        => $item['gambar'] ?? '',
                'quantity'      => $item['quantity'] ?? 1,
                'satuan'        => $namaSatuan,
                'jumlah_satuan' => $jumlahSatuan,
                'harga_satuan'  => $hargaSaatIni,
                'harga'         => $hargaSaatIni,
                'harga_awal'    => $hargaAwal,
            ];
        }
        unset($item); // Break reference

        // Data alamat user
        $alamat = Auth::user()->alamats()->with(['kecamatan', 'kelurahan', 'kodePos'])->get();
        $kecamatans = Kecamatan::all();

        return view('User.checkout', compact(
            'checkout',
            'subtotal',
            'originalSubtotal',
            'alamat',
            'kecamatans',
            'itemsCheckout'
        ));
    }

    /**
     * Proses pembuatan pesanan dari checkout
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'opsi_pengiriman'      => 'required|in:diantar,dipick_up',
            'nama_penerima'        => 'required|string|max:255',
            'no_telepon'           => 'required|string|max:20',
            'id_alamat'            => 'nullable|exists:alamats,id',
            'alamat_lengkap'       => 'nullable|required_if:opsi_pengiriman,diantar|string|max:1000',
            'nama_kecamatan'       => 'nullable|required_if:opsi_pengiriman,diantar|string|max:100',
            'nama_kelurahan'       => 'nullable|required_if:opsi_pengiriman,diantar|string|max:100',
            'kode_pos'             => 'nullable|required_if:opsi_pengiriman,diantar|string|max:10',
            'kendaraan'            => 'nullable|in:Mobil,Motor', // Pick Up tidak perlu kendaraan
            'ongkir'               => 'required|numeric|min:0',
            'subtotal'             => 'required|numeric|min:0',
            'total'                => 'required|numeric|min:0',
            'items'                => 'required|array|min:1',
            'items.*.id_produk'    => 'required|exists:produks,id',
            'items.*.id_batch'     => 'nullable|exists:batches,id',
            'items.*.nama_produk'  => 'required|string',
            'items.*.gambar'       => 'required|string',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.satuan'       => 'nullable|string',
            'items.*.jumlah_satuan'=> 'nullable|numeric',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        // Logic tambahan jika perlu, misal memaksa null jika pick up (sudah dihandle di create via defaults)
        if ($validated['opsi_pengiriman'] === 'dipick_up') {
             $validated['ongkir'] = 0;
             $validated['kendaraan'] = null;
        }

        $pemesanan = DB::transaction(function () use ($validated) {
            $pemesanan = Pemesanan::create([
                'id_user'           => Auth::id(),
                'id_alamat'         => $validated['id_alamat'] ?? null,
                'kode_pesanan'      => 'ORD-' . Str::upper(Str::random(10)),
                'opsi_pengiriman'   => $validated['opsi_pengiriman'],
                'nama_penerima'     => $validated['nama_penerima'],
                'no_telepon'        => $validated['no_telepon'],
                'alamat_lengkap'    => $validated['alamat_lengkap'] ?? null,
                'nama_kecamatan'    => $validated['nama_kecamatan'] ?? null,
                'nama_kelurahan'    => $validated['nama_kelurahan'] ?? null,
                'kode_pos'          => $validated['kode_pos'] ?? null,
                'kendaraan'         => $validated['kendaraan'] ?? null,
                'subtotal'          => $validated['subtotal'],
                'ongkir'            => $validated['ongkir'],
                'total'             => $validated['total'],
                'status_pesanan'    => 'menunggu_konfirmasi',
            ]);

            // Ambil semua ID produk untuk query bulk (optimasi)
            $productIds = array_column($validated['items'], 'id_produk');
            $products = \App\Models\Produk::with('satuan')->whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($validated['items'] as $item) {
                // Ambil data produk asli dari DB
                $productDB = $products[$item['id_produk']] ?? null;
                $namaSatuan = $productDB && $productDB->satuan ? $productDB->satuan->nama_satuan : 'pcs';
                $jumlahSatuan = $productDB ? $productDB->jumlah_satuan : 1;

                DetailPesanan::create([
                    'id_pemesanan'   => $pemesanan->id,
                    'id_produk'      => $item['id_produk'],
                    'id_batch'       => $item['id_batch'] ?? null,
                    'nama_produk'    => $item['nama_produk'],
                    'gambar'         => $item['gambar'],
                    'quantity'       => $item['quantity'],
                    'satuan'         => $namaSatuan, // Pakai data dari DB
                    'jumlah_satuan'  => $jumlahSatuan, // Pakai data dari DB
                    'harga_satuan'   => $item['harga_satuan'],
                    'harga_total'    => $item['harga_satuan'] * $item['quantity'],
                ]);

                // KURANGI STOK BATCH
                if (!empty($item['id_batch'])) {
                    $batch = \App\Models\Batch::find($item['id_batch']);
                    if ($batch) {
                        $batch->stok = $batch->stok - $item['quantity'];
                        
                        // Update status stok
                        if ($batch->stok <= 0) {
                            $batch->status_stok = 'habis';
                        } elseif ($batch->stok <= 10) {
                            $batch->status_stok = 'menipis';
                        } else {
                            $batch->status_stok = 'tersedia';
                        }
                        
                        $batch->save();
                    }
                }
            }

            // Kosongkan session yang digunakan
            if (session()->has('buy_now')) {
                session()->forget('buy_now');
            } else {
                session()->forget('cart');
            }

            return $pemesanan;
        });

        if ($request->ajax()) {
            session()->flash('checkout_success', true);
            return response()->json([
                'success' => true,
                'redirect_url' => route('pemesanan.index')
            ]);
        }

        return redirect()
            ->route('pemesanan.index')
            ->with('checkout_success', true);
    }

    /**
     * Detail satu pesanan
     */
    public function show(Pemesanan $pemesanan)
    {
        if ($pemesanan->id_user !== Auth::id() && !(Auth::user()?->is_admin ?? false)) {
            abort(403);
        }

        $pemesanan->load('detailPesanan');
        return view('User.detailPesanan', compact('pemesanan'));
    }

    /**
     * Halaman Pembayaran User
     */
    public function pembayaran(Pemesanan $pemesanan)
    {
        if ($pemesanan->id_user !== Auth::id()) {
            abort(403);
        }
        if ($pemesanan->status_pesanan !== 'menunggu_pembayaran') {
            return redirect()->route('pemesanan.index')->with('error', 'Pesanan tidak dalam status menunggu pembayaran.');
        }

        return view('User.pembayaran', compact('pemesanan'));
    }

    /**
     * Proses Upload Bukti Pembayaran
     */
    public function prosesPembayaran(Request $request, Pemesanan $pemesanan)
    {
        if ($pemesanan->id_user !== Auth::id()) abort(403);

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Simpan file bukti
        if ($request->hasFile('bukti_pembayaran')) {
             $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
             
             // Create or Update Transaksi
             \App\Models\Transaksi::updateOrCreate(
                ['id_pemesanan' => $pemesanan->id],
                [
                    'bukti_pembayaran' => $path,
                    'status' => 'menunggu'
                ]
             );
        }

        $pemesanan->update(['status_pesanan' => 'menunggu_konfirmasi_pembayaran']);

        return redirect()->route('pemesanan.riwayat.pesanan', ['tab' => 'proses'])->with('success', 'Bukti pembayaran berhasil dikirim! Menunggu konfirmasi staff.');
    }

    /**
     * Update Status: Siapkan Pesanan -> Siap Diambil / Dikirim
     */
    public function toSiapDiambil(Pemesanan $pemesanan)
    {
        // Logic: if pickup or delivery -> siap_diambil
        $newStatus = 'siap_diambil';
        
        $pemesanan->update(['status_pesanan' => $newStatus]);
        return back()->with('success', 'Status pesanan diperbarui menjadi Siap Diambil.');
    }

    /**
     * Update Status: Siap Diambil -> Dikirim
     */
    public function toDikirim(Pemesanan $pemesanan)
    {
        $newStatus = ($pemesanan->opsi_pengiriman === 'dipick_up') ? 'selesai' : 'pesanan_telah_diambil';
        $pemesanan->update(['status_pesanan' => $newStatus]);
        
        $message = ($newStatus === 'selesai') 
            ? 'Pesanan telah selesai (diambil pelanggan).' 
            : 'Pesanan diserahkan ke kurir (Siap Diantar).';
        
        return redirect()->route('staff_purchasing.riwayat')->with('success', $message);
    }


    /**
     * Halaman Riwayat Staff Purchasing
     */
    public function riwayatPurchasing()
    {
        // 1. Dikirim
        $dikirim = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->whereIn('status_pesanan', ['dikirim', 'sedang_diantar'])
            ->latest('updated_at')
            ->get();

        // 2. Selesai
        $selesai = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'selesai')
            ->latest('updated_at')
            ->get();

        // 3. Dibatalkan
    $dibatalkan = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
        ->where('status_pesanan', 'ditolak_staff')
        ->latest('updated_at')
        ->get();

        // 4. Telah Diambil
        $telah_diambil = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'pesanan_telah_diambil')
            ->latest('updated_at')
            ->get();

        return view('Staff_Purchasing.riwayat', compact('dikirim', 'selesai', 'dibatalkan', 'telah_diambil'));
    }

    /**
     * Halaman Konfirmasi Pembayaran untuk Staff Purchasing
     */
    public function konfirmasiPembayaranPage()
    {
        $pesanan = Pemesanan::with(['user', 'detailPesanan', 'transaksi'])
            ->where('status_pesanan', 'menunggu_konfirmasi_pembayaran')
            ->latest('updated_at')
            ->get();
            
        return view('Staff_Purchasing.konfirmasiPembayaran', compact('pesanan'));
    }

    public function terimaPembayaran(Pemesanan $pemesanan)
    {
        // Masuk ke 'diproses' (Siapkan Pesanan)
        $pemesanan->update(['status_pesanan' => 'diproses']);
        return back()->with('success', 'Pembayaran diterima. Pesanan masuk ke tahap persiapan.');
    }

    public function tolakPembayaran(Pemesanan $pemesanan)
    {
        // Restore Stock
        foreach ($pemesanan->detailPesanan as $detail) {
            if ($detail->id_batch) {
                $batch = \App\Models\Batch::find($detail->id_batch);
                if ($batch) {
                    $batch->stok += $detail->quantity;

                    // Update status stok logic
                    if ($batch->stok <= 0) {
                        $batch->status_stok = 'habis';
                    } elseif ($batch->stok <= 10) {
                        $batch->status_stok = 'menipis';
                    } else {
                        $batch->status_stok = 'tersedia';
                    }
                    $batch->save();
                }
            }
        }

        $pemesanan->update(['status_pesanan' => 'dibatalkan']);
        return back()->with('success', 'Pembayaran ditolak. Pesanan dibatalkan dan stok dikembalikan.');
    }

    public function tolakPesanan(Pemesanan $pemesanan)
    {
        // Restore Stock
        foreach ($pemesanan->detailPesanan as $detail) {
            if ($detail->id_batch) {
                $batch = \App\Models\Batch::find($detail->id_batch);
                if ($batch) {
                    $batch->stok += $detail->quantity;

                    // Update status stok logic
                    if ($batch->stok <= 0) {
                        $batch->status_stok = 'habis';
                    } elseif ($batch->stok <= 10) {
                        $batch->status_stok = 'menipis';
                    } else {
                        $batch->status_stok = 'tersedia';
                    }
                    $batch->save();
                }
            }
        }

        $pemesanan->update(['status_pesanan' => 'dibatalkan']);
        return back()->with('success', 'Pesanan ditolak, dibatalkan, dan stok dikembalikan.');
    }

    // === ADMIN METHODS ===

    public function updateStatus(Request $request, Pemesanan $pemesanan)
    {
        // Jika user yang mengupdate (Riwayat Pesanan - Konfirmasi Terima)
        if ($request->status_pesanan === 'selesai' && $pemesanan->id_user === Auth::id()) {
            if (!in_array($pemesanan->status_pesanan, ['dikirim', 'sedang_diantar'])) {
                return back()->with('error', 'Status pesanan tidak valid untuk dikonfirmasi.');
            }
            $pemesanan->update(['status_pesanan' => 'selesai']);
            return back()->with('success', 'Terima kasih telah mengonfirmasi! Pesanan selesai.');
        }

        // Jika admin yang mengupdate
        $this->authorizeAdmin();

        $request->validate([
            'status_pesanan' => 'required|in:menunggu_konfirmasi,menunggu_pembayaran,diproses,dikirim,selesai,dibatalkan'
        ]);

        $pemesanan->update(['status_pesanan' => $request->status_pesanan]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function updateOngkir(Request $request, Pemesanan $pemesanan)
    {
        $this->authorizeAdmin();

        $request->validate(['ongkir' => 'required|numeric|min:0']);

        $pemesanan->update([
            'ongkir' => $request->ongkir,
            'total'  => $pemesanan->subtotal + $request->ongkir
        ]);

        return back()->with('success', 'Ongkir berhasil dikonfirmasi.');
    }

    public function updateDetail(Request $request, DetailPesanan $detail)
    {
        $this->authorizeAdmin();

        $request->validate([
            'quantity'     => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0'
        ]);

        $detail->update([
            'quantity'     => $request->quantity,
            'harga_satuan' => $request->harga_satuan,
            'harga_total'  => $request->harga_satuan * $request->quantity,
        ]);

        $pemesanan = $detail->pemesanan;
        $pemesanan->refresh();
        $pemesanan->update([
            'subtotal' => $pemesanan->detailPesanan->sum('harga_total'),
            'total'    => $pemesanan->detailPesanan->sum('harga_total') + $pemesanan->ongkir
        ]);

        return back()->with('success', 'Detail item diperbarui.');
    }

    public function deleteDetail(DetailPesanan $detail)
    {
        $this->authorizeAdmin();

        $pemesanan = $detail->pemesanan;
        $detail->delete();

        $pemesanan->refresh();
        $pemesanan->update([
            'subtotal' => $pemesanan->detailPesanan->sum('harga_total'),
            'total'    => $pemesanan->detailPesanan->sum('harga_total') + $pemesanan->ongkir
        ]);

        return back()->with('success', 'Item berhasil dihapus dari pesanan.');
    }

    /**
     * User batalkan pesanan
     */
    public function destroy(Pemesanan $pemesanan)
    {
        if ($pemesanan->id_user !== Auth::id()) {
            abort(403);
        }

        if ($pemesanan->status_pesanan !== 'menunggu_konfirmasi') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        // Restore Stock
        foreach ($pemesanan->detailPesanan as $detail) {
            if ($detail->id_batch) {
                $batch = \App\Models\Batch::find($detail->id_batch);
                if ($batch) {
                    $batch->stok += $detail->quantity;

                    // Update status stok logic (same as in store method but reverse check essentially)
                    if ($batch->stok <= 0) {
                        $batch->status_stok = 'habis';
                    } elseif ($batch->stok <= 10) {
                        $batch->status_stok = 'menipis';
                    } else {
                        $batch->status_stok = 'tersedia';
                    }
                    $batch->save();
                }
            }
        }

        $pemesanan->update(['status_pesanan' => 'dibatalkan']);

        return redirect()->route('pemesanan.index')->with('success', 'Pesanan berhasil dibatalkan.');
    }



    public function detailPengirimanKurir(Pemesanan $pemesanan)
    {
        $pemesanan->load(['user', 'detailPesanan.produk', 'alamat']);
        return view('Kurir.lihatDetail', compact('pemesanan'));
    }

    // Helper untuk cek admin
    private function authorizeAdmin()
    {
        if (!(Auth::user()?->is_admin ?? false)) {
            abort(403);
        }
    }
}
