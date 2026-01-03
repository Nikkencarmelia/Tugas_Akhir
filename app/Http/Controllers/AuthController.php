<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah'
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        $user->update([
            'status_online' => 'aktif'
        ]);

        switch ($user->role) {
            case 'super_admin':
                return redirect()->route('super_admin.dashboard');
            case 'staff_produk':
                return redirect()->route('produk.dashboard');
            case 'staff_purchasing':
                return redirect()->route('staff_purchasing.dashboard');
            case 'kurir':
                return redirect()->route('kurir.pengiriman');
            default:
                return redirect()->route('beranda');
        }
    }

    public function showRegister()
    {
        return view('register');
    }

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

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->update([
                'status_online' => 'tidak_aktif'
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showForgotPassword()
    {
        return view('lupaPassword');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        $token = Str::random(60);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        Mail::to($user->email)->send(new ResetPasswordMail($user, $token));

        return back()->with('success', 'Link reset Kata Sandi dikirim ke email Anda! Cek inbox/spam.');
    }

    public function showResetPassword(Request $request, $token = null)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect()->route('login')->with('error', 'Email tidak ditemukan.');
        }

        $tokenRecord = DB::table('password_reset_tokens')->where('email', $email)->where('token', $token)->first();

        if (!$tokenRecord || now()->diffInMinutes($tokenRecord->created_at) > 60) {
            // Hapus token invalid
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('login')->with('error', 'Token tidak valid atau kadaluarsa.');
        }

        return view('lupaPasswordKonfirmasi', [
            'token' => $token,
            'email' => $email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $tokenRecord = DB::table('password_reset_tokens')->where('email', $request->email)->where('token', $request->token)->first();

        if (!$tokenRecord || now()->diffInMinutes($tokenRecord->created_at) > 60) {
            return back()->withErrors(['email' => 'Token tidak valid atau kadaluarsa.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan.']);
        }

        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Reset kata sandi berhasil! Silakan login.');
    }
}
