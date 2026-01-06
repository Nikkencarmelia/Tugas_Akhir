<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pengurus;
use Illuminate\Http\Request;

class UserProdukController extends Controller
{
    /**
     * Halaman Beranda / Landing Page
     */
    public function beranda()
    {
        // Data kepengurusan
        $kepengurusan = Pengurus::orderBy('nama', 'asc')->get();

        // 1. Produk Terbaru (12 buah)
        $produkTerbaruRaw = Produk::with(['satuan', 'batch'])
            ->where('status_tampil', 'Ditampilkan')
            ->whereHas('batch', function ($q) {
                $q->where('stok', '>', 0);
            })
            ->latest('created_at')
            ->take(12)
            ->get();

        $produkTerbaru = $this->mapProdukDetails($produkTerbaruRaw);

        // 2. Produk Terlaris (12 buah) - Berdasarkan quantity terjual terbanyak
        $produkTerlarisRaw = Produk::with(['satuan', 'batch'])
            ->withSum(['detailPesanans as total_terjual'], 'quantity')
            ->where('status_tampil', 'Ditampilkan')
            ->whereHas('batch', function ($q) {
                $q->where('stok', '>', 0);
            })
            ->orderByDesc('total_terjual')
            ->take(12)
            ->get();

        $produkTerlaris = $this->mapProdukDetails($produkTerlarisRaw);

        return view('User.landingPage', compact('kepengurusan', 'produkTerbaru', 'produkTerlaris'));
    }

    /**
     * Helper untuk memetakan data Produk ke format yang digunakan di view
     */
    private function mapProdukDetails($produks)
    {
        return $produks->map(function ($produk) {
            $batchTertua = $produk->batch
                ->where('stok', '>', 0)
                ->sortBy('tgl_masuk')
                ->first();

            if (!$batchTertua) {
                return null;
            }

            $hargaSaatIni = $batchTertua->harga_saat_ini ?? 0;
            $hargaNormal = $batchTertua->harga_normal ?? $hargaSaatIni;
            $keteranganHarga = $batchTertua->keterangan_harga ?? 'normal';

            // Deteksi diskon
            $isDiskon = ($keteranganHarga === 'diskon') || ($hargaSaatIni < $hargaNormal && $hargaNormal > 0);

            $persenDiskon = 0;
            if ($isDiskon && $hargaNormal > 0) {
                $persenDiskon = round((($hargaNormal - $hargaSaatIni) / $hargaNormal) * 100);
            }

            return [
                'id'                   => $produk->id,
                'batch_id'             => $batchTertua->id,
                'quantity'             => 1,
                'gambar'               => $produk->gambar
                    ? asset('storage/' . $produk->gambar)
                    : asset('images/default-product.jpg'),
                'nama_produk'          => $produk->nama_produk,
                'satuan_berat'         => ($produk->jumlah_satuan ?? 1) . ' ' . ($produk->satuan?->nama_satuan ?? 'pcs'),
                'harga_formatted'      => $hargaSaatIni > 0
                    ? 'Rp ' . number_format($hargaSaatIni, 0, ',', '.')
                    : 'Hubungi Penjual',
                'harga_awal_formatted' => $isDiskon
                    ? 'Rp ' . number_format($hargaNormal, 0, ',', '.')
                    : null,
                'is_diskon'            => $isDiskon,
                'persen_diskon'        => $persenDiskon,
            ];
        })->filter()->values();
    }

    /**
     * Halaman Katalog Semua Produk (dikelompokkan per kategori)
     */
    public function produk(Request $request)
    {
        $produks = Produk::with(['kategori', 'satuan', 'batch'])
            ->where('status_tampil', 'Ditampilkan')
            ->whereHas('batch', fn($q) => $q->where('stok', '>', 0))
            ->latest('created_at')
            ->get()
            ->map(function ($produk) {
                $batchTertua = $produk->batch
                    ->where('stok', '>', 0)
                    ->sortBy('tgl_masuk')
                    ->first();

                if (!$batchTertua) {
                    return null;
                }

                $hargaSaatIni = $batchTertua->harga_saat_ini ?? 0;
                $hargaNormal = $batchTertua->harga_normal ?? $hargaSaatIni;
                $keteranganHarga = $batchTertua->keterangan_harga ?? 'normal';

                // Deteksi diskon
                $isDiskon = ($keteranganHarga === 'diskon') || ($hargaSaatIni < $hargaNormal && $hargaNormal > 0);

                $persenDiskon = 0;
                if ($isDiskon && $hargaNormal > 0) {
                    $persenDiskon = round((($hargaNormal - $hargaSaatIni) / $hargaNormal) * 100);
                }

                return [
                    'id'                   => $produk->id,
                    'batch_id'             => $batchTertua->id,  // ID batch untuk tracking stok spesifik
                    'quantity'             => 1,  // Default quantity 1
                    'nama_produk'          => $produk->nama_produk,
                    'deskripsi'            => $produk->deskripsi ?? '',
                    'kategori'             => $produk->kategori?->nama_kategori ?? 'Produk Lainnya',
                    'jumlah_satuan'        => $produk->jumlah_satuan ?? 1,
                    'satuan'               => $produk->satuan?->nama_satuan ?? 'pcs',
                    'harga_formatted'      => $hargaSaatIni > 0
                        ? 'Rp ' . number_format($hargaSaatIni, 0, ',', '.')
                        : 'Hubungi Kami',
                    'harga_awal_formatted' => $isDiskon
                        ? 'Rp ' . number_format($hargaNormal, 0, ',', '.')
                        : null,
                    'is_diskon'            => $isDiskon,
                    'persen_diskon'        => $persenDiskon,
                    'gambar_url'           => $produk->gambar
                        ? asset('storage/' . $produk->gambar)
                        : asset('images/default-product.jpg'),
                ];
            })
            ->filter()
            ->values();

        $produksGrouped = $produks->groupBy('kategori')->sortKeys();

        return view('User.produk', compact('produks', 'produksGrouped'));
    }

    /**
     * Halaman Detail Produk
     */
    public function detailProduk($id)
    {
        $produk = Produk::with(['satuan', 'kategori', 'supplier'])
            ->with(['batch' => fn($q) => $q->orderBy('tgl_masuk')])
            ->where('status_tampil', 'Ditampilkan')
            ->findOrFail($id);

        $batchesTersedia = $produk->batch->where('stok', '>', 0);

        if ($batchesTersedia->isEmpty()) {
            abort(404, 'Produk sedang habis stok.');
        }

        $batchTertua = $batchesTersedia->sortBy('tgl_masuk')->first();
        $hargaTampil = $batchTertua->harga_saat_ini;
        $totalStok = $produk->batch->sum('stok');
        $satuanLengkap = ($produk->jumlah_satuan ?? 1) . ' ' . ($produk->satuan?->nama_satuan ?? 'pcs');
        $batchId = $batchTertua->id;

        return view('User.detailProduk', compact(
            'produk',
            'hargaTampil',
            'totalStok',
            'satuanLengkap',
            'batchId'
        ));
    }
}
