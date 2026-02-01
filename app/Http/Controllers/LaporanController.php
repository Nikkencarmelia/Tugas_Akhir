<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Pemesanan;
use App\Models\Pengurus;
use App\Models\Produk;
use App\Models\Produk_Rusak;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function dashboardSuperAdmin()
    {

        $total_user = User::count();
        $total_kurir = User::where('role', 'kurir')->count();
        $total_pengurus = Pengurus::count();
        $total_produk = Produk::count();

        $top_products = DetailPesanan::select('id_produk', DB::raw('sum(quantity) as total_sold'))
            ->whereHas('pemesanan', function ($q) {
                $q->where('status_pesanan', 'selesai');
            })
            ->with(['produk' => function ($q) {
                $q->with('kategori');
            }])
            ->groupBy('id_produk')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $monthly_sales_data = Pemesanan::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('count(*) as total_orders'),
            DB::raw('sum(total) as total_revenue'),
            DB::raw('sum(subtotal) as net_revenue')
        )
            ->where('status_pesanan', 'selesai')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderByDesc('month')
            ->take(6)
            ->get()
            ->reverse();

        $month_names = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $monthly_sales = [];
        foreach ($monthly_sales_data as $data) {
            $monthly_sales[] = [
                'month' => $month_names[$data->month],
                'orders' => $data->total_orders,
                'total' => $data->total_revenue,
                'net' => $data->net_revenue,
            ];
        }

        return view('Super_Admin.dashboard', compact('total_user', 'total_kurir', 'total_pengurus', 'total_produk', 'top_products', 'monthly_sales'));
    }

    public function laporan(Request $request)
    {
        $month = $request->query('month', date('m'));
        $year = $request->query('year', date('Y'));
        $sort = $request->query('sort', 'asc');
        $search = $request->query('search');

        // 1. Penjualan
        $penjualanQuery = DetailPesanan::whereHas('pemesanan', function ($q) use ($month, $year) {
            $q->where('status_pesanan', 'selesai')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        })
            ->join('pemesanans', 'detail_pesanans.id_pemesanan', '=', 'pemesanans.id')
            ->join('batches', 'detail_pesanans.id_batch', '=', 'batches.id')
            ->join('produks', 'detail_pesanans.id_produk', '=', 'produks.id')
            ->leftJoin('kategoris', 'produks.id_kategori', '=', 'kategoris.id')
            ->leftJoin('suppliers', 'produks.id_supplier', '=', 'suppliers.id')
            ->select(
                'pemesanans.created_at as tanggal_transaksi',
                'pemesanans.kode_pesanan',
                'batches.id as batch_id',
                'batches.kode_batch',
                'detail_pesanans.nama_produk',
                'detail_pesanans.gambar',
                'detail_pesanans.quantity as jumlah_dibeli',
                'detail_pesanans.jumlah_satuan',
                'detail_pesanans.satuan',
                'batches.harga_normal',
                'batches.harga_saat_ini',
                'detail_pesanans.harga_total as total_harga',
                'kategoris.nama_kategori',
                'suppliers.nama_supplier'
            );

        if ($search) {
            $penjualanQuery->where(function ($q) use ($search) {
                $q->where('detail_pesanans.nama_produk', 'LIKE', "%{$search}%")
                    ->orWhere('pemesanans.kode_pesanan', 'LIKE', "%{$search}%")
                    ->orWhere('batches.kode_batch', 'LIKE', "%{$search}%")
                    ->orWhere('kategoris.nama_kategori', 'LIKE', "%{$search}%")
                    ->orWhere('suppliers.nama_supplier', 'LIKE', "%{$search}%");
            });
        }

        $penjualan = $penjualanQuery->orderBy('pemesanans.created_at', $sort)
            ->paginate(10, ['*'], 'penjualan_page')
            ->withQueryString();

        // 2. Pesanan
        $pesananQuery = Pemesanan::with(['user', 'detailPesanan.batch'])
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year);

        if ($search) {
            $pesananQuery->where(function ($q) use ($search) {
                $q->where('kode_pesanan', 'LIKE', "%{$search}%")
                    ->orWhere('nama_penerima', 'LIKE', "%{$search}%")
                    ->orWhere('status_pesanan', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('nama_lengkap', 'LIKE', "%{$search}%");
                    });
            });
        }

        $pesanan = $pesananQuery->orderBy('created_at', $sort)
            ->paginate(10, ['*'], 'pesanan_page')
            ->withQueryString()
            ->through(function ($p) {
                $normal_subtotal = $p->detailPesanan->sum(function ($detail) {
                    $harga_normal = $detail->batch ? $detail->batch->harga_normal : ($detail->harga_satuan ?? 0);

                    return $detail->quantity * $harga_normal;
                });

                $total_normal = $normal_subtotal + $p->ongkir;

                return [
                    'tanggal_pesanan' => $p->created_at,
                    'kode_pesanan' => $p->kode_pesanan,
                    'nama_pembeli' => $p->nama_penerima ?? $p->user->nama_lengkap ?? 'Guest',
                    'jumlah_dibeli' => $p->detailPesanan->sum('quantity'),
                    'subtotal' => $p->subtotal,
                    'total_bayar' => $p->total,
                    'ongkir' => $p->ongkir,
                    'total_normal_bayar' => $total_normal,
                    'status_pesanan' => $p->status_pesanan,
                    'metode_pengiriman' => $p->opsi_pengiriman,
                ];
            });

        // 3. Stok
        $stokQuery = Produk::with(['batch', 'rusak' => fn ($q) => $q->select('id_produk', 'jumlah_rusak'), 'supplier', 'satuan', 'kategori']);

        if ($search) {
            $stokQuery->where(function ($q) use ($search) {
                $q->where('nama_produk', 'LIKE', "%{$search}%")
                    ->orWhere('kode_produk', 'LIKE', "%{$search}%")
                    ->orWhereHas('supplier', function ($sq) use ($search) {
                        $sq->where('nama_supplier', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('kategori', function ($kq) use ($search) {
                        $kq->where('nama_kategori', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('batch', function ($bq) use ($search) {
                        $bq->where('kode_batch', 'LIKE', "%{$search}%");
                    });
            });
        }

        $stok = $stokQuery->paginate(10, ['*'], 'stok_page')
            ->withQueryString()
            ->through(function ($p) use ($month, $year) {
                $all_batches = $p->batch;
                $total_batch = $all_batches->count();
                $sisa_batch = $all_batches->where('stok', '>', 0)->count();

                $batch_aktif_obj = $all_batches->where('stok', '>', 0)->sortBy('id')->first();
                $kode_batch_aktif = $batch_aktif_obj ? $batch_aktif_obj->kode_batch : 'Batch Habis';
                $is_batch_habis = $batch_aktif_obj ? false : true;

                $stok_dibeli = DetailPesanan::where('id_produk', $p->id)
                    ->whereHas('pemesanan', function ($q) use ($month, $year) {
                        $q->where('status_pesanan', 'selesai')
                            ->whereMonth('created_at', $month)
                            ->whereYear('created_at', $year);
                    })
                    ->sum('quantity');

                $stok_rusak = Produk_Rusak::where('id_produk', $p->id)
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->sum('jumlah_rusak');

                $sisa_stok = $all_batches->sum('stok');

                $stok_masuk_bulan_ini = $all_batches->whereNotNull('tgl_masuk')
                    ->filter(function ($b) use ($month, $year) {
                        return $b->tgl_masuk->format('m') == $month && $b->tgl_masuk->format('Y') == $year;
                    })
                    ->sum('stok');

                $last_update = $all_batches->max('tgl_perubahan_harga');

                return [
                    'nama_produk' => $p->nama_produk,
                    'gambar' => $p->gambar ? 'storage/'.$p->gambar : 'images/default-produk.png',
                    'nama_supplier' => $p->supplier->nama_supplier ?? '-',
                    'nama_kategori' => $p->kategori->nama_kategori ?? '-',
                    'jumlah_satuan' => $p->jumlah_satuan,
                    'satuan' => $p->satuan->nama_satuan ?? 'Pcs',
                    'total_batch' => $total_batch,
                    'sisa_batch' => $sisa_batch,
                    'kode_batch_aktif' => $kode_batch_aktif,
                    'is_batch_habis' => $is_batch_habis,
                    'stok_masuk' => $stok_masuk_bulan_ini,
                    'stok_keluar_dibeli' => $stok_dibeli,
                    'stok_keluar_rusak' => $stok_rusak,
                    'sisa_stok' => $sisa_stok,
                    'tanggal_update' => $last_update ?: $p->updated_at,
                ];
            });

        $total_all_sales = DetailPesanan::whereHas('pemesanan', function ($q) use ($month, $year) {
            $q->where('status_pesanan', 'selesai')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        })->sum('harga_total');

        // 4. Terlaris
        $terlarisQuery = DetailPesanan::select('id_produk', DB::raw('sum(quantity) as jumlah_terjual'), DB::raw('sum(harga_total) as total_pendapatan'))
            ->whereHas('pemesanan', function ($q) use ($month, $year) {
                $q->where('status_pesanan', 'selesai')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year);
            })
            ->with(['produk' => function ($q) {
                $q->with(['supplier', 'satuan'])->orderBy('created_at', 'asc');
            }]);

        if ($search) {
            $terlarisQuery->whereHas('produk', function ($q) use ($search) {
                $q->where('nama_produk', 'LIKE', "%{$search}%")
                    ->orWhereHas('supplier', function ($sq) use ($search) {
                        $sq->where('nama_supplier', 'LIKE', "%{$search}%");
                    });
            });
        }

        $terlaris = $terlarisQuery->groupBy('id_produk')
            ->orderBy('jumlah_terjual', 'desc')
            ->paginate(10, ['*'], 'terlaris_page')
            ->withQueryString()
            ->through(function ($item) use ($total_all_sales) {
                return [
                    'nama_produk' => $item->produk->nama_produk,
                    'gambar' => $item->produk->gambar ? 'storage/'.$item->produk->gambar : 'images/default-produk.png',
                    'nama_supplier' => $item->produk->supplier->nama_supplier ?? '-',
                    'jumlah_satuan' => $item->produk->jumlah_satuan,
                    'satuan' => $item->produk->satuan->nama_satuan ?? 'Pcs',
                    'jumlah_terjual' => $item->jumlah_terjual,
                    'total_pendapatan' => $item->total_pendapatan,
                    'persentase_penjualan' => $total_all_sales > 0 ? round(($item->total_pendapatan / $total_all_sales) * 100, 1) : 0,
                ];
            });


        return view('Super_Admin.laporan', compact('penjualan', 'pesanan', 'stok', 'terlaris', 'month', 'year', 'sort'));
    }
}
