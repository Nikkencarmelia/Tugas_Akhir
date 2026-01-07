<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\DetailPesanan;
use App\Models\Kecamatan;
use App\Models\Kurir as KurirModel;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use App\Models\TugasKurir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    private function restoreStock(Pemesanan $pemesanan)
    {
        foreach ($pemesanan->detailPesanan as $detail) {
            if ($detail->id_batch) {
                $batch = Batch::find($detail->id_batch);
                if ($batch) {
                    $batch->stok += $detail->quantity;

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

    private function authorizeAdmin()
    {
        if (! (Auth::user()?->is_admin ?? false)) {
            abort(403);
        }
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $search = $request->get('search');
        $sort = $request->get('sort', 'terbaru');

        $queryBuilder = function ($statuses) use ($userId, $search, $sort) {
            $q = Pemesanan::with('detailPesanan')
                ->where('id_user', $userId)
                ->whereIn('status_pesanan', (array) $statuses);

            if ($search) {
                $q->where(function ($sq) use ($search) {
                    $sq->where('kode_pesanan', 'LIKE', "%{$search}%")
                        ->orWhereHas('detailPesanan', function ($dq) use ($search) {
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

        $konfirmasi_pesanan = $queryBuilder(['menunggu_konfirmasi', 'menunggu_cari_kurir', 'menunggu_konfirmasi_kurir', 'ditolak_kurir'])
            ->paginate(10, ['*'], 'page_konfirmasi');

        $menunggu_pembayaran = $queryBuilder(['menunggu_pembayaran'])
            ->paginate(10, ['*'], 'page_menunggu');

        $diproses = $queryBuilder(['menunggu_konfirmasi_pembayaran', 'diproses', 'siap_diambil'])
            ->paginate(10, ['*'], 'page_proses');

        $dikirim = $queryBuilder(['dikirim', 'sedang_diantar', 'pesanan_telah_diambil'])
            ->paginate(10, ['*'], 'page_dikirim');

        $selesai = $queryBuilder(['selesai'])
            ->paginate(10, ['*'], 'page_selesai');

        $dibatalkan = $queryBuilder(['dibatalkan', 'ditolak_staff'])
            ->paginate(10, ['*'], 'page_dibatalkan');

        $counts = [
            'konfirmasi' => $queryBuilder(['menunggu_konfirmasi', 'menunggu_cari_kurir', 'menunggu_konfirmasi_kurir', 'ditolak_kurir'])->count(),
            'menunggu' => $queryBuilder(['menunggu_pembayaran'])->count(),
            'proses' => $queryBuilder(['menunggu_konfirmasi_pembayaran', 'diproses', 'siap_diambil'])->count(),
            'dikirim' => $queryBuilder(['dikirim', 'sedang_diantar', 'pesanan_telah_diambil'])->count(),
            'selesai' => $queryBuilder(['selesai'])->count(),
            'dibatalkan' => $queryBuilder(['dibatalkan', 'ditolak_staff'])->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'konfirmasi' => view('User.partials._order_list', ['collection' => $konfirmasi_pesanan, 'title' => 'menunggu konfirmasi'])->render(),
                'menunggu' => view('User.partials._order_list', ['collection' => $menunggu_pembayaran, 'title' => 'menunggu pembayaran'])->render(),
                'proses' => view('User.partials._order_list', ['collection' => $diproses, 'title' => 'sedang diproses'])->render(),
                'dikirim' => view('User.partials._order_list', ['collection' => $dikirim, 'title' => 'sedang dikirim'])->render(),
                'selesai' => view('User.partials._order_list', ['collection' => $selesai, 'title' => 'selesai'])->render(),
                'dibatalkan' => view('User.partials._order_list', ['collection' => $dibatalkan, 'title' => 'dibatalkan atau ditolak'])->render(),
                'counts' => $counts,
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

    public function checkout(Request $request)
    {
        $checkout = session('buy_now', []);

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
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong atau tidak ada item yang dipilih.');
        }

        $subtotal = 0;
        $originalSubtotal = 0;
        foreach ($checkout as $item) {
            $harga_satuan = $item['harga'] ?? $item['harga_satuan'] ?? 0;
            $subtotal += $harga_satuan * $item['quantity'];
        }

        $productIds = array_unique(array_filter(array_map(function ($item) {
            return $item['product_id'] ?? $item['id_produk'] ?? null;
        }, $checkout)));

        $products = \App\Models\Produk::with('satuan')->whereIn('id', $productIds)->get()->keyBy('id');

        $itemsCheckout = [];
        foreach ($checkout as $key => &$item) {
            $pid = $item['product_id'] ?? $item['id_produk'] ?? null;
            $bid = $item['batch_id'] ?? $item['id_batch'] ?? null;
            $product = $products[$pid] ?? null;

            $namaSatuan = $product && $product->satuan ? $product->satuan->nama_satuan : ($item['satuan_berat'] ?? 'pcs');
            $jumlahSatuan = $product ? $product->jumlah_satuan : 1;

            $batch = $bid ? Batch::find($bid) : null;
            $hargaNormal = $batch ? $batch->harga_normal : ($item['harga'] ?? $item['harga_satuan'] ?? 0);
            $hargaSaatIni = $item['harga'] ?? $item['harga_satuan'] ?? 0;
            $hargaAwal = ($hargaNormal > $hargaSaatIni) ? $hargaNormal : null;

            $item['harga_awal'] = $hargaAwal;
            $originalSubtotal += ($hargaAwal ?? $hargaSaatIni) * ($item['quantity'] ?? 1);

            $itemsCheckout[] = [
                'id_produk' => $pid,
                'id_batch' => $bid,
                'nama_produk' => $item['nama_produk'] ?? '',
                'gambar' => $item['gambar'] ?? '',
                'quantity' => $item['quantity'] ?? 1,
                'satuan' => $namaSatuan,
                'jumlah_satuan' => $jumlahSatuan,
                'harga_satuan' => $hargaSaatIni,
                'harga' => $hargaSaatIni,
                'harga_awal' => $hargaAwal,
            ];
        }
        unset($item);

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'opsi_pengiriman' => 'required|in:diantar,dipick_up',
            'nama_penerima' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'id_alamat' => 'nullable|exists:alamats,id',
            'alamat_lengkap' => 'nullable|required_if:opsi_pengiriman,diantar|string|max:1000',
            'nama_kecamatan' => 'nullable|required_if:opsi_pengiriman,diantar|string|max:100',
            'nama_kelurahan' => 'nullable|required_if:opsi_pengiriman,diantar|string|max:100',
            'kode_pos' => 'nullable|required_if:opsi_pengiriman,diantar|string|max:10',
            'kendaraan' => 'nullable|in:Mobil,Motor',
            'ongkir' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id_produk' => 'required|exists:produks,id',
            'items.*.id_batch' => 'nullable|exists:batches,id',
            'items.*.nama_produk' => 'required|string',
            'items.*.gambar' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.satuan' => 'nullable|string',
            'items.*.jumlah_satuan' => 'nullable|numeric',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        if ($validated['opsi_pengiriman'] === 'dipick_up') {
            $validated['ongkir'] = 0;
            $validated['kendaraan'] = null;
        }

        $pemesanan = DB::transaction(function () use ($validated) {
            $pemesanan = Pemesanan::create([
                'id_user' => Auth::id(),
                'id_alamat' => $validated['id_alamat'] ?? null,
                'kode_pesanan' => 'ORD-'.now()->format('dmY').'-'.str_pad(Pemesanan::count() + 1, 3, '0', STR_PAD_LEFT),
                'opsi_pengiriman' => $validated['opsi_pengiriman'],
                'nama_penerima' => $validated['nama_penerima'],
                'no_telepon' => $validated['no_telepon'],
                'alamat_lengkap' => $validated['alamat_lengkap'] ?? null,
                'nama_kecamatan' => $validated['nama_kecamatan'] ?? null,
                'nama_kelurahan' => $validated['nama_kelurahan'] ?? null,
                'kode_pos' => $validated['kode_pos'] ?? null,
                'kendaraan' => $validated['kendaraan'] ?? null,
                'subtotal' => $validated['subtotal'],
                'ongkir' => $validated['ongkir'],
                'total' => $validated['total'],
                'status_pesanan' => 'menunggu_konfirmasi',
            ]);

            $productIds = array_column($validated['items'], 'id_produk');
            $products = \App\Models\Produk::with('satuan')->whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($validated['items'] as $item) {
                $productDB = $products[$item['id_produk']] ?? null;
                $namaSatuan = $productDB && $productDB->satuan ? $productDB->satuan->nama_satuan : 'pcs';
                $jumlahSatuan = $productDB ? $productDB->jumlah_satuan : 1;

                DetailPesanan::create([
                    'id_pemesanan' => $pemesanan->id,
                    'id_produk' => $item['id_produk'],
                    'id_batch' => $item['id_batch'] ?? null,
                    'nama_produk' => $item['nama_produk'],
                    'gambar' => $item['gambar'],
                    'quantity' => $item['quantity'],
                    'satuan' => $namaSatuan,
                    'jumlah_satuan' => $jumlahSatuan,
                    'harga_satuan' => $item['harga_satuan'],
                    'harga_total' => $item['harga_satuan'] * $item['quantity'],
                ]);

                if (! empty($item['id_batch'])) {
                    $batch = Batch::find($item['id_batch']);
                    if ($batch) {
                        $batch->stok = $batch->stok - $item['quantity'];
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
                'redirect_url' => route('pemesanan.index'),
            ]);
        }

        return redirect()->route('pemesanan.index')->with('checkout_success', true);
    }

    public function show(Pemesanan $pemesanan)
    {
        if ($pemesanan->id_user !== Auth::id() && ! (Auth::user()?->is_admin ?? false)) {
            abort(403);
        }

        $pemesanan->load('detailPesanan');

        return view('User.detailPesanan', compact('pemesanan'));
    }

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

    public function prosesPembayaran(Request $request, Pemesanan $pemesanan)
    {
        if ($pemesanan->id_user !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            Transaksi::updateOrCreate(
                ['id_pemesanan' => $pemesanan->id],
                ['bukti_pembayaran' => $path]
            );
        }

        $pemesanan->update(['status_pesanan' => 'menunggu_konfirmasi_pembayaran']);

        return redirect()->route('pemesanan.index', ['tab' => 'proses'])->with('success', 'Bukti pembayaran berhasil dikirim! Menunggu konfirmasi staff.');
    }

    public function destroy(Pemesanan $pemesanan)
    {
        if ($pemesanan->id_user !== Auth::id()) {
            abort(403);
        }

        if ($pemesanan->status_pesanan !== 'menunggu_konfirmasi') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        $this->restoreStock($pemesanan);
        $pemesanan->update(['status_pesanan' => 'dibatalkan']);

        return redirect()->route('pemesanan.index', ['tab' => 'dibatalkan'])->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function dashboardPurchasing()
    {
        $pesanan_masuk_count = Pemesanan::where('status_pesanan', 'menunggu_konfirmasi')->count();
        $konfirmasi_pembayaran_count = Pemesanan::where('status_pesanan', 'menunggu_konfirmasi_pembayaran')->count();
        $menunggu_pembayaran_count = Pemesanan::where('status_pesanan', 'menunggu_pembayaran')->count();
        $belum_kurir_count = Pemesanan::where('status_pesanan', 'menunggu_cari_kurir')->count();
        $ditolak_kurir_count = Pemesanan::where('status_pesanan', 'ditolak_kurir')->count();
        $kecamatans_count = Kecamatan::count();

        return view('Staff_Purchasing.dashboard', compact(
            'pesanan_masuk_count',
            'konfirmasi_pembayaran_count',
            'menunggu_pembayaran_count',
            'belum_kurir_count',
            'ditolak_kurir_count',
            'kecamatans_count'
        ));
    }

    public function pesananMasuk()
    {
        $pengiriman_masuk = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'menunggu_konfirmasi')
            ->latest('updated_at')
            ->get();

        return view('Staff_Purchasing.pesananMasuk', compact('pengiriman_masuk'));
    }

    public function showPurchasing(Pemesanan $pemesanan)
    {
        return view('Staff_Purchasing.detailPesanan', compact('pemesanan'));
    }

    public function terimaPesanan(Request $request, Pemesanan $pemesanan)
    {
        if ($pemesanan->status_pesanan == 'menunggu_konfirmasi') {
            if ($pemesanan->opsi_pengiriman == 'dipick_up') {
                $pemesanan->update(['status_pesanan' => 'menunggu_pembayaran']);

                return back()->with('success', 'Pesanan Pick Up diterima. Menunggu pembayaran user.');
            } else {
                $pemesanan->update(['status_pesanan' => 'menunggu_cari_kurir']);

                return back()->with('success', 'Pesanan diterima. Silakan cari kurir.');
            }
        }

        return back()->with('error', 'Status pesanan tidak valid untuk diterima.');
    }

    public function terimaSemuaPesanan()
    {
        DB::transaction(function () {
            Pemesanan::where('status_pesanan', 'menunggu_konfirmasi')
                ->where('opsi_pengiriman', 'dipick_up')
                ->update(['status_pesanan' => 'menunggu_pembayaran']);

            Pemesanan::where('status_pesanan', 'menunggu_konfirmasi')
                ->where('opsi_pengiriman', '!=', 'dipick_up')
                ->update(['status_pesanan' => 'menunggu_cari_kurir']);
        });

        return back()->with('success', 'Semua pesanan berhasil diterima.');
    }

    public function terimaDipilih(Request $request)
    {
        $request->validate(['order_ids' => 'required|array']);
        $orderIds = $request->order_ids;

        DB::transaction(function () use ($orderIds) {
            Pemesanan::whereIn('id', $orderIds)
                ->where('status_pesanan', 'menunggu_konfirmasi')
                ->where('opsi_pengiriman', 'dipick_up')
                ->update(['status_pesanan' => 'menunggu_pembayaran']);

            Pemesanan::whereIn('id', $orderIds)
                ->where('status_pesanan', 'menunggu_konfirmasi')
                ->where('opsi_pengiriman', '!=', 'dipick_up')
                ->update(['status_pesanan' => 'menunggu_cari_kurir']);
        });

        return back()->with('success', 'Pesanan terpilih berhasil diterima.');
    }

    public function tolakDipilihStaff(Request $request)
    {
        $request->validate(['order_ids' => 'required|array']);
        $orderIds = $request->order_ids;

        DB::transaction(function () use ($orderIds) {
            $orders = Pemesanan::whereIn('id', $orderIds)->where('status_pesanan', 'menunggu_konfirmasi')->get();
            foreach ($orders as $order) {
                $this->restoreStock($order);
                $order->update(['status_pesanan' => 'ditolak_staff']);
            }
        });

        return back()->with('success', 'Pesanan terpilih berhasil ditolak.');
    }

    public function tolakPesanan(Pemesanan $pemesanan)
    {
        $this->restoreStock($pemesanan);
        $pemesanan->update(['status_pesanan' => 'ditolak_staff']);

        return back()->with('success', 'Pesanan ditolak dan stok dikembalikan.');
    }

    public function cariKurir()
    {
        $pesanan_baru = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'menunggu_cari_kurir')
            ->latest('updated_at')
            ->get();

        $menunggu_konfirmasi = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat', 'kurir'])
            ->where('status_pesanan', 'menunggu_konfirmasi_kurir')
            ->latest('updated_at')
            ->get();

        $ditolak_kurir = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'ditolak_kurir')
            ->latest('updated_at')
            ->get();

        $kurirs = User::where('role', 'kurir')
            ->whereHas('kurir', function ($query) {
                $query->whereNotNull('jenis_kendaraan');
            })->with('kurir')->get();

        return view('Staff_Purchasing.cariKurir', compact('pesanan_baru', 'menunggu_konfirmasi', 'ditolak_kurir', 'kurirs'));
    }

    public function assignKurir(Request $request)
    {
        $request->validate([
            'kode_pesanan' => 'required',
            'id_kurir' => 'required|exists:users,id',
        ]);

        $pemesanan = Pemesanan::where('kode_pesanan', $request->kode_pesanan)->firstOrFail();
        $pemesanan->update([
            'id_kurir' => $request->id_kurir,
            'status_pesanan' => 'menunggu_konfirmasi_kurir',
        ]);

        return back()->with('success', 'Kurir berhasil dipilih. Menunggu konfirmasi kurir.');
    }

    public function pesananBerjalan()
    {
        $menunggu_pembayaran = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->whereIn('status_pesanan', ['menunggu_pembayaran', 'menunggu_verifikasi_pembayaran'])
            ->latest('updated_at')
            ->get();

        $siapkan_pesanan = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'diproses')
            ->latest('updated_at')
            ->get();

        $siap_diambil = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'siap_diambil')
            ->latest('updated_at')
            ->get();

        return view('Staff_Purchasing.pesananBerjalan', compact('menunggu_pembayaran', 'siapkan_pesanan', 'siap_diambil'));
    }

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
        $pemesanan->update(['status_pesanan' => 'diproses']);

        return back()->with('success', 'Pembayaran diterima. Pesanan masuk ke tahap persiapan.');
    }

    public function tolakPembayaran(Pemesanan $pemesanan)
    {
        $this->restoreStock($pemesanan);
        $pemesanan->update(['status_pesanan' => 'ditolak_staff']);

        return back()->with('success', 'Pembayaran ditolak. Pesanan dibatalkan dan stok dikembalikan.');
    }

    public function toSiapDiambil(Pemesanan $pemesanan)
    {
        $pemesanan->update(['status_pesanan' => 'siap_diambil']);

        return back()->with('success', 'Status pesanan diperbarui menjadi Siap Diambil.');
    }

    public function toDikirim(Pemesanan $pemesanan)
    {
        $newStatus = ($pemesanan->opsi_pengiriman === 'dipick_up') ? 'selesai' : 'pesanan_telah_diambil';
        $pemesanan->update(['status_pesanan' => $newStatus]);

        $message = ($newStatus === 'selesai')
            ? 'Pesanan telah selesai (diambil pelanggan).'
            : 'Pesanan diserahkan ke kurir (Siap Diantar).';

        return back()->with('success', $message);
    }

    public function riwayatPurchasing()
    {
        $dikirim = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->whereIn('status_pesanan', ['dikirim', 'sedang_diantar'])
            ->latest('updated_at')
            ->get();

        $selesai = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'selesai')
            ->latest('updated_at')
            ->get();

        $dibatalkan = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat', 'transaksi'])
            ->whereIn('status_pesanan', ['dibatalkan', 'ditolak_staff', 'ditolak_kurir'])
            ->latest('updated_at')
            ->get();

        $telah_diambil = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('status_pesanan', 'pesanan_telah_diambil')
            ->latest('updated_at')
            ->get();

        return view('Staff_Purchasing.riwayat', compact('dikirim', 'selesai', 'dibatalkan', 'telah_diambil'));
    }

    public function pengirimanMasukKurir()
    {
        $pengiriman_masuk = Pemesanan::with(['detailPesanan.produk', 'user', 'alamat'])
            ->where('id_kurir', Auth::id())
            ->where('status_pesanan', 'menunggu_konfirmasi_kurir')
            ->latest('updated_at')
            ->get();

        return view('Kurir.pengirimanMasuk', compact('pengiriman_masuk'));
    }

    public function detailPengirimanKurir(Pemesanan $pemesanan)
    {
        $pemesanan->load(['user', 'detailPesanan.produk', 'alamat']);

        return view('Kurir.lihatDetail', compact('pemesanan'));
    }

    public function kurirTerima(Request $request, Pemesanan $pemesanan)
    {
        $pemesanan->update(['status_pesanan' => 'menunggu_pembayaran']);

        return back()->with('success', 'Pesanan diterima.');
    }

    public function kurirTolak(Request $request, Pemesanan $pemesanan)
    {
        TugasKurir::create([
            'id_pemesanan' => $pemesanan->id,
            'id_kurir' => Auth::id(),
        ]);

        $pemesanan->update([
            'status_pesanan' => 'ditolak_kurir',
            'id_kurir' => null,
        ]);

        return back()->with('success', 'Pengiriman ditolak.');
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

        foreach ($orders as $order) {
            TugasKurir::create([
                'id_pemesanan' => $order->id,
                'id_kurir' => Auth::id(),
            ]);
            $order->update([
                'status_pesanan' => 'ditolak_kurir',
                'id_kurir' => null,
            ]);
        }

        return back()->with('success', 'Pesananilih berhasil ditolak.');
    }

    public function kurirTerimaSemua()
    {
        Pemesanan::where('id_kurir', Auth::id())
            ->where('status_pesanan', 'menunggu_konfirmasi_kurir')
            ->update(['status_pesanan' => 'menunggu_pembayaran']);

        return back()->with('success', 'Semua pesanan berhasil diterima.');
    }

    public function kurirTolakSemua()
    {
        $orders = Pemesanan::where('id_kurir', Auth::id())
            ->where('status_pesanan', 'menunggu_konfirmasi_kurir')
            ->get();

        foreach ($orders as $order) {
            TugasKurir::create(['id_pemesanan' => $order->id, 'id_kurir' => Auth::id()]);
            $order->update(['status_pesanan' => 'ditolak_kurir', 'id_kurir' => null]);
        }

        return back()->with('success', 'Semua pesanan berhasil ditolak.');
    }

    public function statusPengirimanKurir()
    {
        $userId = Auth::id();
        $menunggu_pengiriman = Pemesanan::with(['user', 'detailPesanan.produk', 'alamat'])
            ->where('id_kurir', $userId)
            ->whereIn('status_pesanan', [
                'menunggu_pembayaran',
                'menunggu_konfirmasi_pembayaran',
                'diproses',
                'siap_diambil',
                'pesanan_telah_diambil',
            ])
            ->latest('updated_at')
            ->get()
            ->sortByDesc(fn ($order) => $order->status_pesanan === 'pesanan_telah_diambil' ? 1 : 0);

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
        $kurir = KurirModel::where('id_user', Auth::id())->first();
        if ($kurir) {
            $kurir->syncStatus();
        }

        return back()->with('success', 'Pesanan berhasil dikirim.');
    }

    public function kurirSelesai(Pemesanan $pemesanan)
    {
        $pemesanan->update(['status_pesanan' => 'selesai']);
        $kurir = KurirModel::where('id_user', Auth::id())->first();
        if ($kurir) {
            $kurir->syncStatus();
        }

        return back()->with('success', 'Pesanan selesai (sudah sampai).');
    }

    public function riwayatPengirimanKurir()
    {
        $userId = Auth::id();
        $selesai = Pemesanan::with(['user', 'detailPesanan.produk', 'alamat'])
            ->where('id_kurir', $userId)
            ->where('status_pesanan', 'selesai')
            ->latest('updated_at')
            ->get();

        $riwayat_p = Pemesanan::with(['user', 'detailPesanan.produk', 'alamat'])
            ->where('id_kurir', $userId)
            ->whereIn('status_pesanan', ['dibatalkan', 'ditolak_staff'])
            ->get();

        $riwayat_t = TugasKurir::with(['pemesanan.user', 'pemesanan.detailPesanan.produk', 'pemesanan.alamat'])
            ->where('id_kurir', $userId)
            ->get();

        $dibatalkan = $riwayat_p->concat($riwayat_t)->sortByDesc(fn ($item) => $item->updated_at);

        return view('Kurir.riwayat', compact('selesai', 'dibatalkan'));
    }

    public function updateStatus(Request $request, Pemesanan $pemesanan)
    {
        if ($request->status_pesanan === 'selesai' && $pemesanan->id_user === Auth::id()) {
            if (! in_array($pemesanan->status_pesanan, ['dikirim', 'sedang_diantar'])) {
                return back()->with('error', 'Status pesanan tidak valid untuk dikonfirmasi.');
            }
            $pemesanan->update(['status_pesanan' => 'selesai']);

            return back()->with('success', 'Terima kasih telah mengonfirmasi! Pesanan selesai.');
        }

        $this->authorizeAdmin();
        $request->validate([
            'status_pesanan' => 'required|in:menunggu_konfirmasi,menunggu_pembayaran,diproses,dikirim,selesai,dibatalkan',
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
            'total' => $pemesanan->subtotal + $request->ongkir,
        ]);

        return back()->with('success', 'Ongkir berhasil dikonfirmasi.');
    }

    public function updateDetail(Request $request, DetailPesanan $detail)
    {
        $this->authorizeAdmin();
        $request->validate(['quantity' => 'required|integer|min:1', 'harga_satuan' => 'required|numeric|min:0']);
        $detail->update([
            'quantity' => $request->quantity,
            'harga_satuan' => $request->harga_satuan,
            'harga_total' => $request->harga_satuan * $request->quantity,
        ]);

        $pemesanan = $detail->pemesanan;
        $pemesanan->refresh();
        $pemesanan->update([
            'subtotal' => $pemesanan->detailPesanan->sum('harga_total'),
            'total' => $pemesanan->detailPesanan->sum('harga_total') + $pemesanan->ongkir,
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
            'total' => $pemesanan->detailPesanan->sum('harga_total') + $pemesanan->ongkir,
        ]);

        return back()->with('success', 'Item berhasil dihapus.');
    }
}
