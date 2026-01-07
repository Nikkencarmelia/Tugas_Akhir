<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProdukDiskonController extends Controller
{
    public function produkDiskon(Request $request)
    {
        $query = Produk::whereHas('batch', function ($q) {
            $q->whereColumn('harga_saat_ini', '<', 'harga_normal');
        })
            ->with(['kategori', 'supplier', 'satuan', 'batch']);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $searchLower = strtolower($search);

            $query->where(function ($q) use ($search, $searchLower) {

                $q->where('kode_produk', 'like', "%$search%")
                    ->orWhere('id', 'like', "%$search%")
                    ->orWhere('nama_produk', 'like', "%$search%")
                    ->orWhere('deskripsi', 'like', "%$search%")
                    ->orWhere('status_tampil', 'like', "%$search%")
                    ->orWhere('jumlah_satuan', 'like', "%$search%");

                $q->orWhereHas('kategori', function ($sub) use ($search) {
                    $sub->where('nama_kategori', 'like', "%$search%");
                });

                $q->orWhereHas('supplier', function ($sub) use ($search) {
                    $sub->where('nama_supplier', 'like', "%$search%");
                });

                $q->orWhereHas('satuan', function ($sub) use ($search) {
                    $sub->where('nama_satuan', 'like', "%$search%");
                });

                $q->orWhere(function ($sub) use ($searchLower) {

                    if (stripos($searchLower, 'terse') !== false || $searchLower === 'tersedia') {
                        $sub->whereHas('batch', function ($batchSub) {
                            $batchSub->selectRaw('id_produk')->groupBy('id_produk')->havingRaw('SUM(stok) > 10');
                        });
                    } elseif (stripos($searchLower, 'menip') !== false || $searchLower === 'menipis') {
                        $sub->whereHas('batch', function ($batchSub) {
                            $batchSub->selectRaw('id_produk')->groupBy('id_produk')->havingRaw('SUM(stok) > 0 AND SUM(stok) <= 10');
                        });
                    } elseif (stripos($searchLower, 'hab') !== false || $searchLower === 'habis') {
                        $sub->whereDoesntHave('batch')
                            ->orWhereHas('batch', function ($batchSub) {
                                $batchSub->selectRaw('id_produk')->groupBy('id_produk')->havingRaw('SUM(stok) = 0');
                            });
                    }
                });
            });
        }

        $produkDiskon = $query->latest()->paginate(10)->withQueryString()
            ->through(function ($produk) {

                $diskonStok = $produk->batch->filter(function ($batch) {
                    return $batch->harga_saat_ini < $batch->harga_normal;
                })->sum('stok') ?? 0;
                $produk->stok = $diskonStok;

                $statusStok = $diskonStok <= 0 ? 'Habis' : ($diskonStok <= 10 ? 'Menipis' : 'Tersedia');
                $produk->status_stok = $statusStok;

                $produk->status_tampil = $produk->status_tampil ?? 'Ditampilkan';

                $produk->jumlah_batch = $produk->batch->filter(function ($batch) {
                    return $batch->harga_saat_ini < $batch->harga_normal;
                })->count();

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
                if ($gambarPath && ! str_starts_with($gambarPath, 'http') && ! str_starts_with($gambarPath, '/')) {
                    $gambarPath = asset('storage/'.$gambarPath);
                }
                $produk->gambar = $gambarPath ?: asset('images/default-image.jpg');

                $produk->satuan_berat = $produk->satuan_berat ?? 'pcs';
                $produk->deskripsi = $produk->deskripsi ?? 'Deskripsi default';

                return $produk;
            });

        return view('Staff_Produk.diskonProduk', compact('produkDiskon'));
    }

    public function detailDiskon($id_produk, Request $request)
    {
        $produk = Produk::with(['kategori', 'supplier', 'satuan'])->findOrFail($id_produk);

        $query = Batch::where('id_produk', $id_produk)
            ->whereColumn('harga_saat_ini', '<', 'harga_normal');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
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

                $batch->tgl_masuk_format = Carbon::parse($batch->tgl_masuk)->format('d/m/Y');
                $batch->tgl_kadaluwarsa_format = Carbon::parse($batch->tgl_kadaluwarsa)->format('d/m/Y');
                $batch->tgl_perubahan_format = $batch->tgl_perubahan_harga ? Carbon::parse($batch->tgl_perubahan_harga)->format('d/m/Y H:i') : '-';

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

                $batch->harga_normal_rp = 'Rp '.number_format($batch->harga_normal, 0, ',', '.');
                $batch->harga_saat_ini_rp = 'Rp '.number_format($batch->harga_saat_ini, 0, ',', '.');

                if ($batch->harga_saat_ini < $batch->harga_normal) {
                    $pct = round((($batch->harga_normal - $batch->harga_saat_ini) / $batch->harga_normal) * 100);
                    $batch->keterangan = "Diskon {$pct}%";
                } elseif ($batch->harga_saat_ini > $batch->harga_normal) {
                    $pct = round((($batch->harga_saat_ini - $batch->harga_normal) / $batch->harga_normal) * 100);
                    $batch->keterangan = "Naik {$pct}%";
                } else {
                    $batch->keterangan = 'Normal';
                }

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

        $total_stok = Batch::where('id_produk', $id_produk)
            ->whereColumn('harga_saat_ini', '<', 'harga_normal')
            ->sum('stok');
        $status_stok = $total_stok <= 0 ? 'Habis' : ($total_stok <= 10 ? 'Menipis' : 'Tersedia');

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
        if ($gambarPath && ! str_starts_with($gambarPath, 'http') && ! str_starts_with($gambarPath, '/')) {
            $gambarPath = asset('storage/'.$gambarPath);
        }
        $produk->gambar = $gambarPath ?: asset('images/default-image.jpg');
        $produk->satuan_berat = $produk->satuan_berat ?? 'pcs';
        $produk->deskripsi = $produk->deskripsi ?? 'Deskripsi default';
        $produk->status_stok = $status_stok;
        $produk->stok = $total_stok;

        return view('Staff_Produk.detailDiskon', compact('produk', 'batches', 'total_stok', 'status_stok'));
    }
}
