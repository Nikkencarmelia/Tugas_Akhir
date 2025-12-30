<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ================= SHOW LOGIN =================
    public function showLogin()
    {
        return view('login');
    }

    // ================= LOGIN =================
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Akun tidak ditemukan']);
        }

        // ================= USER =================
        if ($user->role === 'user') {
            if (Auth::guard('web_user')->attempt($request->only('email', 'password'))) {

                $request->session()->regenerate();

                $user->update([
                    'status_online' => 'aktif'
                ]);

                return redirect()->route('beranda');
            }
        }

        // ================= KURIR =================
        if ($user->role === 'kurir') {
            if (Auth::guard('web_kurir')->attempt($request->only('email', 'password'))) {

                $request->session()->regenerate();

                $user->update([
                    'status_online' => 'aktif'
                ]);

                return redirect()->route('kurir.pengiriman');
            }
        }

        // ================= STAFF PRODUK =================
        if ($user->role === 'staff_produk') {
            if (Auth::guard('web_staff_produk')->attempt($request->only('email', 'password'))) {

                $request->session()->regenerate();

                $user->update([
                    'status_online' => 'aktif'
                ]);

                return redirect()->route('staff_produk.dashboard');
            }
        }

        // ================= STAFF PURCHASING =================
        if ($user->role === 'staff_purchasing') {
            if (Auth::guard('web_staff_purchasing')->attempt($request->only('email', 'password'))) {

                $request->session()->regenerate();

                $user->update([
                    'status_online' => 'aktif'
                ]);

                return redirect()->route('staff_purchasing.dashboard');
            }
        }

        // ================= SUPER ADMIN =================
        if ($user->role === 'super_admin') {
            if (Auth::guard('web_admin')->attempt($request->only('email', 'password'))) {

                $request->session()->regenerate();

                $user->update([
                    'status_online' => 'aktif'
                ]);

                return redirect()->route('super_admin.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah'
        ]);
    }

    // ================= SHOW REGISTER =================
    public function showRegister()
    {
        return view('register');
    }

    // ================= REGISTER (USER ONLY) =================
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'no_telepon'   => 'nullable|string|max:20',
            'password'     => 'required|min:6|confirmed',
        ]);

        User::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'email'         => $request->email,
            'no_telepon'    => $request->no_telepon,
            'role'          => 'user',
            'status_online' => 'tidak_aktif',
            'password'      => Hash::make($request->password),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Pendaftaran berhasil, silakan login');
    }

    // ================= LOGOUT =================
    public function logout(Request $request)
{
    if (Auth::guard('web_admin')->check()) {
        Auth::guard('web_admin')->user()->update(['status_online' => 'tidak_aktif']);
        Auth::guard('web_admin')->logout();
    } elseif (Auth::guard('web_staff_produk')->check()) {
        Auth::guard('web_staff_produk')->user()->update(['status_online' => 'tidak_aktif']);
        Auth::guard('web_staff_produk')->logout();
    } elseif (Auth::guard('web_staff_purchasing')->check()) {
        Auth::guard('web_staff_purchasing')->user()->update(['status_online' => 'tidak_aktif']);
        Auth::guard('web_staff_purchasing')->logout();
    } elseif (Auth::guard('web_kurir')->check()) {
        Auth::guard('web_kurir')->user()->update(['status_online' => 'tidak_aktif']);
        Auth::guard('web_kurir')->logout();
    } elseif (Auth::guard('web_user')->check()) {
        Auth::guard('web_user')->user()->update(['status_online' => 'tidak_aktif']);
        Auth::guard('web_user')->logout();
    }

    // JANGAN invalidate kalau masih mau role lain hidup
    $request->session()->regenerateToken();

    return redirect()->route('login');
}
}
