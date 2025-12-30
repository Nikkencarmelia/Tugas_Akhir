<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Batch;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BatchController extends Controller
{
    public function index($id_produk)
    {
        $produk = Produk::with(['kategori','supplier','satuan'])->findOrFail($id_produk);

        $batches = Batch::where('id_produk', $id_produk)
            ->latest()
            ->get()
            ->map(function ($batch) {

                // FORMAT TANGGAL
                $batch->tgl_masuk_format = Carbon::parse($batch->tgl_masuk)->format('d/m/Y');
                $batch->tgl_kadaluarsa_format = Carbon::parse($batch->tgl_kadaluarsa)->format('d/m/Y');

                // SISA HARI
                $today = Carbon::today();
                $exp = Carbon::parse($batch->tgl_kadaluarsa)->startOfDay();
                $diff = $today->diffInDays($exp, false);

                if ($diff < 0) {
                    $batch->sisa_text = abs($diff).' hari lalu';
                    $batch->sisa_color = 'text-danger';
                } elseif ($diff === 0) {
                    $batch->sisa_text = 'Hari ini';
                    $batch->sisa_color = 'text-warning';
                } elseif ($diff <= 7) {
                    $batch->sisa_text = $diff.' hari lagi';
                    $batch->sisa_color = 'text-warning';
                } else {
                    $batch->sisa_text = $diff.' hari lagi';
                    $batch->sisa_color = 'text-success';
                }

                // FORMAT HARGA
                $batch->harga_normal_rp = 'Rp '.number_format($batch->harga_normal,0,',','.');
                $batch->harga_saat_ini_rp = 'Rp '.number_format($batch->harga_saat_ini,0,',','.');

                // KETERANGAN HARGA
                if ($batch->harga_saat_ini < $batch->harga_normal) {
                    $pct = round((($batch->harga_normal - $batch->harga_saat_ini) / $batch->harga_normal) * 100);
                    $batch->keterangan = "Diskon {$pct}%";
                } elseif ($batch->harga_saat_ini > $batch->harga_normal) {
                    $pct = round((($batch->harga_saat_ini - $batch->harga_normal) / $batch->harga_normal) * 100);
                    $batch->keterangan = "Naik {$pct}%";
                } else {
                    $batch->keterangan = 'Normal';
                }

                // STATUS STOK
                if ($batch->stok <= 0) {
                    $batch->status_stok_text = 'Habis';
                    $batch->status_stok_badge = 'badge-habis';
                } elseif ($batch->stok <= 10) {
                    $batch->status_stok_text = 'Menipis';
                    $batch->status_stok_badge = 'badge-menipis';
                } else {
                    $batch->status_stok_text = 'Tersedia';
                    $batch->status_stok_badge = 'badge-tersedia';
                }

                return $batch;
            });

        $total_stok = $batches->sum('stok');
        $status_stok = $total_stok <= 0 ? 'Habis' : ($total_stok <= 10 ? 'Menipis' : 'Tersedia');

        // DEFAULT UNTUK FORM
        $default_kadaluarsa = $produk->estimasi_kadaluwarsa_hari
            ? Carbon::today()->addDays($produk->estimasi_kadaluwarsa_hari)->format('Y-m-d')
            : '';

        return view('Staff_Produk.batchStok', compact(
            'produk',
            'batches',
            'total_stok',
            'status_stok',
            'default_kadaluarsa'
        ));
    }

    public function store(Request $request)
{
    $request->validate([
        'id_produk' => 'required|exists:produks,id',
        'stok' => 'required|integer|min:1',
        'tgl_masuk' => 'nullable|date',
        'harga_normal' => 'required|integer|min:0',
        'harga_saat_ini' => 'required|integer|min:0',
    ]);

    $produk = Produk::findOrFail($request->id_produk);

    if (!$produk->estimasi_kadaluwarsa_hari || $produk->estimasi_kadaluwarsa_hari < 1) {
        return back()->with('error', 'Produk belum punya estimasi kadaluarsa.');
    }

    // ✅ tanggal masuk
    $tglMasuk = $request->tgl_masuk
        ? Carbon::parse($request->tgl_masuk)
        : Carbon::today();

    // ✅ HITUNG ULANG DI BACKEND (TANPA PERCAYA FORM)
    $tglKadaluwarsa = $tglMasuk->copy()->addDays($produk->estimasi_kadaluwarsa_hari);

    Batch::create([
        'id_produk' => $produk->id,
        'tgl_masuk' => $tglMasuk,
        'tgl_kadaluwarsa' => $tglKadaluwarsa,
        'stok' => $request->stok,
        'harga_normal' => $request->harga_normal,
        'harga_saat_ini' => $request->harga_saat_ini,
        'tgl_perubahan_harga' => now(),
        'status_stok' => $this->hitungStatusStok($request->stok),
        'keterangan_harga' => 'normal',
    ]);

    return back()->with('success', 'Batch berhasil ditambahkan');
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_masuk' => 'required|date',
            'tgl_kadaluwarsa' => 'required|date|after_or_equal:tgl_masuk',
            'stok' => 'required|integer|min:1',
            'harga_normal' => 'required|integer|min:0',
            'harga_saat_ini' => 'required|integer|min:0',
        ]);

        $batch = Batch::findOrFail($id);

        $batch->update([
            'tgl_masuk' => $request->tgl_masuk,
            'tgl_kadaluwarsa' => $request->tgl_kadaluwarsa,
            'stok' => $request->stok,
            'harga_normal' => $request->harga_normal,
            'harga_saat_ini' => $request->harga_saat_ini,
            'tgl_perubahan_harga' => now(),
            'status_stok' => $this->hitungStatusStok($request->stok),
        ]);

        return back()->with('success', 'Batch berhasil diupdate');
    }

    public function destroy($id)
    {
        Batch::findOrFail($id)->delete();
        return back()->with('success', 'Batch berhasil dihapus');
    }

    private function hitungStatusStok($stok)
    {
        if ($stok <= 0) return 'habis';
        if ($stok <= 10) return 'menipis';
        return 'tersedia';
    }
}
