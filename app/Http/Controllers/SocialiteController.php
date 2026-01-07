<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Keranjang;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
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
                'gambar' => $produk->gambar ? asset('storage/'.$produk->gambar) : asset('images/default-product.jpg'),
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

    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleAuthentication()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('id_google', $googleUser->id)->first();

            if ($user) {
                Auth::login($user);

                $this->loadCartFromDatabase();

                return redirect()->route('beranda');
            }

            $userData = User::create([
                'nama_lengkap' => $googleUser->name,
                'email' => $googleUser->email,
                'role' => 'user',
                'id_google' => $googleUser->id,
                'password' => Hash::make('Password@1234'),
            ]);

            Auth::login($userData);

            $this->loadCartFromDatabase();

            return redirect()->route('beranda');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
