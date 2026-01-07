<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManajemenPenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::select(
            'id',
            'nama_lengkap',
            'email',
            'no_telepon',
            'role',
            'status_online'
        )->orderBy('nama_lengkap')->get()->toArray();

        return view('super_admin.manajemenPengguna', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,kurir,staff_produk,staff_purchasing,super_admin',
            'status_online' => 'nullable|in:aktif,tidak_aktif',
        ]);

        $user = User::findOrFail($id);

        $updateData = [
            'role' => $request->role,
        ];

        if ($request->filled('status_online')) {
            $updateData['status_online'] = $request->status_online;
        }

        $user->update($updateData);

        if ($user->role === 'kurir') {
            $kurir = \App\Models\Kurir::firstOrCreate(
                ['id_user' => $user->id],
                ['jenis_kendaraan' => 'motor']
            );
            $kurir->syncStatus();
        }

        return response()->json([
            'success' => true,
            'message' => 'Role user berhasil diperbarui',
        ]);
    }
}
