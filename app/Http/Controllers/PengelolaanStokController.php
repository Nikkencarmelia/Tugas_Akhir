<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PengelolaanStokController extends Controller
{
    public function index(Request $request)
    {

        $produkAll = Produk::with(['kategori', 'supplier', 'satuan', 'batch'])
            ->where(function ($q) {

                $q->whereHas('batch', function ($sub) {
                    $sub->havingRaw('SUM(stok) > 0 AND SUM(stok) <= 10');
                })
                    ->orWhereDoesntHave('batch')
                    ->orWhereHas('batch', function ($sub) {
                        $sub->havingRaw('SUM(stok) = 0');
                    });
            })
            ->latest()
            ->get();

        $produkPaginated = $produkAll->take(10);

        return view('Staff_Produk.kelolaStok', [
            'produkAll' => $produkAll,
            'produk' => $produkPaginated,
            'supplier' => Supplier::all(),
        ]);
    }
}
