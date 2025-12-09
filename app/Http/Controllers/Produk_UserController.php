<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class Produk_UserController extends Controller
{
    public function landingPage()
    {
        $produk = Produk::where('status_tampil', 'tampil')->get();
        return view('User.landingPage', compact('produk'));
    }

    public function listProduk()
    {
        $produk = Produk::where('status_tampil', 'tampil')->paginate(12);
        return view('User.produk', compact('produk'));
    }

    public function detailProduk($id)
    {
        $produk = Produk::findOrFail($id);
        return view('User.detailProduk', compact('produk'));
    }

    public function keranjang()
    {
        return view('User.keranjang');
    }
}
