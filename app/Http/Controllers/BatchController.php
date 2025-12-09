<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    private function batch()
    {
        return Batch::with('produk')->latest()->paginate(10);
    }

    private function batchDiskon()
    {
        return Batch::with('produk')
            ->where('keterangan_harga', 'diskon')
            ->latest()
            ->paginate(10);
    }

    public function batchStok()
    {
        return view('Staff_Produk.batchStok', [
            'produk' => $this->batch()
        ]);
    }

    public function detailDiskon()
    {
        return view('Staff_Produk.detailDiskon', [
            'produk' => $this->batchDiskon()
        ]);
    }

    /**
    * create
    *
    * @return void
    */
    public function createBatch()
    {
    // Ambil semua produk
    $produk = Produk::all();

    // Kirim ke view
    return view('Staff_Produk.batch.create', compact('produk'));
    }

    /**
    * store
    *
    * @param Request $request
    * @return void
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tgl_masuk' => 'required',
            'stok' => 'required',
            'status_stok' => 'nullable',
            'harga_normal' => 'required',
            'harga_saat_ini' => 'required',
            'tgl_perubahan_harga' => 'nullable',
            'tgl_kadaluwarsa' => 'required',
            'keterangan_harga' => 'nullable',
            'id_produk' => 'required'
        ]);

        // 1. Status stok otomatis
        if ($request->stok == 0) {
            $status_stok = 'habis';
        } elseif ($request->stok <= 15) {
            $status_stok = 'menipis';
        } else {
            $status_stok = 'tersedia';
        }

        // 2. Untuk data baru, tanggal perubahan harga = tanggal masuk
        $tgl_perubahan_harga = $request->tgl_masuk;

        // 3. Keterangan harga
        if ($request->harga_saat_ini == $request->harga_normal) {
            $keterangan_harga = 'normal';
        } elseif ($request->harga_saat_ini > $request->harga_normal) {
            $keterangan_harga = 'harga naik';
        } else {
            $keterangan_harga = 'diskon';
        }


        Batch::create([
            'tgl_masuk' => $request->tgl_masuk,
            'stok' => $request->stok,
            'status_stok' => $status_stok,
            'harga_normal' => $request->harga_normal,
            'harga_saat_ini' => $request->harga_saat_ini,
            'tgl_perubahan_harga' => $tgl_perubahan_harga,
            'tgl_kadaluwarsa' => $request->tgl_kadaluwarsa,
            'keterangan_harga' => $keterangan_harga,
            'id_produk' => $request->id_produk
        ]);

        try{
            return redirect()->route('batch.view');
        }catch(Exception $e){
            return redirect()->route('batch.view');
        }
    }

    /**
    * update
    *
    * @param mixed $request
    * @param int $id
    * @return void
    */
    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);

        $this->validate($request, [
            'stok' => 'required',
            'harga_normal' => 'required',
            'harga_saat_ini' => 'required',
            'tgl_kadaluwarsa' => 'required'
        ]);

        // Status stok otomatis
        if ($request->stok == 0) {
            $status_stok = 'habis';
        } elseif ($request->stok <= 15) {
            $status_stok = 'menipis';
        } else {
            $status_stok = 'tersedia';
        }

        // Kalau harga berubah → tanggal perubahan harga = hari ini
        $tgl_perubahan_harga =
            $request->harga_saat_ini != $batch->harga_saat_ini
            ? now()
            : $batch->tgl_perubahan_harga;

        // Keterangan harga
        if ($request->harga_saat_ini == $request->harga_normal) {
            $keterangan_harga = 'normal';
        } elseif ($request->harga_saat_ini > $request->harga_normal) {
            $keterangan_harga = 'harga naik';
        } else {
            $keterangan_harga = 'diskon';
        }

        $batch->update([
            'stok' => $request->stok,
            'status_stok' => $status_stok,
            'harga_normal' => $request->harga_normal,
            'harga_saat_ini' => $request->harga_saat_ini,
            'tgl_perubahan_harga' => $tgl_perubahan_harga,
            'tgl_kadaluwarsa' => $request->tgl_kadaluwarsa,
            'keterangan_harga' => $keterangan_harga
        ]);

        return redirect()->route('batch.view')->with('success', 'Batch berhasil diperbarui!');
    }

    /**
    * destroy
    *
    * @param int $id
    * @return void
    */
    public function destroy($id)
    {
        $batch = Batch::find($id);
        $batch->delete();
        return redirect()->route('batch.view')->with(['success' => 'Batch Berhasil Dihapus!']);
    }

}
