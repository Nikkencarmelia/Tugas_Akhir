<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Satuan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    private function produkPaginated()
    {
        return Produk::latest()->paginate(10);
    }

    /**
     * DASHBOARD – tampilkan 5 produk terbaru
     */
    public function dashboardProduk()
    {
        $produkBaru = Produk::latest()->take(5)->get();

        $totalProduk = Produk::count();
        $totalTampil = Produk::where('status_tampil', 'Ditampilkan')->count();
        $totalArsip = Produk::where('status_tampil', 'Diarsipkan')->count();

        return view('Staff_Produk.dashboard', [
            'produkBaru'    => $produkBaru,
            'totalProduk'   => $totalProduk,
            'totalTampil'   => $totalTampil,
            'totalArsip'    => $totalArsip,
        ]);
    }


    /**
     * DATA PRODUK – semua produk (pagination 10)
     */

    public function dataProduk(Request $request)
    {
        $query = Produk::with(['kategori', 'supplier', 'satuan']);

        // Filter tampil
        if ($request->filled('status_tampil') && $request->status_tampil !== 'all') {
            $query->where('status_tampil', $request->status_tampil);
        }

        // Filter stok dari batch
        if ($request->filled('status_stok') && $request->status_stok !== 'all') {
            $query->whereHas('batch', function ($q) use ($request) {
                $q->where('status_stok', $request->status_stok);
            });
        }

        // Filter Supplier
        if ($request->filled('supplier') && $request->supplier !== 'all') {
            $query->where('id_supplier', $request->supplier);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('nama_produk', 'like', "%$search%")
                  ->orWhere('deskripsi', 'like', "%$search%");
            });
        }

        $produk = $query->latest()->paginate(10)->withQueryString();

        return view('Staff_Produk.dataProduk', [
            'produk'    => $produk,
            'kategori'  => Kategori::all(),
            'supplier'  => Supplier::all(),
            'satuan'    => Satuan::all(),
        ]);
    }


    /**
     * PRODUK DISKON – tampilkan produk yang punya batch diskon
     */
    public function diskonProduk()
    {
        $produk = Produk::whereHas('batch', function ($q) {
            $q->where('keterangan_harga', 'diskon');
        })->with(['kategori','supplier','satuan'])->latest()->paginate(10);

        return view('Staff_Produk.diskonProduk', compact('produk'));
    }


    /**
     * KELOLA STOK – tampilkan produk batch menipis / habis
     */
    public function kelolaStok()
    {
        $produk = Produk::whereHas('batch', function ($q) {
            $q->whereIn('status_stok', ['menipis', 'habis']);
        })->with(['kategori','supplier','satuan'])
          ->latest()->paginate(10);

        return view('Staff_Produk.kelolaStok', compact('produk'));
    }

    /**
     * ARSIP – produk dengan status_tampil = 0 (disembunyikan)
     */
    public function arsipProduk(Request $request)
    {
        $query = Produk::where('status_tampil', 'Diarsipkan')
            ->with(['kategori', 'supplier', 'satuan']);

        // 🔹 Filter supplier
        if ($request->supplier && $request->supplier !== 'all') {
            $query->whereHas('supplier', function ($q) use ($request) {
                $q->where('nama_supplier', $request->supplier);
            });
        }

        // 🔹 Filter kategori
        if ($request->kategori && $request->kategori !== 'all') {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // 🔹 Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_produk', 'like', "%{$request->search}%")
                  ->orWhere('deskripsi', 'like', "%{$request->search}%");
            });
        }

        $produk = $query->latest()->paginate(5);

        // 🔹 Dropdown supplier (PAKAI id_supplier)
        $suppliers = Produk::where('status_tampil', 'Diarsipkan')
            ->join('suppliers', 'produks.id_supplier', '=', 'suppliers.id')
            ->select('suppliers.nama_supplier')
            ->distinct()
            ->pluck('nama_supplier');

        // 🔹 Dropdown kategori (PAKAI id_kategori)
        $kategoris = Produk::where('status_tampil', 'Diarsipkan')
            ->join('kategoris', 'produks.id_kategori', '=', 'kategoris.id')
            ->select('kategoris.nama_kategori')
            ->distinct()
            ->pluck('nama_kategori');

        return view('Staff_Produk.arsipProduk', compact(
            'produk',
            'suppliers',
            'kategoris'
        ));
    }

    /**
     * Restore 1 produk
     */
    public function restoreProduk($id)
    {
        $produk = Produk::where('id', $id)
            ->where('status_tampil', 'Diarsipkan')
            ->firstOrFail();

        $produk->update([
            'status_tampil' => 'Ditampilkan'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditampilkan kembali'
        ]);
    }

    /**
     * Restore produk terpilih
     */
    public function restoreSelectedProduk(Request $request)
    {
        $ids = $request->ids ?? [];

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada produk dipilih'
            ]);
        }

        Produk::whereIn('id', $ids)
            ->where('status_tampil', 'Diarsipkan')
            ->update([
                'status_tampil' => 'Ditampilkan'
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk terpilih berhasil ditampilkan'
        ]);
    }

    /**
     * Restore semua produk arsip
     */
    public function restoreAllProduk()
    {
        Produk::where('status_tampil', 'Diarsipkan')
            ->update([
                'status_tampil' => 'Ditampilkan'
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Semua produk arsip berhasil ditampilkan'
        ]);
    }


    /**
     * RUSAK CACAT – sementara kosong
     */
    public function rusakCacat()
    {
        return view('Staff_Produk.rusakCacat');
    }

    /**
     * create
     *
     * @return void
     */
    public function tambahProduk()
    {
        return view('Staff_Produk.tambahProduk', [
            'kategori' => Kategori::all(),
            'satuan'   => Satuan::all(),
            'supplier' => Supplier::all(),
        ]);
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */

    public function storeProduk(Request $request)
{
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'id_kategori' => 'required|exists:kategoris,id',
        'id_satuan' => 'required|exists:satuans,id',
        'id_supplier' => 'required|exists:suppliers,id',
        'jumlah_satuan' => 'required|numeric|min:1',
        'estimasi_kadaluwarsa_hari' => 'nullable|integer|min:1',
        'status_tampil' => 'required|in:Ditampilkan,Diarsipkan',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $gambarPath = null;
    if($request->hasFile('gambar')){
        $gambarPath = $request->file('gambar')->store('produk', 'public');
    }

    $produk = Produk::create([
        'nama_produk' => $request->nama_produk,
        'id_kategori' => $request->id_kategori,
        'id_satuan' => $request->id_satuan,
        'id_supplier' => $request->id_supplier,
        'jumlah_satuan' => $request->jumlah_satuan,
        'estimasi_kadaluwarsa_hari' => $request->estimasi_kadaluwarsa_hari,
        'deskripsi' => $request->deskripsi,
        'status_tampil' => $request->status_tampil,
        'gambar' => $gambarPath,
    ]);

    return redirect()->route('produk.data')->with('success','Produk berhasil ditambahkan');
}

    /**
     * edit
     *
     * @param  int $id
     * @return void
     */
    public function edit($id)
    {
        return view('Staff_Produk.editProduk', [
            'produk'   => Produk::findOrFail($id),
            'kategori' => Kategori::all(),
            'supplier' => Supplier::all(),
            'satuan'   => Satuan::all(),
        ]);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $this->validate($request, [
            'nama_produk'   => 'required|string|max:255|unique:produks,nama_produk,' . $produk->id,
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_kategori'   => 'required|exists:kategoris,id',
            'id_supplier'   => 'required|exists:suppliers,id',
            'id_satuan'     => 'required|exists:satuans,id',
            'jumlah_satuan' => 'required|numeric|min:1',
            'estimasi_kadaluwarsa_hari' => 'nullable|integer|min:1',
            'status_tampil' => 'required|in:Ditampilkan,Diarsipkan',
            'deskripsi'     => 'required|string',
        ]);

        // Upload gambar
        $path = $produk->gambar;
        if ($request->hasFile('gambar')) {
            \Storage::disk('public')->delete($produk->gambar);
            $path = $request->file('gambar')->store('images/produk', 'public');
        }

        $produk->update([
            'nama_produk'   => $request->nama_produk,
            'id_kategori'   => $request->id_kategori,
            'id_supplier'   => $request->id_supplier,
            'id_satuan'     => $request->id_satuan,
            'jumlah_satuan' => $request->jumlah_satuan,
            'estimasi_kadaluwarsa_hari' => $request->estimasi_kadaluwarsa_hari,
            'status_tampil' => $request->status_tampil,
            'deskripsi'     => $request->deskripsi,
            'gambar'        => $path,
        ]);

        return redirect()->route('produk.data')->with('success', 'Produk berhasil diupdate!');
    }

    /**
     * destroy
     *
     * @param  int $id
     * @return void
     */
    public function destroy($id)
    {
        $produk = Produk::withCount('batch')->findOrFail($id);

        if ($produk->batch_count > 0) {
            return back()->with('error', 'Produk masih memiliki batch. Hapus batch terlebih dahulu.');
        }

        if ($produk->gambar) {
            \Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('produk.data')->with('success', 'Produk berhasil dihapus.');
    }
}
