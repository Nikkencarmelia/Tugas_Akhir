<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kurir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfilController extends Controller
{
    public function userIndex(Request $request)
    {
        $user = Auth::user();
        $activeTab = $request->get('tab', 'info');

        if (! $user || $user->role !== 'user') {
            Log::error('Akses user profil ditolak: '.($user ? $user->email.' (role: '.$user->role.')' : 'No user'));

            return redirect('/login')->with('error', 'Akses ditolak. Login sebagai user dulu.');
        }

        Log::info('User Profil loaded: '.$user->email);

        return view('user.profil', [
            'user' => $user,
            'activeTab' => $activeTab,
            'alamats' => $user->alamats()
                ->with(['kecamatan', 'kelurahan', 'kodePos'])
                ->get(),
            'kecamatans' => Kecamatan::all(),
        ]);
    }

    public function userUpdate(Request $request)
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'user') {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'no_telepon' => 'nullable|string|max:20',
        ];

        $request->validate($rules);

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()
            ->route('user.profil', ['tab' => 'info'])
            ->with('success', 'Informasi profil berhasil diperbarui');
    }

    public function userUpdatePassword(Request $request)
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'user') {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        if (! Hash::check($request->password_lama, $user->password)) {
            return back()
                ->withErrors(['password_lama' => 'Password lama tidak sesuai'])
                ->with('tab', 'password');
        }

        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()
            ->route('user.profil', ['tab' => 'password'])
            ->with('success', 'Password berhasil diperbarui');
    }

    public function kurirIndex(Request $request)
    {
        $user = Auth::user();
        $activeTab = $request->get('tab', 'info');

        if (! $user || $user->role !== 'kurir') {
            Log::error('Akses kurir profil ditolak: '.($user ? $user->email.' (role: '.$user->role.')' : 'No user'));

            return redirect('/login')->with('error', 'Akses ditolak. Login sebagai kurir dulu.');
        }

        Log::info('Kurir Profil loaded: '.$user->email);

        $kurir = Kurir::where('id_user', $user->id)->first();
        if (! $kurir) {
            $kurir = Kurir::create([
                'id_user' => $user->id,
                'jenis_kendaraan' => null,
            ]);
            $kurir->syncStatus();
            Log::info('Kurir auto-created for user '.$user->id);
        }

        return view('Kurir.profil', compact('user', 'kurir', 'activeTab'));
    }

    public function kurirUpdate(Request $request)
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'kurir') {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'no_telepon' => 'nullable|string|max:20',
            'jenis_kendaraan' => 'required|in:motor,mobil',
        ];

        $request->validate($rules);

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        $kurir = Kurir::updateOrCreate(
            ['id_user' => $user->id],
            [
                'jenis_kendaraan' => $request->jenis_kendaraan,
            ]
        );
        $kurir->syncStatus();

        return redirect()
            ->route('kurir.profil', ['tab' => 'info'])
            ->with('success', 'Informasi profil berhasil diperbarui');
    }

    public function kurirUpdatePassword(Request $request)
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'kurir') {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        if (! Hash::check($request->password_lama, $user->password)) {
            return back()
                ->withErrors(['password_lama' => 'Password lama tidak sesuai'])
                ->with('tab', 'password');
        }

        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()
            ->route('kurir.profil', ['tab' => 'password'])
            ->with('success', 'Password berhasil diperbarui');
    }
}
