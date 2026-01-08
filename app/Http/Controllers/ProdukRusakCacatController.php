<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Produk;
use App\Models\Produk_Rusak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ProdukRusakCacatController extends Controller
{
    public function index(Request $request)
    {

        $produkAll = Produk::with([
            'kategori',
            'supplier',
            'satuan',
            'rusak' => function ($q) {
                $q->select('id_produk')
                    ->selectRaw('SUM(jumlah_rusak) as total_rusak')
                    ->groupBy('id_produk');
            },
        ])
            ->whereHas('rusak', function ($q) {
                $q->havingRaw('SUM(jumlah_rusak) > 0');
            })
            ->latest()
            ->get();

        $kategoris = $produkAll
            ->pluck('kategori.nama_kategori')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $suppliers = $produkAll
            ->pluck('supplier.nama_supplier')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('Staff_Produk.rusakCacat', [
            'produkAll' => $produkAll,
            'kategori' => $kategoris,
            'supplier' => $suppliers,
        ]);
    }

    public function show($id_produk)
    {
        $produk = Produk::with(['kategori', 'supplier', 'satuan'])->findOrFail($id_produk);

        $paginator = Produk_Rusak::with(['batch', 'produk'])
            ->where('id_produk', $id_produk)
            ->orderBy('tgl_rusak', 'desc')
            ->paginate(10);

        $totalDamaged = $paginator->total();

        $mappedItems = $paginator->getCollection()->map(function ($rusak) use ($produk) {
            $tanggalDitemukan = $rusak->tgl_rusak ? Carbon::parse($rusak->tgl_rusak)->format('d/m/Y') : now()->format('d/m/Y');
            $tanggalMasukFallback = $rusak->batch->tgl_masuk ?? now()->format('Y-m-d');

            return [
                'batch_id' => $rusak->batch->id ?? 0,
                'kode_batch' => $rusak->batch->kode_batch ?? '-',
                'tanggal_masuk' => $rusak->batch->tgl_masuk_format ?? Carbon::parse($tanggalMasukFallback)->format('d/m/Y'),
                'harga_normal' => 'Rp '.number_format($rusak->batch->harga_normal ?? 0, 0, ',', '.'),
                'jumlah_rusak' => $rusak->jumlah_rusak ?? 0,
                'keterangan' => $rusak->keterangan ?? '-',
                'tanggal_ditemukan' => $tanggalDitemukan,
                'tingkat_kerusakan' => ucfirst($rusak->tingkat_rusak ?? 'Sedang'),
                'bukti_foto' => $rusak->gambar ? asset($rusak->gambar) : asset($produk->gambar),
            ];
        });

        $damaged_batches = new LengthAwarePaginator(
            $mappedItems,
            $paginator->total(),
            $paginator->perPage(),
            $paginator->currentPage(),
            [
                'path' => $paginator->path(),
                'pageName' => $paginator->getPageName(),
            ]
        );

        return view('Staff_Produk.detailRusak', compact('produk', 'damaged_batches', 'totalDamaged'));
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
                'gambar' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            ], [
                'tingkat_rusak.in' => 'Tingkat kerusakan harus ringan, sedang, atau berat.',
                'id_batch.exists' => 'Batch tidak valid.',
                'gambar.image' => 'File harus berupa gambar.',
                'gambar.mimes' => 'Gambar harus JPG, JPEG, atau PNG.',
                'gambar.max' => 'Ukuran gambar maksimal 5MB.',
            ]);

            Log::info('Validation passed', $validated);

            $batch = Batch::findOrFail($validated['id_batch']);

            if ($validated['jumlah_rusak'] > $batch->stok) {
                return back()->withInput()->with('error', 'Jumlah rusak melebihi stok batch saat ini ('.$batch->stok.')!');
            }

            if (! $request->hasFile('gambar') || ! $request->file('gambar')->isValid()) {
                throw new \Exception('File gambar tidak valid atau tidak terupload.');
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/produk_rusak'), $filename);
            $path = 'images/produk_rusak/' . $filename;
            Log::info('Image uploaded to: '.$path);

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

            Log::info('Batch updated: stok='.$batch->stok);

            return redirect()->back()->with('success', 'Laporan rusak berhasil disimpan! Stok batch dikurangi '.$validated['jumlah_rusak'].' unit.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed: '.$e->getMessage());

            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error in store produk rusak: '.$e->getMessage().' | Line: '.$e->getLine().' | File: '.$e->getFile());

            return back()->withInput()->with('error', 'Gagal simpan: '.$e->getMessage());
        }
    }
}
