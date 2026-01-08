<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Satuan;
use App\Models\Supplier;
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

                $q->orWhereHas('kategori', fn ($sub) => $sub->where('nama_kategori', 'like', "%$search%"));
                $q->orWhereHas('supplier', fn ($sub) => $sub->where('nama_supplier', 'like', "%$search%"));
                $q->orWhereHas('satuan', fn ($sub) => $sub->where('nama_satuan', 'like', "%$search%"));

                $q->orWhere(function ($sub) use ($searchLower) {
                    if (stripos($searchLower, 'terse') !== false || $searchLower === 'tersedia') {
                        $sub->whereHas('batch', fn ($b) => $b->havingRaw('SUM(stok) > 10'));
                    } elseif (stripos($searchLower, 'menip') !== false || $searchLower === 'menipis') {
                        $sub->whereHas('batch', fn ($b) => $b->havingRaw('SUM(stok) > 0 AND SUM(stok) <= 10'));
                    } elseif (stripos($searchLower, 'hab') !== false || $searchLower === 'habis') {
                        $sub->whereDoesntHave('batch')
                            ->orWhereHas('batch', fn ($b) => $b->havingRaw('SUM(stok) = 0'));
                    }
                });
            });
        }

        $produkBaru = $query->take(5)->get();

        $totalProduk = Produk::count();
        $totalTampil = Produk::where('status_tampil', 'Ditampilkan')->count();
        $totalArsip = Produk::where('status_tampil', 'Diarsipkan')->count();

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
                    $q->whereHas('batch', fn ($b) => $b->havingRaw('SUM(stok) > 10'));
                } elseif ($statusStok === 'Menipis') {
                    $q->whereHas('batch', fn ($b) => $b->havingRaw('SUM(stok) > 0 AND SUM(stok) <= 10'));
                } elseif ($statusStok === 'Habis') {
                    $q->whereDoesntHave('batch')
                        ->orWhereHas('batch', fn ($b) => $b->havingRaw('SUM(stok) = 0'));
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
                $q->where('kode_produk', 'like', "%$search%")
                    ->orWhere('id', 'like', "%$search%")
                    ->orWhere('nama_produk', 'like', "%$search%")
                    ->orWhere('deskripsi', 'like', "%$search%")
                    ->orWhere('status_tampil', 'like', "%$search%")
                    ->orWhere('jumlah_satuan', 'like', "%$search%");

                $q->orWhereHas('kategori', fn ($sub) => $sub->where('nama_kategori', 'like', "%$search%"));
                $q->orWhereHas('supplier', fn ($sub) => $sub->where('nama_supplier', 'like', "%$search%"));
                $q->orWhereHas('satuan', fn ($sub) => $sub->where('nama_satuan', 'like', "%$search%"));

                $q->orWhere(function ($sub) use ($searchLower) {
                    if (stripos($searchLower, 'terse') !== false || $searchLower === 'tersedia') {
                        $sub->whereHas('batch', fn ($b) => $b->havingRaw('SUM(stok) > 10'));
                    } elseif (stripos($searchLower, 'menip') !== false || $searchLower === 'menipis') {
                        $sub->whereHas('batch', fn ($b) => $b->havingRaw('SUM(stok) > 0 AND SUM(stok) <= 10'));
                    } elseif (stripos($searchLower, 'hab') !== false || $searchLower === 'habis') {
                        $sub->whereDoesntHave('batch')
                            ->orWhereHas('batch', fn ($b) => $b->havingRaw('SUM(stok) = 0'));
                    }
                });
            });
        }

        $produkPaginated = $query->latest()->paginate(10)->withQueryString();

        return view('Staff_Produk.dataProduk', [
            'produkAll' => $produkAll,
            'produk' => $produkPaginated,
            'kategori' => Kategori::all(),
            'supplier' => Supplier::all(),
            'satuan' => Satuan::all(),
        ]);
    }

    public function tambahProduk()
    {
        return view('Staff_Produk.tambahProduk', [
            'kategori' => Kategori::all(),
            'satuan' => Satuan::all(),
            'supplier' => Supplier::all(),
        ]);
    }

    public function storeProduk(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id',
            'id_satuan' => 'required|exists:satuans,id',
            'id_supplier' => 'required|exists:suppliers,id',
            'jumlah_satuan' => 'required|numeric|min:1',
            'estimasi_kadaluwarsa_hari' => 'required|integer|min:1',
            'status_tampil' => 'required|in:Ditampilkan,Diarsipkan',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/produk'), $filename);
            $gambarPath = 'images/produk/' . $filename;
        }

        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,
            'id_satuan' => $request->id_satuan,
            'id_supplier' => $request->id_supplier,
            'jumlah_satuan' => $request->jumlah_satuan,
            'estimasi_kadaluwarsa_hari' => $request->estimasi_kadaluwarsa_hari ?? 0,
            'deskripsi' => $request->deskripsi,
            'status_tampil' => $request->status_tampil,
            'gambar' => $gambarPath,
        ]);

        $kode = 'PRD-'.str_pad($produk->id, 3, '0', STR_PAD_LEFT);
        $produk->update(['kode_produk' => $kode]);

        return redirect()->route('produk.data')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);

        return view('Staff_Produk.editProduk', [
            'produk' => $produk,
            'kategori' => Kategori::all(),
            'supplier' => Supplier::all(),
            'satuan' => Satuan::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id',
            'id_satuan' => 'required|exists:satuans,id',
            'id_supplier' => 'required|exists:suppliers,id',
            'jumlah_satuan' => 'required|numeric|min:1',
            'estimasi_kadaluwarsa_hari' => 'nullable|integer|min:1',
            'status_tampil' => 'required|in:Ditampilkan,Diarsipkan',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $gambarPath = $produk->gambar;
        if ($request->hasFile('gambar')) {
            if ($gambarPath && file_exists(public_path($gambarPath))) {
                unlink(public_path($gambarPath));
            }
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/produk'), $filename);
            $gambarPath = 'images/produk/' . $filename;
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,
            'id_satuan' => $request->id_satuan,
            'id_supplier' => $request->id_supplier,
            'jumlah_satuan' => $request->jumlah_satuan,
            'estimasi_kadaluwarsa_hari' => $request->estimasi_kadaluwarsa_hari ?? 0,
            'deskripsi' => $request->deskripsi,
            'status_tampil' => $request->status_tampil,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('produk.data')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        try {
            $produk = Produk::withCount('batch')->findOrFail($id);

            if ($produk->batch_count > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus produk karena masih memiliki batch.',
                ], 422);
            }

            if ($produk->gambar && file_exists(public_path($produk->gambar))) {
                unlink(public_path($produk->gambar));
            }

            $produk->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Delete produk error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server.',
            ], 500);
        }
    }

    public function checkProductName(Request $request)
    {
        $name = $request->query('name');
        $excludeId = $request->query('exclude_id');

        $query = Produk::where('nama_produk', $name);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }
}

