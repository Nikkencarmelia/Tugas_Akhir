<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KodePos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OngkirDaerahController extends Controller
{
    // Index tetep gak diganggu, cuma tambah filtering optional
    public function index(Request $request)
    {
        $queryKec = Kecamatan::withCount('kelurahan');
        if ($request->filled('search_kecamatan')) {
            $queryKec->where('nama_kecamatan', 'like', '%' . $request->search_kecamatan . '%');
        }
        $kecamatan = $queryKec->get();

        $queryKel = Kelurahan::with('kecamatan')->withCount('kodePos');
        if ($request->filled('filter_kec_kelurahan')) {
            $queryKel->where('id_kecamatan', $request->filter_kec_kelurahan);
        }
        if ($request->filled('search_kelurahan')) {
            $queryKel->where('nama_kelurahan', 'like', '%' . $request->search_kelurahan . '%');
        }
        $kelurahan = $queryKel->get();

        $queryKp = KodePos::with('kelurahan.kecamatan');
        if ($request->filled('filter_kec_kodepos')) {
            $queryKp->whereHas('kelurahan', function ($q) use ($request) {
                $q->where('id_kecamatan', $request->filter_kec_kodepos);
            });
        }
        if ($request->filled('filter_kel_kodepos')) {
            $queryKp->where('id_kelurahan', $request->filter_kel_kodepos);
        }
        if ($request->filled('search_kodepos')) {
            $queryKp->where('kode_pos', 'like', '%' . $request->search_kodepos . '%');
        }
        $kodepos = $queryKp->get();

        // Diperbaiki: Load all kelurahan jika tidak ada filter kecamatan, dengan label yang unik (nama_kelurahan - nama_kecamatan)
        $filter_kelurahans = collect();
        if ($request->filled('filter_kec_kodepos')) {
            $filter_kelurahans = Kelurahan::where('id_kecamatan', $request->filter_kec_kodepos)
                ->with('kecamatan')
                ->get()
                ->mapWithKeys(function ($kel) {
                    return [$kel->id => $kel->nama_kelurahan . ' - ' . $kel->kecamatan->nama_kecamatan];
                });
        } else {
            $filter_kelurahans = Kelurahan::with('kecamatan')
                ->get()
                ->mapWithKeys(function ($kel) {
                    return [$kel->id => $kel->nama_kelurahan . ' - ' . $kel->kecamatan->nama_kecamatan];
                });
        }

        $activeTab = $request->get('tab', 'kecamatan');

        // Handle AJAX for live search
        if ($request->ajax()) {
            $partialView = 'staff_purchasing.ongkirDaerah._table_' . $activeTab;
            $partialHtml = '';
            if ($activeTab === 'kecamatan') {
                $partialHtml = view($partialView, compact('kecamatan'))->render();
            } elseif ($activeTab === 'kelurahan') {
                $partialHtml = view($partialView, compact('kelurahan'))->render();
            } elseif ($activeTab === 'kodepos') {
                $partialHtml = view($partialView, compact('kodepos'))->render();
            }
            return response()->json([
                'html' => $partialHtml
            ]);
        }

        return view('staff_purchasing.ongkirDaerah', compact(
            'kecamatan', 'kelurahan', 'kodepos', 'filter_kelurahans', 'activeTab'
        ));
    }

    // KECAMATAN
    public function kecamatanIndex()
    {
        return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kecamatan']);
    }

    public function kecamatanStore(Request $r)
    {
        try {
            $validated = $r->validate([
                'nama_kecamatan' => 'required|string|max:255',
                'ongkir_minimal_mobil' => 'required|integer|min:0',
                'ongkir_minimal_motor' => 'required|integer|min:0'
            ]);
            Kecamatan::create($validated);
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kecamatan'])->with('success', 'Kecamatan berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Kecamatan Store Error: ' . $e->getMessage());
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kecamatan'])->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    public function kecamatanUpdate(Request $r, $id)
    {
        try {
            $kec = Kecamatan::findOrFail($id);
            $validated = $r->validate([
                'nama_kecamatan' => 'required|string|max:255',
                'ongkir_minimal_mobil' => 'required|integer|min:0',
                'ongkir_minimal_motor' => 'required|integer|min:0'
            ]);
            $kec->update($validated);
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kecamatan'])->with('success', 'Kecamatan berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Kecamatan Update Error: ' . $e->getMessage());
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kecamatan'])->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function kecamatanDestroy($id)
    {
        try {
            $kec = Kecamatan::findOrFail($id);
            if ($kec->kelurahan()->exists()) {
                return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kecamatan'])->with('error', 'Hapus kelurahan terlebih dahulu');
            }
            $kec->delete();
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kecamatan'])->with('success', 'Kecamatan berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Kecamatan Destroy Error: ' . $e->getMessage());
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kecamatan'])->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }

    // KELURAHAN (mirip, ganti nama method & route)
    public function kelurahanIndex()
    {
        return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kelurahan']);
    }

    public function kelurahanStore(Request $r)
    {
        try {
            $validated = $r->validate([
                'id_kecamatan' => 'required|exists:kecamatans,id',
                'nama_kelurahan' => 'required|string|max:255'
            ]);
            Kelurahan::create($validated);
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kelurahan'])->with('success', 'Kelurahan berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Kelurahan Store Error: ' . $e->getMessage());
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kelurahan'])->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    public function kelurahanUpdate(Request $r, $id)
    {
        try {
            $kel = Kelurahan::findOrFail($id);
            $validated = $r->validate([
                'id_kecamatan' => 'required|exists:kecamatans,id',
                'nama_kelurahan' => 'required|string|max:255'
            ]);
            $kel->update($validated);
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kelurahan'])->with('success', 'Kelurahan berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Kelurahan Update Error: ' . $e->getMessage());
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kelurahan'])->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function kelurahanDestroy($id)
    {
        try {
            $kel = Kelurahan::findOrFail($id);
            if ($kel->kodePos()->exists()) {
                return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kelurahan'])->with('error', 'Hapus kode pos terlebih dahulu');
            }
            $kel->delete();
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kelurahan'])->with('success', 'Kelurahan berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Kelurahan Destroy Error: ' . $e->getMessage());
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kelurahan'])->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }

    // KODE POS (mirip)
    public function kodeposIndex()
    {
        return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kodepos']);
    }

    public function kodeposStore(Request $r)
    {
        try {
            $validated = $r->validate([
                'id_kelurahan' => 'required|exists:kelurahans,id',
                'kode_pos' => 'required|string|size:5|regex:/^\d{5}$/'
            ]);
            KodePos::create($validated);
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kodepos'])->with('success', 'Kode pos berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('KodePos Store Error: ' . $e->getMessage());
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kodepos'])->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    public function kodeposUpdate(Request $r, $id)
    {
        try {
            $kp = KodePos::findOrFail($id);
            $validated = $r->validate([
                'id_kelurahan' => 'required|exists:kelurahans,id',
                'kode_pos' => 'required|string|size:5|regex:/^\d{5}$/'
            ]);
            $kp->update($validated);
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kodepos'])->with('success', 'Kode pos berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('KodePos Update Error: ' . $e->getMessage());
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kodepos'])->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function kodeposDestroy($id)
    {
        try {
            $kp = KodePos::findOrFail($id);
            $kp->delete();
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kodepos'])->with('success', 'Kode pos berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('KodePos Destroy Error: ' . $e->getMessage());
            return redirect()->route('staff_purchasing.ongkir.index', ['tab' => 'kodepos'])->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }

    // AJAX Helper
    public function getKelurahanByKecamatan($id)
    {
        try {
            $kelurahans = Kelurahan::where('id_kecamatan', $id)->get(['id', 'nama_kelurahan']);
            return response()->json($kelurahans);
        } catch (\Exception $e) {
            Log::error('Get Kelurahan Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat kelurahan'], 500);
        }
    }

    public function getMinimalOngkir(Request $request, $id_kecamatan)
    {
        try {
            $kec = Kecamatan::findOrFail($id_kecamatan);
            $kendaraan = $request->query('kendaraan');
            if (!$kendaraan || !in_array($kendaraan, ['Mobil', 'Motor'])) {
                return response()->json(['minimal' => 0], 400);
            }
            $minimal = $kendaraan === 'Mobil' ? $kec->ongkir_minimal_mobil : $kec->ongkir_minimal_motor;
            return response()->json(['minimal' => $minimal]);
        } catch (\Exception $e) {
            Log::error('Get Minimal Ongkir Error: ' . $e->getMessage());
            return response()->json(['minimal' => 0], 500);
        }
    }
}
