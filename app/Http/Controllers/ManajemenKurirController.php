<?php

namespace App\Http\Controllers;

use App\Models\Kurir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManajemenKurirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $kurir = User::where('role', 'kurir')
            ->leftJoin('kurirs', 'users.id', '=', 'kurirs.id_user')
            ->select(
                'users.id',
                'users.nama_lengkap',
                'users.email',
                'users.no_telepon',
                'users.role',
                'users.status_online',
                'kurirs.jenis_kendaraan as kendaraan',
                'kurirs.status_antar'
            )
            ->orderBy('users.nama_lengkap')
            ->get();

        return view('Super_Admin.manajemenKurir', compact('kurir'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,kurir,staff_produk,staff_purchasing,super_admin',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $user = User::findOrFail($id);
                $oldRole = $user->role;
                $newRole = $request->role;

                $user->update(['role' => $newRole]);

                if ($oldRole === 'kurir' && $newRole !== 'kurir') {
                    Kurir::where('id_user', $id)->delete();
                }

                if ($newRole === 'kurir' && $oldRole !== 'kurir') {
                    $kurir = Kurir::firstOrCreate(
                        ['id_user' => $id],
                        ['jenis_kendaraan' => 'motor']
                    );
                    $kurir->syncStatus();
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Role berhasil diperbarui.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui role: '.$e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {

                \App\Models\Pemesanan::where('id_kurir', $id)->update(['id_kurir' => null]);

                Kurir::where('id_user', $id)->delete();

                User::destroy($id);
            });

            return response()->json([
                'success' => true,
                'message' => 'Data kurir berhasil dihapus.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kurir: '.$e->getMessage(),
            ], 500);
        }
    }
}
