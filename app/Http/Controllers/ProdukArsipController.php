<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukArsipController extends Controller
{
    public function arsipProduk(Request $request)
    {
        $produkAll = Produk::where('status_tampil', 'Diarsipkan')
            ->with(['kategori', 'supplier', 'satuan', 'batch'])
            ->latest()
            ->get();

        $suppliers = $produkAll
            ->pluck('supplier.nama_supplier')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $kategoris = $produkAll
            ->pluck('kategori.nama_kategori')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('Staff_Produk.arsipProduk', [
            'produkAll'  => $produkAll,
            'suppliers'  => $suppliers,
            'kategoris'  => $kategoris,
        ]);
    }

    public function restoreProduk($id)
    {
        $produk = Produk::where('id', $id)
            ->where('status_tampil', 'Diarsipkan')
            ->firstOrFail();

        $produk->update(['status_tampil' => 'Ditampilkan']);

        return response()->json([
            'success' => true,
            'message' => 'Produk "' . $produk->nama_produk . '" berhasil ditampilkan kembali!'
        ]);
    }

    public function restoreSelectedProduk(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada produk yang dipilih'
            ]);
        }

        $updated = Produk::whereIn('id', $ids)
            ->where('status_tampil', 'Diarsipkan')
            ->update(['status_tampil' => 'Ditampilkan']);

        return response()->json([
            'success' => true,
            'message' => "$updated produk berhasil ditampilkan kembali!"
        ]);
    }

    public function restoreAllProduk()
    {
        $count = Produk::where('status_tampil', 'Diarsipkan')->count();

        if ($count === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada produk di arsip'
            ]);
        }

        Produk::where('status_tampil', 'Diarsipkan')
            ->update(['status_tampil' => 'Ditampilkan']);

        return response()->json([
            'success' => true,
            'message' => "Semua $count produk arsip berhasil ditampilkan kembali!"
        ]);
    }
}
