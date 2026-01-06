<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Batch;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProdukDiskonController extends Controller
{
    public function produkDiskon(Request $request)
    {
        $query = Produk::whereHas('batch', function ($q) {
            $q->whereColumn('harga_saat_ini', '<', 'harga_normal');
        })
        ->with(['kategori', 'supplier', 'satuan', 'batch']);

        // Search semuanya (extend ke kategori, supplier, status_tampil, status_stok computed, satuan, jumlah_satuan) + fuzzy partial match
        if ($request->filled('search')) {
            $search = trim($request->search);
            $searchLower = strtolower($search);

            $query->where(function ($q) use ($search, $searchLower) {
                // Search di field produk utama (partial match)
                $q->where('id', 'like', "%$search%")
                  ->orWhere('nama_produk', 'like', "%$search%")
                  ->orWhere('deskripsi', 'like', "%$search%")
                  ->orWhere('status_tampil', 'like', "%$search%") // Tambah status tampil (e.g., "Ditampilkan" partial)
                  ->orWhere('jumlah_satuan', 'like', "%$search%"); // Tambah jumlah_satuan (partial match, e.g., "10" cari "1" atau "10")

                // Search di kategori (via join, partial match)
                $q->orWhereHas('kategori', function ($sub) use ($search) {
                    $sub->where('nama_kategori', 'like', "%$search%");
                });

                // Search di supplier (via join, partial match)
                $q->orWhereHas('supplier', function ($sub) use ($search) {
                    $sub->where('nama_supplier', 'like', "%$search%");
                });

                // Search di satuan (via join, partial match)
                $q->orWhereHas('satuan', function ($sub) use ($search) {
                    $sub->where('nama_satuan', 'like', "%$search%");
                });

                // Search di status_stok (computed: partial/fuzzy match seperti 'menipis' -> 'menipi')
                $q->orWhere(function ($sub) use ($searchLower) {
                    // Fuzzy untuk 'Tersedia' (partial 'terse', 'tersedia', etc.)
                    if (stripos($searchLower, 'terse') !== false || $searchLower === 'tersedia') {
                        $sub->whereHas('batch', function ($batchSub) {
                            $batchSub->selectRaw('id_produk')->groupBy('id_produk')->havingRaw('SUM(stok) > 10');
                        });
                    }
                    // Fuzzy untuk 'Menipis' (partial 'menip', 'menipi', 'menipis', etc.)
                    elseif (stripos($searchLower, 'menip') !== false || $searchLower === 'menipis') {
                        $sub->whereHas('batch', function ($batchSub) {
                            $batchSub->selectRaw('id_produk')->groupBy('id_produk')->havingRaw('SUM(stok) > 0 AND SUM(stok) <= 10');
                        });
                    }
                    // Fuzzy untuk 'Habis' (partial 'hab', 'habi', 'habis', etc.)
                    elseif (stripos($searchLower, 'hab') !== false || $searchLower === 'habis') {
                        $sub->whereDoesntHave('batch')
                            ->orWhereHas('batch', function ($batchSub) {
                                $batchSub->selectRaw('id_produk')->groupBy('id_produk')->havingRaw('SUM(stok) = 0');
                            });
                    }
                });
            });
        }

        $produkDiskon = $query->latest()->paginate(10)->withQueryString()
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

    public function detailDiskon($id_produk, Request $request)
    {
        $produk = Produk::with(['kategori', 'supplier', 'satuan'])->findOrFail($id_produk);

        $query = Batch::where('id_produk', $id_produk)
            ->whereColumn('harga_saat_ini', '<', 'harga_normal'); // Hanya batch yang sedang diskon

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('harga_normal', 'like', "%{$search}%")
                  ->orWhere('harga_saat_ini', 'like', "%{$search}%")
                  ->orWhere('stok', 'like', "%{$search}%")
                  ->orWhere('keterangan_harga', 'like', "%{$search}%")
                  ->orWhere('tgl_masuk', 'like', "%{$search}%")
                  ->orWhere('tgl_kadaluwarsa', 'like', "%{$search}%");
            });
        }

        $batches = $query->latest()
            ->paginate(10)
            ->through(function ($batch) {
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

        // Hitung total stok (dari semua batch diskon, bukan page ini saja)
        $total_stok = Batch::where('id_produk', $id_produk)
            ->whereColumn('harga_saat_ini', '<', 'harga_normal')
            ->sum('stok');
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
