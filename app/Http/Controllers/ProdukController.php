<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function dashboardProduk(Request $request)
    {
        $query = Produk::with(['kategori', 'supplier', 'satuan', 'batch'])
            ->latest('created_at');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $searchLower = strtolower($search);

            $query->where(function ($q) use ($search, $searchLower) {
                $q->where('id', 'like', "%$search%")
                  ->orWhere('nama_produk', 'like', "%$search%")
                  ->orWhere('deskripsi', 'like', "%$search%")
                  ->orWhere('status_tampil', 'like', "%$search%")
                  ->orWhere('jumlah_satuan', 'like', "%$search%");

                $q->orWhereHas('kategori', fn($sub) => $sub->where('nama_kategori', 'like', "%$search%"));
                $q->orWhereHas('supplier', fn($sub) => $sub->where('nama_supplier', 'like', "%$search%"));
                $q->orWhereHas('satuan', fn($sub) => $sub->where('nama_satuan', 'like', "%$search%"));

                $q->orWhere(function ($sub) use ($searchLower) {
                    if (stripos($searchLower, 'terse') !== false || $searchLower === 'tersedia') {
                        $sub->whereHas('batch', fn($b) => $b->havingRaw('SUM(stok) > 10'));
                    } elseif (stripos($searchLower, 'menip') !== false || $searchLower === 'menipis') {
                        $sub->whereHas('batch', fn($b) => $b->havingRaw('SUM(stok) > 0 AND SUM(stok) <= 10'));
                    } elseif (stripos($searchLower, 'hab') !== false || $searchLower === 'habis') {
                        $sub->whereDoesntHave('batch')
                            ->orWhereHas('batch', fn($b) => $b->havingRaw('SUM(stok) = 0'));
                    }
                });
            });
        }

        $produkBaru = $query->take(5)->get();

        $totalProduk   = Produk::count();
        $totalTampil   = Produk::where('status_tampil', 'Ditampilkan')->count();
        $totalArsip    = Produk::where('status_tampil', 'Diarsipkan')->count();

        // FIX: SELECT cuma produks.id di subquery, biar GROUP BY aman
        $totalMenipis = DB::table(DB::raw('(SELECT produks.id FROM produks LEFT JOIN batches ON produks.id = batches.id_produk GROUP BY produks.id HAVING SUM(COALESCE(batches.stok, 0)) > 0 AND SUM(COALESCE(batches.stok, 0)) <= 10) as temp'))
                        ->count();

        $totalHabis = DB::table(DB::raw('(SELECT produks.id FROM produks LEFT JOIN batches ON produks.id = batches.id_produk GROUP BY produks.id HAVING SUM(COALESCE(batches.stok, 0)) = 0) as temp'))
                        ->count();

        return view('Staff_Produk.dashboard', compact('produkBaru', 'totalProduk', 'totalTampil', 'totalArsip', 'totalMenipis', 'totalHabis'));
    }

    public function dataProduk(Request $request)
    {
        $produkAll = Produk::with(['kategori', 'supplier', 'satuan', 'batch'])
            ->latest()
            ->get();

        $query = Produk::with(['kategori', 'supplier', 'satuan', 'batch']);

        if ($request->filled('status_tampil') && $request->status_tampil !== 'all') {
            $query->where('status_tampil', $request->status_tampil);
        }

        if ($request->filled('status_stok') && $request->status_stok !== 'all') {
            $statusStok = $request->status_stok;
            $query->where(function ($q) use ($statusStok) {
                if ($statusStok === 'Tersedia') {
                    $q->whereHas('batch', fn($b) => $b->havingRaw('SUM(stok) > 10'));
                } elseif ($statusStok === 'Menipis') {
                    $q->whereHas('batch', fn($b) => $b->havingRaw('SUM(stok) > 0 AND SUM(stok) <= 10'));
                } elseif ($statusStok === 'Habis') {
                    $q->whereDoesntHave('batch')
                      ->orWhereHas('batch', fn($b) => $b->havingRaw('SUM(stok) = 0'));
                }
            });
        }

        if ($request->filled('supplier') && $request->supplier !== 'all') {
            $query->where('id_supplier', $request->supplier);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $searchLower = strtolower($search);

            $query->where(function ($q) use ($search, $searchLower) {
                $q->where('id', 'like', "%$search%")
                  ->orWhere('nama_produk', 'like', "%$search%")
                  ->orWhere('deskripsi', 'like', "%$search%")
                  ->orWhere('status_tampil', 'like', "%$search%")
                  ->orWhere('jumlah_satuan', 'like', "%$search%");

                $q->orWhereHas('kategori', fn($sub) => $sub->where('nama_kategori', 'like', "%$search%"));
                $q->orWhereHas('supplier', fn($sub) => $sub->where('nama_supplier', 'like', "%$search%"));
                $q->orWhereHas('satuan', fn($sub) => $sub->where('nama_satuan', 'like', "%$search%"));

                $q->orWhere(function ($sub) use ($searchLower) {
                    if (stripos($searchLower, 'terse') !== false || $searchLower === 'tersedia') {
                        $sub->whereHas('batch', fn($b) => $b->havingRaw('SUM(stok) > 10'));
                    } elseif (stripos($searchLower, 'menip') !== false || $searchLower === 'menipis') {
                        $sub->whereHas('batch', fn($b) => $b->havingRaw('SUM(stok) > 0 AND SUM(stok) <= 10'));
                    } elseif (stripos($searchLower, 'hab') !== false || $searchLower === 'habis') {
                        $sub->whereDoesntHave('batch')
                            ->orWhereHas('batch', fn($b) => $b->havingRaw('SUM(stok) = 0'));
                    }
                });
            });
        }

        $produkPaginated = $query->latest()->paginate(10)->withQueryString();

        return view('Staff_Produk.dataProduk', [
            'produkAll' => $produkAll,
            'produk'    => $produkPaginated,
            'kategori'  => Kategori::all(),
            'supplier'  => Supplier::all(),
            'satuan'    => Satuan::all(),
        ]);
    }

    public function tambahProduk()
    {
        return view('Staff_Produk.tambahProduk', [
            'kategori' => Kategori::all(),
            'satuan'   => Satuan::all(),
            'supplier' => Supplier::all(),
        ]);
    }

    public function storeProduk(Request $request)
    {
        $request->validate([
            'nama_produk'              => 'required|string|max:255',
            'id_kategori'              => 'required|exists:kategoris,id',
            'id_satuan'                => 'required|exists:satuans,id',
            'id_supplier'              => 'required|exists:suppliers,id',
            'jumlah_satuan'            => 'required|numeric|min:1',
            'estimasi_kadaluwarsa_hari'=> 'nullable|integer|min:0',
            'status_tampil'            => 'required|in:Ditampilkan,Diarsipkan',
            'deskripsi'                => 'nullable|string',
            'gambar'                   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create([
            'nama_produk'               => $request->nama_produk,
            'id_kategori'               => $request->id_kategori,
            'id_satuan'                 => $request->id_satuan,
            'id_supplier'               => $request->id_supplier,
            'jumlah_satuan'             => $request->jumlah_satuan,
            'estimasi_kadaluwarsa_hari' => $request->estimasi_kadaluwarsa_hari ?? 0,
            'deskripsi'                 => $request->deskripsi,
            'status_tampil'             => $request->status_tampil,
            'gambar'                    => $gambarPath,
        ]);

        // LANGSUNG KE DATA PRODUK + TOAST MUNCUL DI SANA
        return redirect()->route('produk.data')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);

        return view('Staff_Produk.editProduk', [
            'produk'   => $produk,
            'kategori' => Kategori::all(),
            'supplier' => Supplier::all(),
            'satuan'   => Satuan::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk'              => 'required|string|max:255|unique:produks,nama_produk,' . $id,
            'id_kategori'              => 'required|exists:kategoris,id',
            'id_satuan'                => 'required|exists:satuans,id',
            'id_supplier'              => 'required|exists:suppliers,id',
            'jumlah_satuan'            => 'required|numeric|min:1',
            'estimasi_kadaluwarsa_hari'=> 'nullable|integer|min:0',
            'status_tampil'            => 'required|in:Ditampilkan,Diarsipkan',
            'deskripsi'                => 'nullable|string',
            'gambar'                   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = $produk->gambar;
        if ($request->hasFile('gambar')) {
            if ($gambarPath) {
                Storage::disk('public')->delete($gambarPath);
            }
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update([
            'nama_produk'               => $request->nama_produk,
            'id_kategori'               => $request->id_kategori,
            'id_satuan'                 => $request->id_satuan,
            'id_supplier'               => $request->id_supplier,
            'jumlah_satuan'             => $request->jumlah_satuan,
            'estimasi_kadaluwarsa_hari' => $request->estimasi_kadaluwarsa_hari ?? 0,
            'deskripsi'                 => $request->deskripsi,
            'status_tampil'             => $request->status_tampil,
            'gambar'                    => $gambarPath,
        ]);

        // LANGSUNG KE DATA PRODUK + TOAST MUNCUL DI SANA
        return redirect()->route('produk.data')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
{
    try {
        $produk = Produk::withCount('batch')->findOrFail($id);

        if ($produk->batch_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus produk karena masih memiliki batch.'
            ], 422);
        }

        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus.'
        ], 200); // penting: status code eksplisit
    } catch (\Exception $e) {
        \Log::error('Delete produk error: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan server.'
        ], 500);
    }
}
}
