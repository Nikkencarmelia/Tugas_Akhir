<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\Batch;
use App\Models\Keranjang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private function syncCartToDatabase()
    {
        if (! Auth::check()) {
            return;
        }

        $user = Auth::user();
        $cart = Session::get('cart', []);

        $sessionCartKeys = [];
        foreach ($cart as $key => $item) {
            $sessionCartKeys[] = [
                'id_produk' => $item['product_id'],
                'id_batch' => $item['batch_id'] ?? null,
            ];
        }

        $existingKeranjangs = Keranjang::where('id_user', $user->id)->get();
        foreach ($existingKeranjangs as $keranjang) {
            $found = false;
            foreach ($sessionCartKeys as $key) {
                if ($keranjang->id_produk == $key['id_produk'] &&
                    $keranjang->id_batch == $key['id_batch']) {
                    $found = true;
                    break;
                }
            }
            if (! $found) {
                $keranjang->delete();
            }
        }

        foreach ($cart as $item) {
            Keranjang::updateOrCreate(
                [
                    'id_user' => $user->id,
                    'id_produk' => $item['product_id'],
                    'id_batch' => $item['batch_id'] ?? null,
                ],
                [
                    'quantity' => $item['quantity'],
                ]
            );
        }
    }

    private function loadCartFromDatabase()
    {
        if (! Auth::check()) {
            return;
        }

        $user = Auth::user();
        $keranjangs = Keranjang::with(['produk.satuan', 'batch'])
            ->where('id_user', $user->id)
            ->get();

        $cartFromDb = [];
        foreach ($keranjangs as $keranjang) {
            $produk = $keranjang->produk;
            if (! $produk || $produk->status_tampil !== 'Ditampilkan') {
                continue;
            }

            $batchQuery = Batch::where('id_produk', $produk->id)->where('stok', '>', 0);
            if ($keranjang->id_batch) {
                $batchQuery->where('id', $keranjang->id_batch);
            }
            $totalStok = $batchQuery->sum('stok');

            if ($totalStok <= 0) {
                continue;
            }

            $batchQueryForPrice = Batch::where('id_produk', $produk->id)->where('stok', '>', 0);
            if ($keranjang->id_batch) {
                $batchQueryForPrice->where('id', $keranjang->id_batch);
            } else {
                $batchQueryForPrice->orderBy('tgl_masuk', 'asc');
            }
            $batchTertua = $batchQueryForPrice->first();

            if (! $batchTertua) {
                continue;
            }

            $cartKey = $produk->id;
            if ($keranjang->id_batch) {
                $cartKey = $produk->id.'_'.$keranjang->id_batch;
            }

            $cartFromDb[$cartKey] = [
                'product_id' => $produk->id,
                'batch_id' => $keranjang->id_batch,
                'nama_produk' => $produk->nama_produk,
                'harga' => $batchTertua->harga_saat_ini,
                'gambar' => $produk->gambar ? asset($produk->gambar) : asset('images/default-product.jpg'),
                'satuan_berat' => ($produk->jumlah_satuan ?? 1).' '.($produk->satuan?->nama_satuan ?? 'pcs'),
                'quantity' => min($keranjang->quantity, $totalStok),
            ];
        }

        $sessionCart = Session::get('cart', []);
        $mergedCart = $cartFromDb;

        foreach ($sessionCart as $key => $item) {
            if (isset($mergedCart[$key])) {

                continue;
            } else {

                $mergedCart[$key] = $item;
            }
        }

        Session::put('cart', $mergedCart);

        $this->syncCartToDatabase();
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();
        $user->update(['status_online' => 'aktif']);

        if ($user->role === 'user') {
            $this->loadCartFromDatabase();
        }

        if ($user->role === 'kurir') {
            $kurir = \App\Models\Kurir::firstOrCreate(['id_user' => $user->id]);
            $kurir->syncStatus();
        }

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
            'email' => 'required|email|unique:users,email',
            'no_telepon' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'role' => 'user',
            'status_online' => 'tidak_aktif',
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Pendaftaran berhasil, silakan login');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'user') {
                $this->syncCartToDatabase();
            }

            $user->update([
                'status_online' => 'tidak_aktif',
            ]);

            if ($user->role === 'kurir') {
                $kurir = \App\Models\Kurir::where('id_user', $user->id)->first();
                if ($kurir) {
                    $kurir->syncStatus();
                }
            }
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }

    public function showForgotPassword()
    {
        return view('lupaPassword');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
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

        if (! $email) {
            return redirect()->route('login')->with('error', 'Email tidak ditemukan.');
        }

        $tokenRecord = DB::table('password_reset_tokens')->where('email', $email)->where('token', $token)->first();

        if (! $tokenRecord || now()->diffInMinutes($tokenRecord->created_at) > 60) {

            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return redirect()->route('login')->with('error', 'Token tidak valid atau kadaluarsa.');
        }

        return view('lupaPasswordKonfirmasi', [
            'token' => $token,
            'email' => $email,
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

        if (! $tokenRecord || now()->diffInMinutes($tokenRecord->created_at) > 60) {
            return back()->withErrors(['email' => 'Token tidak valid atau kadaluarsa.']);
        }

        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'User tidak ditemukan.']);
        }

        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Reset kata sandi berhasil! Silakan login.');
    }
}
