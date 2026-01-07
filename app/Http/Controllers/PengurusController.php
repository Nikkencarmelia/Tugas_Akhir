<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengurusController extends Controller
{
    public function index()
    {
        $kepengurusan = Pengurus::latest()->get();

        return view('super_admin.manajemenPengurus', compact('kepengurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $gambar = $request->file('gambar')->store('pengurus', 'public');

        Pengurus::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
        ]);

        return redirect()->back()->with('success', 'Pengurus berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $pengurus = Pengurus::findOrFail($id);

        $request->validate([
            'nama' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data = [];
        if ($request->filled('nama')) $data['nama'] = $request->nama;
        if ($request->filled('jabatan')) $data['jabatan'] = $request->jabatan;
        if ($request->filled('deskripsi')) $data['deskripsi'] = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            if ($pengurus->gambar) {
                Storage::disk('public')->delete($pengurus->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('pengurus', 'public');
        }

        if (!empty($data)) {
            $pengurus->update($data);
            return redirect()->back()->with('success', 'Pengurus berhasil diperbarui');
        }

        return redirect()->back()->with('info', 'Tidak ada data yang diubah');
    }

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
