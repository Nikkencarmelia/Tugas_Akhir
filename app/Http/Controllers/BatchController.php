<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BatchController extends Controller
{
    public function index($id_produk, Request $request)
    {

        $referrerRoute = $request->query('from', 'produk.data');
        $queryParams = $request->except(['from', 'page', 'search']);
        Session::put('batch_referrer', [
            'route' => $referrerRoute,
            'query' => $queryParams,
        ]);

        $produk = Produk::with(['kategori', 'supplier', 'satuan'])->findOrFail($id_produk);

        $query = Batch::where('id_produk', $id_produk);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('kode_batch', 'like', "%{$search}%")
                    ->orWhere('harga_normal', 'like', "%{$search}%")
                    ->orWhere('harga_saat_ini', 'like', "%{$search}%")
                    ->orWhere('stok', 'like', "%{$search}%")
                    ->orWhere('keterangan_harga', 'like', "%{$search}%")
                    ->orWhere('tgl_masuk', 'like', "%{$search}%")
                    ->orWhere('tgl_kadaluwarsa', 'like', "%{$search}%")
                    ->orWhereHas('produk', function ($sub) use ($search) {
                        $sub->where('kode_produk', 'like', "%{$search}%");
                    });
            });
        }

        $batches = $query->latest()
            ->paginate(10)
            ->through(function ($batch) {

                $batch->tgl_masuk_format = Carbon::parse($batch->tgl_masuk)->format('d/m/Y');
                $batch->tgl_kadaluwarsa_format = Carbon::parse($batch->tgl_kadaluwarsa)->format('d/m/Y');
                $batch->tgl_perubahan_format = $batch->tgl_perubahan_harga ? Carbon::parse($batch->tgl_perubahan_harga)->format('d/m/Y H:i') : '-';

                $today = Carbon::today();
                $exp = Carbon::parse($batch->tgl_kadaluwarsa)->startOfDay();
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

                $batch->harga_normal_rp = 'Rp '.number_format($batch->harga_normal, 0, ',', '.');
                $batch->harga_saat_ini_rp = 'Rp '.number_format($batch->harga_saat_ini, 0, ',', '.');

                if ($batch->harga_saat_ini < $batch->harga_normal) {
                    $pct = round((($batch->harga_normal - $batch->harga_saat_ini) / $batch->harga_normal) * 100);
                    $batch->keterangan = "Diskon {$pct}%";
                } elseif ($batch->harga_saat_ini > $batch->harga_normal) {
                    $pct = round((($batch->harga_saat_ini - $batch->harga_normal) / $batch->harga_normal) * 100);
                    $batch->keterangan = "Naik {$pct}%";
                } else {
                    $batch->keterangan = 'Normal';
                }

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

        $total_stok = Batch::where('id_produk', $id_produk)->sum('stok');
        $status_stok = $total_stok <= 0 ? 'Habis' : ($total_stok <= 10 ? 'Menipis' : 'Tersedia');

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
            'tgl_masuk' => 'required|date',
            'tgl_kadaluwarsa' => 'required|date|after_or_equal:tgl_masuk',
            'harga_normal' => 'required|integer|min:0',
            'harga_saat_ini' => 'required|integer|min:0',
        ]);

        $produk = Produk::findOrFail($request->id_produk);

        $tglMasuk = $request->tgl_masuk
                    ? Carbon::parse($request->tgl_masuk)
                    : Carbon::today();

        if ($request->filled('tgl_kadaluwarsa')) {
            $tglKadaluwarsa = Carbon::parse($request->tgl_kadaluwarsa);
        } else {

            if (! $produk->estimasi_kadaluwarsa_hari || $produk->estimasi_kadaluwarsa_hari < 1) {
                return back()->with('error', 'Produk belum punya estimasi kadaluarsa. Silakan isi tanggal kadaluarsa secara manual.');
            }
            $tglKadaluwarsa = $tglMasuk->copy()->addDays($produk->estimasi_kadaluwarsa_hari);
        }

        $todayStr = Carbon::today()->format('dmY');
        $prodCode = $produk->kode_produk;

        $latestBatch = Batch::where('id_produk', $produk->id)->count();
        $sequence = str_pad($latestBatch + 1, 3, '0', STR_PAD_LEFT);
        $kodeBatch = "BATCH-{$todayStr}-{$prodCode}-{$sequence}";

        Batch::create([
            'id_produk' => $produk->id,
            'kode_batch' => $kodeBatch,
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
        $batch = Batch::findOrFail($id);

        $request->validate([
            'tgl_kadaluwarsa' => 'required|date',
            'stok' => 'required|integer|min:0',
            'harga_normal' => 'required|integer|min:0',
            'harga_saat_ini' => 'required|integer|min:0',
        ]);

        $priceChanged = ((float) $batch->harga_normal !== (float) $request->harga_normal || (float) $batch->harga_saat_ini !== (float) $request->harga_saat_ini);

        $data = [
            'tgl_kadaluwarsa' => $request->tgl_kadaluwarsa,
            'stok' => $request->stok,
            'harga_normal' => $request->harga_normal,
            'harga_saat_ini' => $request->harga_saat_ini,
            'status_stok' => $this->hitungStatusStok($request->stok),
        ];

        if ($priceChanged) {
            $data['tgl_perubahan_harga'] = now();

            if ($request->harga_saat_ini < $request->harga_normal) {
                $data['keterangan_harga'] = 'diskon';
            } elseif ($request->harga_saat_ini > $request->harga_normal) {
                $data['keterangan_harga'] = 'harga naik';
            } else {
                $data['keterangan_harga'] = 'normal';
            }
        }

        $batch->update($data);

        return back()->with('success', 'Batch berhasil diupdate');
    }

    public function destroy($id)
    {
        Batch::findOrFail($id)->delete();

        return back()->with('success', 'Batch berhasil dihapus');
    }

    public function applyDiscount(Request $request, $id)
    {
        $request->validate([
            'diskon_percent' => 'required|numeric|min:0|max:100',
        ]);

        $batch = Batch::findOrFail($id);
        $diskonPercent = $request->diskon_percent;

        $hargaSetelahDiskon = $batch->harga_normal - ($batch->harga_normal * $diskonPercent / 100);
        $hargaSetelahDiskon = round($hargaSetelahDiskon);

        $batch->update([
            'harga_saat_ini' => $hargaSetelahDiskon,
            'tgl_perubahan_harga' => now(),
            'keterangan_harga' => 'diskon',
        ]);

        return back()->with('success', "Diskon {$diskonPercent}% berhasil diterapkan. Harga baru: Rp ".number_format($hargaSetelahDiskon, 0, ',', '.'));
    }

    public function increasePrice(Request $request, $id)
    {
        $request->validate([
            'harga_saat_ini' => 'required|numeric|min:0',
        ]);

        $batch = Batch::findOrFail($id);
        $hargaBaru = (int) $request->harga_saat_ini;

        $pct = $batch->harga_normal > 0 ? round((($hargaBaru - $batch->harga_normal) / $batch->harga_normal * 100)) : 0;
        $keteranganDisplay = $pct > 0 ? "Naik {$pct}%" : 'Harga Diperbarui';

        $keteranganHarga = $pct > 0 ? 'harga naik' : 'normal';

        $batch->update([
            'harga_saat_ini' => $hargaBaru,
            'tgl_perubahan_harga' => now(),
            'keterangan_harga' => $keteranganHarga,
        ]);

        return back()->with('success', 'Harga baru Rp '.number_format($hargaBaru, 0, ',', '.')." berhasil diterapkan. Keterangan: {$keteranganDisplay}.");
    }

    private function hitungStatusStok($stok)
    {
        if ($stok <= 0) {
            return 'habis';
        }
        if ($stok <= 10) {
            return 'menipis';
        }

        return 'tersedia';
    }
}
