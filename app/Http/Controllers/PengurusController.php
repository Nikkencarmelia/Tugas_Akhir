<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengurusController extends Controller
{
    /**
     * Tampilkan daftar pengurus di halaman manajemen super admin
     */

    public function index()
    {
        $kepengurusan = Pengurus::latest()->get();
        return view('super_admin.manajemenPengurus', compact('kepengurusan'));
    }

    /**
     * Simpan pengurus baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'jabatan'   => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $gambar = $request->file('gambar')->store('pengurus', 'public');

        Pengurus::create([
            'nama'      => $request->nama,
            'jabatan'   => $request->jabatan,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $gambar,
        ]);

        return redirect()->back()->with('success', 'Pengurus berhasil ditambahkan');
    }

    /**
     * Update pengurus
     */
    public function update(Request $request, $id)
    {
        $pengurus = Pengurus::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'jabatan'   => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $gambar = $pengurus->gambar;
        if ($request->hasFile('gambar')) {
            if ($gambar) {
                Storage::disk('public')->delete($gambar);
            }
            $gambar = $request->file('gambar')->store('pengurus', 'public');
        }

        $pengurus->update([
            'nama'      => $request->nama,
            'jabatan'   => $request->jabatan,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $gambar,
        ]);

        return redirect()->back()->with('success', 'Pengurus berhasil diperbarui');
    }

    /**
     * Halaman Laporan Super Admin
     */

    /**
     * Hapus pengurus
     */
    public function destroy($id)
    {
        $pengurus = Pengurus::findOrFail($id);

        if ($pengurus->gambar) {
            Storage::disk('public')->delete($pengurus->gambar);
        }

        $pengurus->delete();

        return redirect()->back()->with('success', 'Pengurus berhasil dihapus');
    }
}
