<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Satuan;
use App\Models\Produk;  // Import Produk untuk fitur move
use Illuminate\Http\Request;

class KomponenProdukController extends Controller
{
    /**
     * INDEX
     * Halaman kelola Kategori, Supplier, Satuan
     */
    public function index()
    {
        return view('Staff_Produk.komponenProduk', [
            'kategori' => Kategori::withCount('produk')->latest()->get(),
            'supplier' => Supplier::withCount('produk')->latest()->get(),
            'satuan'   => Satuan::withCount('produk')->latest()->get(),
        ]);
    }

    // ================= KATEGORI =================

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
        ]);

        $nama = $request->nama_kategori;
        Kategori::create([
            'nama_kategori' => $nama,
        ]);

        return back()->with('success', "Kategori dengan nama \"{$nama}\" telah dibuat!");
    }

    public function updateKategori(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
        ]);

        $namaLama = $kategori->nama_kategori;
        $namaBaru = $request->nama_kategori;
        $kategori->update([
            'nama_kategori' => $namaBaru,
        ]);

        // Update semua produk yang pakai nama lama ke nama baru (jika logika update nama mempengaruhi produk)
        // Asumsi: Jika nama kategori disimpan di tabel produk (bukan FK), update di sana
        // Jika pakai FK, skip ini
        // Produk::where('nama_kategori', $namaLama)->update(['nama_kategori' => $namaBaru]);

        return back()->with('success', "Kategori dengan nama \"{$namaBaru}\" telah diubah!");
    }

    public function destroyKategori($id)
    {
        $kategori = Kategori::withCount('produk')->findOrFail($id);

        if ($kategori->produk_count > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh produk. Pindahkan dulu semua produk ke kategori lain.');
        }

        $nama = $kategori->nama_kategori;
        $kategori->delete();

        return back()->with('success', "Kategori dengan nama \"{$nama}\" telah dihapus!");
    }

    // TAMBAHAN: Move semua produk dari source kategori ke target
    public function moveKategori(Request $request)
    {
        $request->validate([
            'source_id' => 'required|exists:kategoris,id',
            'target_id' => 'required|exists:kategoris,id|different:source_id',
        ]);

        $source = Kategori::findOrFail($request->source_id);
        $target = Kategori::findOrFail($request->target_id);

        // Sudah ganti sesuai DB: id_kategori
        $movedCount = Produk::where('id_kategori', $source->id)->update(['id_kategori' => $target->id]);

        // Hapus source setelah move
        $source->delete();

        return back()->with('success', "Berhasil memindahkan {$movedCount} produk dari \"{$source->nama_kategori}\" ke \"{$target->nama_kategori}\". Kategori \"{$source->nama_kategori}\" telah dihapus!");
    }

    // ================= SUPPLIER =================
    // HANYA NAMA SAJA, TANPA KONTAK/ALAMAT

    public function storeSupplier(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255|unique:suppliers,nama_supplier',
        ]);

        $nama = $request->nama_supplier;
        Supplier::create([
            'nama_supplier' => $nama,
        ]);

        return back()->with('success', "Supplier dengan nama \"{$nama}\" telah dibuat!");
    }

    public function updateSupplier(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'nama_supplier' => 'required|string|max:255|unique:suppliers,nama_supplier,' . $supplier->id,
        ]);

        $namaLama = $supplier->nama_supplier;
        $namaBaru = $request->nama_supplier;
        $supplier->update([
            'nama_supplier' => $namaBaru,
        ]);

        // Update di produk jika nama disimpan di sana (asumsi FK, skip jika pure FK)
        // Produk::where('nama_supplier', $namaLama)->update(['nama_supplier' => $namaBaru]);

        return back()->with('success', "Supplier dengan nama \"{$namaBaru}\" telah diubah!");
    }

    public function destroySupplier($id)
    {
        $supplier = Supplier::withCount('produk')->findOrFail($id);

        if ($supplier->produk_count > 0) {
            return back()->with('error', 'Supplier tidak dapat dihapus karena masih digunakan oleh produk. Pindahkan dulu semua produk ke supplier lain.');
        }

        $nama = $supplier->nama_supplier;
        $supplier->delete();

        return back()->with('success', "Supplier dengan nama \"{$nama}\" telah dihapus!");
    }

    // TAMBAHAN: Move semua produk dari source supplier ke target
    public function moveSupplier(Request $request)
    {
        $request->validate([
            'source_id' => 'required|exists:suppliers,id',
            'target_id' => 'required|exists:suppliers,id|different:source_id',
        ]);

        $source = Supplier::findOrFail($request->source_id);
        $target = Supplier::findOrFail($request->target_id);

        // Sudah ganti sesuai DB: id_supplier
        $movedCount = Produk::where('id_supplier', $source->id)->update(['id_supplier' => $target->id]);

        // Hapus source setelah move
        $source->delete();

        return back()->with('success', "Berhasil memindahkan {$movedCount} produk dari \"{$source->nama_supplier}\" ke \"{$target->nama_supplier}\". Supplier \"{$source->nama_supplier}\" telah dihapus!");
    }

    // ================= SATUAN (NAMA SAJA) =================

    public function storeSatuan(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255|unique:satuans,nama_satuan',
        ]);

        $nama = $request->nama_satuan;
        Satuan::create([
            'nama_satuan' => $nama,
        ]);

        return back()->with('success', "Satuan dengan nama \"{$nama}\" telah dibuat!");
    }

    public function updateSatuan(Request $request, $id)
    {
        $satuan = Satuan::findOrFail($id);

        $request->validate([
            'nama_satuan' => 'required|string|max:255|unique:satuans,nama_satuan,' . $satuan->id,
        ]);

        $namaLama = $satuan->nama_satuan;
        $namaBaru = $request->nama_satuan;
        $satuan->update([
            'nama_satuan' => $namaBaru,
        ]);

        // Update di produk jika nama disimpan di sana (asumsi FK, skip jika pure FK)
        // Produk::where('nama_satuan', $namaLama)->update(['nama_satuan' => $namaBaru]);

        return back()->with('success', "Satuan dengan nama \"{$namaBaru}\" telah diubah!");
    }

    public function destroySatuan($id)
    {
        $satuan = Satuan::withCount('produk')->findOrFail($id);

        if ($satuan->produk_count > 0) {
            return back()->with('error', 'Satuan tidak dapat dihapus karena masih digunakan oleh produk. Pindahkan dulu semua produk ke satuan lain.');
        }

        $nama = $satuan->nama_satuan;
        $satuan->delete();

        return back()->with('success', "Satuan dengan nama \"{$nama}\" telah dihapus!");
    }

    // TAMBAHAN: Move semua produk dari source satuan ke target
    public function moveSatuan(Request $request)
    {
        $request->validate([
            'source_id' => 'required|exists:satuans,id',
            'target_id' => 'required|exists:satuans,id|different:source_id',
        ]);

        $source = Satuan::findOrFail($request->source_id);
        $target = Satuan::findOrFail($request->target_id);

        // Sudah ganti sesuai DB: id_satuan
        $movedCount = Produk::where('id_satuan', $source->id)->update(['id_satuan' => $target->id]);

        // Hapus source setelah move
        $source->delete();

        return back()->with('success', "Berhasil memindahkan {$movedCount} produk dari \"{$source->nama_satuan}\" ke \"{$target->nama_satuan}\". Satuan \"{$source->nama_satuan}\" telah dihapus!");
    }
}


