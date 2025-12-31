<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk_Rusak;
use App\Models\Batch;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProdukRusakCacatController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Produk::with([
                'kategori',
                'supplier',
                'satuan',
                'rusak' => function ($q) {
                    $q->select('id_produk')->selectRaw('SUM(jumlah_rusak) as total_rusak')->groupBy('id_produk');
                }
            ])->whereHas('rusak', function ($q) {
                $q->havingRaw('SUM(jumlah_rusak) > 0');
            });

            // Filters
            if ($request->filled('status_tampil') && $request->status_tampil != 'all') {
                $query->where('status_tampil', $request->status_tampil);
            }
            if ($request->filled('status_stok') && $request->status_stok != 'all') {
                $query->where('status_stok', $request->status_stok);
            }
            if ($request->filled('supplier') && $request->supplier != 'all') {
                $query->where('id_supplier', $request->supplier);
            }
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%{$search}%")
                      ->orWhere('nama_produk', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            }

            $produk = $query->paginate(10);

            $supplier = collect();
            try {
                $supplier = Supplier::select('id', 'nama_supplier')->get();
                Log::info('Suppliers loaded successfully', ['count' => $supplier->count()]);
            } catch (\Exception $e) {
                Log::error('Failed to load suppliers', ['error' => $e->getMessage()]);
            }

            return view('Staff_Produk.rusakCacat', compact('produk', 'supplier'));
        } catch (\Exception $e) {
            Log::error('Error in index rusak_cacat', ['error' => $e->getMessage(), 'line' => $e->getLine()]);
            return view('Staff_Produk.rusakCacat', ['produk' => collect(), 'supplier' => collect()]);
        }
    }

    public function show($id_produk)
    {
        $produk = Produk::with(['kategori', 'supplier', 'satuan'])->findOrFail($id_produk);

        $damaged_batches = Produk_Rusak::with(['batch', 'produk'])
            ->where('id_produk', $id_produk)
            ->paginate(10) // FIXED: Paginate untuk dynamic pagination
            ->map(function ($rusak) use ($produk) {
                $tanggalDitemukan = $rusak->tgl_rusak ? Carbon::parse($rusak->tgl_rusak)->format('Y-m-d') : now()->format('Y-m-d');
                $tanggalMasukFallback = $rusak->batch->tgl_masuk ?? now()->format('Y-m-d');
                return [
                    'batch_id' => $rusak->batch->id ?? 0,
                    'tanggal_masuk' => $rusak->batch->tgl_masuk_format ?? Carbon::parse($tanggalMasukFallback)->format('d/m/Y'),
                    'harga_normal' => 'Rp ' . number_format($rusak->batch->harga_normal ?? 0, 0, ',', '.'),
                    'jumlah_rusak' => $rusak->jumlah_rusak ?? 0,
                    'keterangan' => $rusak->keterangan ?? '-',
                    'tanggal_ditemukan' => $tanggalDitemukan,
                    'tingkat_kerusakan' => ucfirst($rusak->tingkat_rusak ?? 'Sedang'),
                    'bukti_foto' => $rusak->gambar ? asset('storage/' . $rusak->gambar) : asset('storage/' . $produk->gambar),
                ];
            });

        return view('Staff_Produk.detail_rusak_batch', compact('produk', 'damaged_batches'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_produk' => 'required|exists:produks,id',
                'id_batch' => 'required|exists:batches,id',
                'jumlah_rusak' => 'required|integer|min:1',
                'tgl_rusak' => 'required|date',
                'tingkat_rusak' => 'required|in:ringan,sedang,berat',
                'keterangan' => 'nullable|string|max:500',
                'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ], [
                'tingkat_rusak.in' => 'Tingkat kerusakan harus ringan, sedang, atau berat.',
                'id_batch.exists' => 'Batch tidak valid.',
                'gambar.image' => 'File harus berupa gambar.',
                'gambar.mimes' => 'Gambar harus JPG, JPEG, atau PNG.',
                'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            ]);

            Log::info('Validation passed', $validated);

            $batch = Batch::findOrFail($validated['id_batch']);

            if ($validated['jumlah_rusak'] > $batch->stok) {
                return back()->withInput()->with('error', 'Jumlah rusak melebihi stok batch saat ini (' . $batch->stok . ')!');
            }

            if (!$request->hasFile('gambar') || !$request->file('gambar')->isValid()) {
                throw new \Exception('File gambar tidak valid atau tidak terupload.');
            }

            $path = $request->file('gambar')->store('produk_rusak', 'public');
            Log::info('Image uploaded to: ' . $path);

            $rusak = Produk_Rusak::create([
                'id_produk' => $validated['id_produk'],
                'id_batch' => $validated['id_batch'],
                'tgl_rusak' => $validated['tgl_rusak'],
                'jumlah_rusak' => $validated['jumlah_rusak'],
                'tingkat_rusak' => $validated['tingkat_rusak'],
                'keterangan' => $validated['keterangan'] ?? null,
                'gambar' => $path,
            ]);

            Log::info('Record created: ', $rusak->toArray());

            $batch->stok -= $validated['jumlah_rusak'];
            $batch->save();

            if ($batch->stok <= 0) {
                $batch->status_stok = 'habis';
                $batch->save();
            }

            Log::info('Batch updated: stok=' . $batch->stok);

            return redirect()->back()->with('success', 'Laporan rusak berhasil disimpan! Stok batch dikurangi ' . $validated['jumlah_rusak'] . ' unit.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed: ' . $e->getMessage());
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error in store produk rusak: ' . $e->getMessage() . ' | Line: ' . $e->getLine() . ' | File: ' . $e->getFile());
            return back()->withInput()->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }
}
