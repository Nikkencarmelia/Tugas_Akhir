<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class BatchController extends Controller
{
    public function index($id_produk, Request $request)
    {
        // SET REFERRER KE SESSION (dari query param 'from' + query string lain)
        $referrerRoute = $request->query('from', 'produk.data');  // Default ke data produk
        $queryParams = $request->except(['from']);  // Ambil semua query kecuali 'from' (misalnya page=2&search=foo)
        Session::put('batch_referrer', [
            'route' => $referrerRoute,
            'query' => $queryParams
        ]);

        $produk = Produk::with(['kategori','supplier','satuan'])->findOrFail($id_produk);

        $batches = Batch::where('id_produk', $id_produk)
            ->latest()
            ->get()
            ->map(function ($batch) {

                // FORMAT TANGGAL
                $batch->tgl_masuk_format = Carbon::parse($batch->tgl_masuk)->format('d/m/Y');
                $batch->tgl_kadaluarsa_format = Carbon::parse($batch->tgl_kadaluwarsa)->format('d/m/Y');
                $batch->tgl_perubahan_format = $batch->tgl_perubahan_harga ? Carbon::parse($batch->tgl_perubahan_harga)->format('d/m/Y H:i') : '-';

                // SISA HARI
                $today = Carbon::today();
                $exp = Carbon::parse($batch->tgl_kadaluwarsa)->startOfDay();
                $diff = $today->diffInDays($exp, false);

                if ($diff < 0) {
                    $batch->sisa_text = abs($diff).' hari lalu';
                    $batch->sisa_color = 'text-danger';
                } elseif ($diff === 0) {
                    $batch->sisa_text = 'Hari ini';
                    $batch->sisa_color = 'text-warning';
                } elseif ($diff <= 7) {
                    $batch->sisa_text = $diff.' hari lagi';
                    $batch->sisa_color = 'text-warning';
                } else {
                    $batch->sisa_text = $diff.' hari lagi';
                    $batch->sisa_color = 'text-success';
                }

                // FORMAT HARGA
                $batch->harga_normal_rp = 'Rp '.number_format($batch->harga_normal,0,',','.');
                $batch->harga_saat_ini_rp = 'Rp '.number_format($batch->harga_saat_ini,0,',','.');

                // KETERANGAN HARGA
                if ($batch->harga_saat_ini < $batch->harga_normal) {
                    $pct = round((($batch->harga_normal - $batch->harga_saat_ini) / $batch->harga_normal) * 100);
                    $batch->keterangan = "Diskon {$pct}%";
                } elseif ($batch->harga_saat_ini > $batch->harga_normal) {
                    $pct = round((($batch->harga_saat_ini - $batch->harga_normal) / $batch->harga_normal) * 100);
                    $batch->keterangan = "Naik {$pct}%";
                } else {
                    $batch->keterangan = 'Normal';
                }

                // STATUS STOK
                if ($batch->stok <= 0) {
                    $batch->status_stok_text = 'Habis';
                    $batch->status_stok_badge = 'badge-habis';
                } elseif ($batch->stok <= 10) {
                    $batch->status_stok_text = 'Menipis';
                    $batch->status_stok_badge = 'badge-menipis';
                } else {
                    $batch->status_stok_text = 'Tersedia';
                    $batch->status_stok_badge = 'badge-tersedia';
                }

                return $batch;
            });

        $total_stok = $batches->sum('stok');
        $status_stok = $total_stok <= 0 ? 'Habis' : ($total_stok <= 10 ? 'Menipis' : 'Tersedia');

        // DEFAULT UNTUK FORM
        $default_kadaluarsa = $produk->estimasi_kadaluwarsa_hari
            ? Carbon::today()->addDays($produk->estimasi_kadaluwarsa_hari)->format('Y-m-d')
            : '';

        return view('Staff_Produk.batchStok', compact(
            'produk',
            'batches',
            'total_stok',
            'status_stok',
            'default_kadaluarsa'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produks,id',
            'stok' => 'required|integer|min:1',
            'tgl_masuk' => 'nullable|date',
            'tgl_kadaluwarsa' => 'nullable|date|after_or_equal:tgl_masuk',
            'harga_normal' => 'required|integer|min:0',
            'harga_saat_ini' => 'required|integer|min:0',
        ]);

        $produk = Produk::findOrFail($request->id_produk);

        // ✅ tanggal masuk
        $tglMasuk = $request->tgl_masuk
            ? Carbon::parse($request->tgl_masuk)
            : Carbon::today();

        // ✅ Gunakan input dari form jika ada, jika tidak hitung otomatis
        if ($request->filled('tgl_kadaluwarsa')) {
            $tglKadaluwarsa = Carbon::parse($request->tgl_kadaluwarsa);
        } else {
            // Hitung otomatis jika tidak ada input
            if (!$produk->estimasi_kadaluwarsa_hari || $produk->estimasi_kadaluwarsa_hari < 1) {
                return back()->with('error', 'Produk belum punya estimasi kadaluarsa. Silakan isi tanggal kadaluarsa secara manual.');
            }
            $tglKadaluwarsa = $tglMasuk->copy()->addDays($produk->estimasi_kadaluwarsa_hari);
        }

        Batch::create([
            'id_produk' => $produk->id,
            'tgl_masuk' => $tglMasuk,
            'tgl_kadaluwarsa' => $tglKadaluwarsa,
            'stok' => $request->stok,
            'harga_normal' => $request->harga_normal,
            'harga_saat_ini' => $request->harga_saat_ini,
            'tgl_perubahan_harga' => now(),
            'status_stok' => $this->hitungStatusStok($request->stok),
            'keterangan_harga' => 'normal',
        ]);

        return back()->with('success', 'Batch berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);

        $request->validate([
            'tgl_kadaluwarsa' => 'required|date',
            'stok' => 'required|integer|min:0',
            'harga_normal' => 'required|integer|min:0',
            'harga_saat_ini' => 'required|integer|min:0',
        ]);

        $priceChanged = ((float)$batch->harga_normal !== (float)$request->harga_normal || (float)$batch->harga_saat_ini !== (float)$request->harga_saat_ini);

        $data = [
            'tgl_kadaluwarsa' => $request->tgl_kadaluwarsa,
            'stok' => $request->stok,
            'harga_normal' => $request->harga_normal,
            'harga_saat_ini' => $request->harga_saat_ini,
            'status_stok' => $this->hitungStatusStok($request->stok),
        ];

        if ($priceChanged) {
            $data['tgl_perubahan_harga'] = now();
            
            if ($request->harga_saat_ini < $request->harga_normal) {
                $data['keterangan_harga'] = 'diskon';
            } elseif ($request->harga_saat_ini > $request->harga_normal) {
                $data['keterangan_harga'] = 'harga naik';
            } else {
                $data['keterangan_harga'] = 'normal';
            }
        }

        $batch->update($data);

        return back()->with('success', 'Batch berhasil diupdate');
    }

    public function destroy($id)
    {
        Batch::findOrFail($id)->delete();
        return back()->with('success', 'Batch berhasil dihapus');
    }

    public function applyDiscount(Request $request, $id)
    {
        $request->validate([
            'diskon_percent' => 'required|numeric|min:0|max:100',
        ]);

        $batch = Batch::findOrFail($id);
        $diskonPercent = $request->diskon_percent;

        // Hitung harga setelah diskon
        $hargaSetelahDiskon = $batch->harga_normal - ($batch->harga_normal * $diskonPercent / 100);
        $hargaSetelahDiskon = round($hargaSetelahDiskon);

        // Update batch
        $batch->update([
            'harga_saat_ini' => $hargaSetelahDiskon,
            'tgl_perubahan_harga' => now(),
            'keterangan_harga' => 'diskon',
        ]);

        return back()->with('success', "Diskon {$diskonPercent}% berhasil diterapkan. Harga baru: Rp " . number_format($hargaSetelahDiskon, 0, ',', '.'));
    }

    public function increasePrice(Request $request, $id)
    {
        $request->validate([
            'harga_saat_ini' => 'required|numeric|min:0',
        ]);

        $batch = Batch::findOrFail($id);
        $hargaBaru = (int) $request->harga_saat_ini;  // Cast ke integer untuk konsistensi dengan schema int(11)

        // Hitung persentase perubahan untuk display (dari harga normal, seperti logic di view)
        $pct = $batch->harga_normal > 0 ? round((($hargaBaru - $batch->harga_normal) / $batch->harga_normal * 100)) : 0;
        $keteranganDisplay = $pct > 0 ? "Naik {$pct}%" : "Harga Diperbarui";

        // Simpan code pendek ke DB (konsisten dengan ENUM-like: 'normal', 'diskon', 'naik')
        $keteranganHarga = $pct > 0 ? 'harga naik' : 'normal';

        // Update batch
        $batch->update([
            'harga_saat_ini' => $hargaBaru,
            'tgl_perubahan_harga' => now(),
            'keterangan_harga' => $keteranganHarga,
        ]);

        return back()->with('success', "Harga baru Rp " . number_format($hargaBaru, 0, ',', '.') . " berhasil diterapkan. Keterangan: {$keteranganDisplay}.");
    }

    private function hitungStatusStok($stok)
    {
        if ($stok <= 0) return 'habis';
        if ($stok <= 10) return 'menipis';
        return 'tersedia';
    }

    public function produkDiskon()
    {
        $produkDiskon = Produk::whereHas('batch', function ($q) {
            $q->whereColumn('harga_saat_ini', '<', 'harga_normal');
        })
        ->with(['kategori', 'supplier', 'satuan', 'batch'])
        ->get()
        ->map(function ($produk) {
            // Hitung total stok HANYA dari batch yang sedang diskon (harga_saat_ini < harga_normal)
            $diskonStok = $produk->batch->filter(function ($batch) {
                return $batch->harga_saat_ini < $batch->harga_normal;
            })->sum('stok') ?? 0;
            $produk->stok = $diskonStok;

            // Status stok overall (berdasarkan stok diskon saja)
            $statusStok = $diskonStok <= 0 ? 'Habis' : ($diskonStok <= 10 ? 'Menipis' : 'Tersedia');
            $produk->status_stok = $statusStok;

            // Status tampil (asumsi field di DB, atau default)
            $produk->status_tampil = $produk->status_tampil ?? 'Ditampilkan';

            // Jumlah batch diskon saja (opsional, tapi sesuai tema)
            $produk->jumlah_batch = $produk->batch->filter(function ($batch) {
                return $batch->harga_saat_ini < $batch->harga_normal;
            })->count();

            // Fallback untuk satuan (match dengan view data produk)
            $produk->jumlah_satuan = $produk->jumlah_satuan ?? 1;
            $produk->nama_satuan = $produk->satuan ? $produk->satuan->nama_satuan : 'Pcs';

            // Fallback untuk kategori (lebih robust untuk handle berbagai nama field)
            $kategoriNama = '-';
            if ($produk->kategori) {
                $kategoriNama = $produk->kategori->nama_kategori ?? $produk->kategori->name ?? $produk->kategori->nama ?? '-';
            }
            $produk->kategori = $kategoriNama;

            // Fallback untuk supplier (lebih robust untuk handle berbagai nama field)
            $supplierNama = '-';
            if ($produk->supplier) {
                $supplierNama = $produk->supplier->nama_supplier ?? $produk->supplier->name ?? $produk->supplier->nama ?? '-';
            }
            $produk->supplier = $supplierNama;

            // Fallback field lain (buat JS view)
            // Gambar: pastikan path full (gunakan asset() jika di public/storage)
            $gambarPath = $produk->gambar;
            if ($gambarPath && !str_starts_with($gambarPath, 'http') && !str_starts_with($gambarPath, '/')) {
                $gambarPath = asset('storage/' . $gambarPath);  // Asumsi gambar di storage/app/public; sesuaikan jika beda (e.g., 'images/')
            }
            $produk->gambar = $gambarPath ?: asset('images/default-image.jpg');  // Default asset; buat file default jika belum ada

            $produk->satuan_berat = $produk->satuan_berat ?? 'pcs';  // Sesuaikan dengan field satuan-mu
            $produk->deskripsi = $produk->deskripsi ?? 'Deskripsi default';

            return $produk;
        });

        return view('Staff_Produk.diskonProduk', compact('produkDiskon'));
    }

    public function detailDiskon($id_produk)
    {
        $produk = Produk::with(['kategori', 'supplier', 'satuan'])->findOrFail($id_produk);

        $batches = Batch::where('id_produk', $id_produk)
            ->whereColumn('harga_saat_ini', '<', 'harga_normal') // Hanya batch yang sedang diskon
            ->latest()
            ->get()
            ->map(function ($batch) {
                // FORMAT TANGGAL
                $batch->tgl_masuk_format = Carbon::parse($batch->tgl_masuk)->format('d/m/Y');
                $batch->tgl_kadaluwarsa_format = Carbon::parse($batch->tgl_kadaluwarsa)->format('d/m/Y');
                $batch->tgl_perubahan_format = $batch->tgl_perubahan_harga ? Carbon::parse($batch->tgl_perubahan_harga)->format('d/m/Y H:i') : '-';

                // SISA HARI
                $today = Carbon::today();
                $exp = Carbon::parse($batch->tgl_kadaluwarsa)->startOfDay();
                $diff = $today->diffInDays($exp, false);

                if ($diff < 0) {
                    $batch->sisa_text = abs($diff).' hari lalu';
                    $batch->sisa_color = 'text-danger';
                } elseif ($diff === 0) {
                    $batch->sisa_text = 'Hari ini';
                    $batch->sisa_color = 'text-warning';
                } elseif ($diff <= 7) {
                    $batch->sisa_text = $diff.' hari lagi';
                    $batch->sisa_color = 'text-warning';
                } else {
                    $batch->sisa_text = $diff.' hari lagi';
                    $batch->sisa_color = 'text-success';
                }

                // FORMAT HARGA
                $batch->harga_normal_rp = 'Rp '.number_format($batch->harga_normal,0,',','.');
                $batch->harga_saat_ini_rp = 'Rp '.number_format($batch->harga_saat_ini,0,',','.');

                // KETERANGAN HARGA
                if ($batch->harga_saat_ini < $batch->harga_normal) {
                    $pct = round((($batch->harga_normal - $batch->harga_saat_ini) / $batch->harga_normal) * 100);
                    $batch->keterangan = "Diskon {$pct}%";
                } elseif ($batch->harga_saat_ini > $batch->harga_normal) {
                    $pct = round((($batch->harga_saat_ini - $batch->harga_normal) / $batch->harga_normal) * 100);
                    $batch->keterangan = "Naik {$pct}%";
                } else {
                    $batch->keterangan = 'Normal';
                }

                // STATUS STOK
                if ($batch->stok <= 0) {
                    $batch->status_stok_text = 'Habis';
                    $batch->status_stok_badge = 'badge-habis';
                } elseif ($batch->stok <= 10) {
                    $batch->status_stok_text = 'Menipis';
                    $batch->status_stok_badge = 'badge-menipis';
                } else {
                    $batch->status_stok_text = 'Tersedia';
                    $batch->status_stok_badge = 'badge-tersedia';
                }

                return $batch;
            });

        $total_stok = $batches->sum('stok');
        $status_stok = $total_stok <= 0 ? 'Habis' : ($total_stok <= 10 ? 'Menipis' : 'Tersedia');

        // Fallback untuk produk (mirip produkDiskon)
        $produk->jumlah_satuan = $produk->jumlah_satuan ?? 1;
        $produk->nama_satuan = $produk->satuan ? $produk->satuan->nama_satuan : 'Pcs';
        $kategoriNama = '-';
        if ($produk->kategori) {
            $kategoriNama = $produk->kategori->nama_kategori ?? $produk->kategori->name ?? $produk->kategori->nama ?? '-';
        }
        $produk->kategori = $kategoriNama;
        $supplierNama = '-';
        if ($produk->supplier) {
            $supplierNama = $produk->supplier->nama_supplier ?? $produk->supplier->name ?? $produk->supplier->nama ?? '-';
        }
        $produk->supplier = $supplierNama;
        $gambarPath = $produk->gambar;
        if ($gambarPath && !str_starts_with($gambarPath, 'http') && !str_starts_with($gambarPath, '/')) {
            $gambarPath = asset('storage/' . $gambarPath);
        }
        $produk->gambar = $gambarPath ?: asset('images/default-image.jpg');
        $produk->satuan_berat = $produk->satuan_berat ?? 'pcs';
        $produk->deskripsi = $produk->deskripsi ?? 'Deskripsi default';
        $produk->status_stok = $status_stok;
        $produk->stok = $total_stok;

        return view('Staff_Produk.detailDiskon', compact('produk', 'batches', 'total_stok', 'status_stok'));
    }
}
