<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kurir;
use Illuminate\Support\Facades\DB;

class ManajemenKurirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get all users with role 'kurir' and their details
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

                // Update Role
                $user->update(['role' => $newRole]);

                // Logic: If changing FROM kurir TO something else, delete kurir data
                if ($oldRole === 'kurir' && $newRole !== 'kurir') {
                    Kurir::where('id_user', $id)->delete();
                }

                // Logic: If changing TO kurir (optional, if we want to create default record)
                // For now, we assume kurir data is managed separately or seeded. 
                // If the user becomes a kurir, they might need to update their profile to add vehicle info.
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
                'message' => 'Role berhasil diperbarui.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui role: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                // 1. Set id_kurir to null for any orders assigned to this courier
                // This prevents foreign key constraint violation and keeps order history
                \App\Models\Pemesanan::where('id_kurir', $id)->update(['id_kurir' => null]);

                // 2. Delete from Kurirs table
                Kurir::where('id_user', $id)->delete();

                // 3. Delete User
                User::destroy($id);
            });

            return response()->json([
                'success' => true,
                'message' => 'Data kurir berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kurir: ' . $e->getMessage()
            ], 500);
        }
    }
}
