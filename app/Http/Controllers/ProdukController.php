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

    // public function dashboardProduk()
    // {
    //     $produk = Produk::latest()->get();

    //     return view('Staff_Produk.dashboard', [
    //         'produk' => $produk,
    //     ]);
    // }


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

    // public function dataProduk()
    // {
    //     return view('Staff_Produk.dataProduk', [
    //         'produk' => $this->produkPaginated()
    //     ]);
    // }

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
    public function arsipProduk()
    {
        $produk = Produk::where('status_tampil', 'Diarsipkan')
                ->with(['kategori','supplier','satuan'])
                ->latest()->paginate(10);

        return view('Staff_Produk.arsipProduk', compact('produk'));
    }

    /**
     * RUSAK CACAT – sementara kosong
     */
    public function rusakCacat()
    {
        return view('Staff_Produk.rusakCacat');
    }

    // public function tambahProduk() // Metode ini redundan, lebih baik gunakan create()
    // {
    //     // Mendapatkan data untuk dropdown di form
    //     $suppliers = Produk::distinct('supplier')->pluck('supplier')->filter()->sort()->all();
    //     $kategoris = Produk::distinct('kategori')->pluck('kategori')->filter()->sort()->all();

    //     return view('Staff_Produk.tambahProduk', compact('suppliers', 'kategoris'));
    // }

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
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama_produk' => 'required',
    //         'kategori_id' => 'required',
    //         'satuan_id' => 'required',
    //         'supplier_id' => 'required',
    //     ]);

    //     $produk = new Produk();
    //     $produk->nama_produk = $request->nama_produk;
    //     $produk->kategori_id = $request->kategori_id;
    //     $produk->satuan_id = $request->satuan_id;
    //     $produk->supplier_id = $request->supplier_id;
    //     $produk->deskripsi = $request->deskripsi;
    //     $produk->status_tampil = $request->status_tampil;

    //     if ($request->hasFile('gambar')) {
    //         $produk->gambar = $request->file('gambar')->store('produk', 'public');
    //     }

    //     $produk->save();

    //     return redirect()->route('produk.data')->with('success', 'Produk ditambahkan!');
    // }

    public function storeProduk(Request $request)
    {
        // VALIDASI
        $request->validate([
            'nama_produk'   => 'required|string|max:255|unique:produks,nama_produk',
            'gambar'        => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'deskripsi'     => 'required|string',

            // ini string karena user bisa ngetik kategori baru
            'kategoriText'  => 'required|string',
            'satuanText'    => 'required|string',
            'supplierText'  => 'required|string',

            'status_tampil' => 'required|in:Ditampilkan,Diarsipkan',
        ]);

        // ==========================
        // GET OR CREATE KATEGORI
        // ==========================
        $kategori = Kategori::firstOrCreate([
            'nama_kategori' => $request->kategoriText
        ]);

        // ==========================
        // GET OR CREATE SATUAN
        // ==========================
        $satuan = Satuan::firstOrCreate([
            'nama_satuan' => $request->satuanText
        ]);

        // ==========================
        // GET OR CREATE SUPPLIER
        // ==========================
        $supplier = Supplier::firstOrCreate([
            'nama_supplier' => $request->supplierText
        ]);

        // ==========================
        // UPLOAD GAMBAR
        // ==========================
        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
        }

        // ==========================
        // CREATE PRODUK
        // ==========================
        Produk::create([
            'nama_produk'   => $request->nama_produk,
            'id_kategori'   => $kategori->id,
            'id_satuan'     => $satuan->id,
            'id_supplier'   => $supplier->id,
            'status_tampil' => $request->status_tampil,
            'deskripsi'     => $request->deskripsi,
            'gambar'        => $path,
        ]);

        return redirect()->route('produk.data')->with('success', 'Produk berhasil ditambahkan!');
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
