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
use Illuminate\Support\Facades\Session;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Batch;

class AuthController extends Controller
{
    /**
     * Sync cart dari session ke database (untuk user yang login)
     */
    private function syncCartToDatabase()
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();
        $cart = Session::get('cart', []);

        // Ambil semua cart keys yang ada di session
        $sessionCartKeys = [];
        foreach ($cart as $key => $item) {
            $sessionCartKeys[] = [
                'id_produk' => $item['product_id'],
                'id_batch' => $item['batch_id'] ?? null,
            ];
        }

        // Hapus item yang tidak ada lagi di session
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
            if (!$found) {
                $keranjang->delete();
            }
        }

        // Update atau create item dari session ke database
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

    /**
     * Load cart dari database ke session (untuk user yang login)
     * Merge dengan session cart yang ada jika ada
     */
    private function loadCartFromDatabase()
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();
        $keranjangs = Keranjang::with(['produk.satuan', 'batch'])
            ->where('id_user', $user->id)
            ->get();

        // Ambil cart dari database
        $cartFromDb = [];
        foreach ($keranjangs as $keranjang) {
            $produk = $keranjang->produk;
            if (!$produk || $produk->status_tampil !== 'Ditampilkan') {
                continue; // Skip produk yang tidak ditampilkan
            }

            // Cek stok masih tersedia
            $batchQuery = Batch::where('id_produk', $produk->id)->where('stok', '>', 0);
            if ($keranjang->id_batch) {
                $batchQuery->where('id', $keranjang->id_batch);
            }
            $totalStok = $batchQuery->sum('stok');

            if ($totalStok <= 0) {
                continue; // Skip jika stok habis
            }

            // Ambil batch untuk harga
            $batchQueryForPrice = Batch::where('id_produk', $produk->id)->where('stok', '>', 0);
            if ($keranjang->id_batch) {
                $batchQueryForPrice->where('id', $keranjang->id_batch);
            } else {
                $batchQueryForPrice->orderBy('tgl_masuk', 'asc');
            }
            $batchTertua = $batchQueryForPrice->first();

            if (!$batchTertua) {
                continue;
            }

            $cartKey = $produk->id;
            if ($keranjang->id_batch) {
                $cartKey = $produk->id . '_' . $keranjang->id_batch;
            }

            $cartFromDb[$cartKey] = [
                'product_id' => $produk->id,
                'batch_id' => $keranjang->id_batch,
                'nama_produk' => $produk->nama_produk,
                'harga' => $batchTertua->harga_saat_ini,
                'gambar' => $produk->gambar ? asset('storage/' . $produk->gambar) : asset('images/default-product.jpg'),
                'satuan_berat' => ($produk->jumlah_satuan ?? 1) . ' ' . ($produk->satuan?->nama_satuan ?? 'pcs'),
                'quantity' => min($keranjang->quantity, $totalStok) // Pastikan tidak melebihi stok
            ];
        }

        // Merge dengan session cart yang ada (session cart diutamakan jika ada konflik)
        $sessionCart = Session::get('cart', []);
        $mergedCart = $cartFromDb;

        foreach ($sessionCart as $key => $item) {
            if (isset($mergedCart[$key])) {
                // Jika item sudah ada di database, gunakan yang dari database (lebih up-to-date)
                // Tapi bisa juga merge quantity jika diperlukan
                continue;
            } else {
                // Item baru di session yang belum ada di database, tambahkan
                $mergedCart[$key] = $item;
            }
        }

        Session::put('cart', $mergedCart);
        
        // Sync kembali ke database untuk memastikan session cart yang baru juga tersimpan
        $this->syncCartToDatabase();
    }

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
        $user->update(['status_online' => 'aktif']);

        // Load cart dari database untuk user yang login
        if ($user->role === 'user') {
            $this->loadCartFromDatabase();
        }

        // IF KURIR: Sync status_antar
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
            $user = Auth::user();
            
            // Simpan cart ke database sebelum logout (untuk user)
            if ($user->role === 'user') {
                $this->syncCartToDatabase();
            }
            
            $user->update([
                'status_online' => 'tidak_aktif'
            ]);

            // IF KURIR: Sync status_antar
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
