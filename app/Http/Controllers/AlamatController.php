<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KodePos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlamatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $activeTab = $request->get('tab', session('active_tab', 'info'));

        return view('user.profil', [
            'user' => $user,
            'kecamatans' => Kecamatan::all(),
            'alamats' => $user
                ->alamats()
                ->with(['kecamatan','kelurahan','kodePos'])
                ->get(),
            'activeTab' => $activeTab
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // batas maksimal 10 alamat per user
        if ($user->alamats()->count() >= 10) {
            return back()->withErrors([
                'alamat' => 'Maksimal 10 alamat pengiriman'
            ]);
        }

        $request->validate([
            'nama_penerima' => 'required|string|max:100',
            'no_telpon' => 'required|string|max:20',
            'id_kecamatan' => 'required|exists:kecamatans,id',
            'id_kelurahan' => 'required|exists:kelurahans,id',
            'id_kode_pos' => 'required|exists:kode_pos,id',
            'alamat_lengkap' => 'required|string',
        ]);

        Alamat::create([
            'id_user' => $user->id,
            'nama_penerima' => $request->nama_penerima,
            'no_telpon' => $request->no_telpon,
            'id_kecamatan' => $request->id_kecamatan,
            'id_kelurahan' => $request->id_kelurahan,
            'id_kode_pos' => $request->id_kode_pos,
            'alamat_lengkap' => $request->alamat_lengkap,
        ]);

        session(['active_tab' => 'alamat']);

        return back()->with('success', 'Alamat berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $alamat = Alamat::where('id', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        $request->validate([
            'nama_penerima' => 'required|string|max:100',
            'no_telpon' => 'required|string|max:20',
            'id_kecamatan' => 'required|exists:kecamatans,id',
            'id_kelurahan' => 'required|exists:kelurahans,id',
            'id_kode_pos' => 'required|exists:kode_pos,id',
            'alamat_lengkap' => 'required|string',
        ]);

        $alamat->update([
            'nama_penerima' => $request->nama_penerima,
            'no_telpon' => $request->no_telpon,
            'id_kecamatan' => $request->id_kecamatan,
            'id_kelurahan' => $request->id_kelurahan,
            'id_kode_pos' => $request->id_kode_pos,
            'alamat_lengkap' => $request->alamat_lengkap,
        ]);

        session(['active_tab' => 'alamat']);

        return back()->with('success', 'Alamat berhasil diperbarui');
    }

    public function destroy($id)
    {
        $alamat = Alamat::where('id', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        $alamat->delete();

        session(['active_tab' => 'alamat']);

        return back()->with('success', 'Alamat berhasil dihapus');
    }

    // ================= AJAX DROPDOWN =================

    public function kelurahanByKecamatan($id)
    {
        return Kelurahan::where('id_kecamatan', $id)->get();
    }

    public function kodePosByKelurahan($id)
    {
        return KodePos::where('id_kelurahan', $id)->get();
    }
}
