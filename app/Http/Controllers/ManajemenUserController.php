<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ManajemenUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ================= LIST USER =================
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

        return view('super_admin.manajemenUser', compact('users'));
    }

    // ================= UPDATE ROLE & STATUS =================
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,kurir,staff_produk,staff_purchasing,super_admin',
            'status_online' => 'nullable|in:aktif,tidak_aktif', // Nullable karena opsional dari modal
        ]);

        $user = User::findOrFail($id);

        $updateData = [
            'role' => $request->role,
        ];

        // Update status_online kalau ada input (tetep nullable)
        if ($request->filled('status_online')) {
            $updateData['status_online'] = $request->status_online;
        }

        $user->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Role user berhasil diperbarui'
        ]);
    }
}
