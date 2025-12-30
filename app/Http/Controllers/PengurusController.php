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
            'nama' => 'required',
            'jabatan' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image'
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

        $gambar = $pengurus->gambar;
        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($pengurus->gambar);
            $gambar = $request->file('gambar')->store('pengurus', 'public');
        }

        $pengurus->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
        ]);

        return redirect()->back()->with('success', 'Pengurus berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pengurus = Pengurus::findOrFail($id);
        Storage::disk('public')->delete($pengurus->gambar);
        $pengurus->delete();

        return redirect()->back()->with('success', 'Pengurus berhasil dihapus');
    }


    public function tampilBeranda()
    {
        $pengurus = Pengurus::latest()->get();
        return view('beranda.pengurus', compact('pengurus'));
    }
}
