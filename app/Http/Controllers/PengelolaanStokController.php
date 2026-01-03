<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PengelolaanStokController extends Controller
{
    public function index(Request $request)
    {
        // AMBIL SEMUA PRODUK YANG STOKNYA MENIPIS ATAU HABIS + relasi lengkap
        // Ini untuk client-side filtering
        $produkAll = Produk::with(['kategori', 'supplier', 'satuan', 'batch'])
            ->where(function ($q) {
                // Menipis: stok > 0 dan <= 10
                $q->whereHas('batch', function ($sub) {
                    $sub->havingRaw('SUM(stok) > 0 AND SUM(stok) <= 10');
                })
                // Habis: tidak ada batch atau total stok = 0
                ->orWhereDoesntHave('batch')
                ->orWhereHas('batch', function ($sub) {
                    $sub->havingRaw('SUM(stok) = 0');
                });
            })
            ->latest()
            ->get();

        // Fallback paginated (jika JS mati)
        $produkPaginated = $produkAll->take(10); // atau clone query + paginate jika perlu

        return view('Staff_Produk.kelolaStok', [
            'produkAll' => $produkAll,         // WAJIB untuk JS
            'produk'    => $produkPaginated,   // Opsional fallback
            'supplier'  => Supplier::all(),    // Untuk dropdown (akan di-populate JS juga)
        ]);
    }
}
