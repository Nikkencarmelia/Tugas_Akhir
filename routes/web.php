<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\UserProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KomponenProdukController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\ProdukDiskonController;
use App\Http\Controllers\PengelolaanStokController;
use App\Http\Controllers\ProdukArsipController;
use App\Http\Controllers\ProdukRusakCacatController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\OngkirDaerahController;
use App\Http\Controllers\ManajemenPenggunaController;
use App\Http\Controllers\ManajemenKurirController;
use App\Http\Controllers\LaporanController;

/* ================= PUBLIC ROUTES (TIDAK PERLU LOGIN) ================= */

// Beranda / Landing Page
Route::get('/', [UserProdukController::class, 'beranda'])->name('beranda');

// Produk (Public - bisa dilihat tanpa login)
Route::get('/produk', [UserProdukController::class, 'produk'])->name('produk');
Route::get('/produk/{id}', [UserProdukController::class, 'detailProduk'])->name('produk.detail');

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
});

// Socialite Authentication
Route::controller(SocialiteController::class)->group(function () {
    Route::get('auth/google', 'googleLogin')->name('auth.google');
    Route::get('auth/google-callback', 'googleAuthentication')->name('auth.google-callback');
});

// Forgot Password (Public)
Route::get('/lupa-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/lupa-password', [AuthController::class, 'forgotPassword'])->name('password.email');

// Reset Password (Public)
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

/* ================= AUTHENTICATED ROUTES (PERLU LOGIN) ================= */

// User Routes
Route::prefix('user')->middleware('auth')->name('user.')->group(function () {
    Route::get('/beranda', [PengurusController::class, 'tampilBeranda'])->name('beranda');

    // Profil User
    Route::get('/profil', [ProfilController::class, 'userIndex'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'userUpdate'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'userUpdatePassword'])->name('profil.password');

    // Alamat & AJAX
    Route::post('/alamat', [AlamatController::class, 'store'])->name('alamat.store');
    Route::put('/alamat/{id}', [AlamatController::class, 'update'])->name('alamat.update');
    Route::delete('/alamat/{id}', [AlamatController::class, 'destroy'])->name('alamat.destroy');
    
    // Alamat AJAX - Dynamic Dropdowns
    Route::get('/kelurahan/{id}', [AlamatController::class, 'kelurahanByKecamatan'])->name('ajax.kelurahan');
    Route::get('/kodepos/{id}', [AlamatController::class, 'kodePosByKelurahan'])->name('ajax.kodepos');
});

// Keranjang (Cart)
Route::prefix('keranjang')->middleware('auth')->name('keranjang.')->group(function () {
    // Pindahkan index, add, buy-now, dll ke sini
    Route::get('/', [KeranjangController::class, 'index'])->name('index');
    Route::post('/add', [KeranjangController::class, 'addToCart'])->name('add');
    Route::post('/buy-now', [KeranjangController::class, 'buyNow'])->name('buy-now');
    Route::post('/update', [KeranjangController::class, 'update'])->name('update');
    Route::post('/delete-multiple', [KeranjangController::class, 'deleteMultiple'])->name('delete-multiple');
    Route::delete('/delete/{id}', [KeranjangController::class, 'delete'])->name('delete');
    Route::delete('/clear', [KeranjangController::class, 'clear'])->name('clear');
    Route::get('/ongkir/minimal/{id_kecamatan}', [OngkirDaerahController::class, 'getMinimalOngkir'])->name('ongkir.minimal');
});


// Pemesanan (Orders)
Route::middleware('auth')->prefix('pemesanan')->name('pemesanan.')->group(function () {
    Route::get('/', [PemesananController::class, 'index'])->name('index');
    Route::get('/riwayat', [PemesananController::class, 'index'])->name('riwayat.pesanan');
    Route::get('/checkout', [PemesananController::class, 'checkout'])->name('checkout');
    Route::post('/', [PemesananController::class, 'store'])->name('store');
    Route::get('/{pemesanan}', [PemesananController::class, 'show'])->name('show');
    Route::patch('/{pemesanan}', [PemesananController::class, 'updateStatus'])->name('update');
    Route::get('/{pemesanan}/pembayaran', [PemesananController::class, 'pembayaran'])->name('pembayaran');
    Route::post('/{pemesanan}/pembayaran', [PemesananController::class, 'prosesPembayaran'])->name('proses_pembayaran');
    Route::delete('/{pemesanan}', [PemesananController::class, 'destroy'])->name('destroy');
});

// Kurir Routes
Route::prefix('kurir')->middleware('auth')->name('kurir.')->group(function () {
    // Profil Kurir
    Route::get('/profil', [ProfilController::class, 'kurirIndex'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'kurirUpdate'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'kurirUpdatePassword'])->name('profil.password');

    // Pengiriman Masuk
    Route::get('/pengiriman_masuk', [PemesananController::class, 'pengirimanMasukKurir'])->name('pengiriman');
    Route::post('/terima_pengiriman/{pemesanan}', [PemesananController::class, 'kurirTerima'])->name('terima');
    Route::post('/tolak_pengiriman/{pemesanan}', [PemesananController::class, 'kurirTolak'])->name('tolak');
    Route::post('/terima_dipilih', [PemesananController::class, 'kurirTerimaDipilih'])->name('terima_dipilih');
    Route::post('/tolak_dipilih', [PemesananController::class, 'kurirTolakDipilih'])->name('tolak_dipilih');
    Route::post('/terima_semua', [PemesananController::class, 'kurirTerimaSemua'])->name('terima_semua');
    Route::post('/tolak_semua', [PemesananController::class, 'kurirTolakSemua'])->name('tolak_semua');

    // Status Pengiriman
    Route::get('/status_pengiriman', [PemesananController::class, 'statusPengirimanKurir'])->name('status_pengiriman');
    Route::post('/kirim_sekarang/{pemesanan}', [PemesananController::class, 'kurirKirimSekarang'])->name('kirim');
    Route::post('/selesai_pengiriman/{pemesanan}', [PemesananController::class, 'kurirSelesai'])->name('selesai');

    // Riwayat Pengiriman
    Route::get('/riwayat_pengiriman', [PemesananController::class, 'riwayatPengirimanKurir'])->name('riwayat');
    Route::get('/detail_pengiriman/{pemesanan}', [PemesananController::class, 'detailPengirimanKurir'])->name('detail_pesanan');
});

/* ================= STAFF ROUTES ================= */

// Staff Produk
Route::prefix('staff_produk')->middleware('auth')->name('produk.')->group(function () {
    Route::get('/dashboard', [ProdukController::class, 'dashboardProduk'])->name('dashboard');
    Route::get('/data', [ProdukController::class, 'dataProduk'])->name('data');

    // Produk CRUD
    Route::get('/tambah', [ProdukController::class, 'tambahProduk'])->name('tambah');
    Route::post('/store', [ProdukController::class, 'storeProduk'])->name('store');
    Route::get('/edit_produk/{id}', [ProdukController::class, 'edit'])->name('edit');
    Route::put('/update_produk/{id}', [ProdukController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ProdukController::class, 'destroy'])->name('destroy');
    Route::get('/check-name', [ProdukController::class, 'checkProductName'])->name('check-name');

    // Batch
    Route::get('/produk/{id_produk}/batch', [BatchController::class, 'index'])->name('batch.index');
    Route::post('/batch/store', [BatchController::class, 'store'])->name('batch.store');
    Route::put('/batch/update/{id}', [BatchController::class, 'update'])->name('batch.update');
    Route::delete('/batch/delete/{id}', [BatchController::class, 'destroy'])->name('batch.delete');
    Route::put('/batch/diskon/{id}', [BatchController::class, 'applyDiscount'])->name('batch.diskon');
    Route::put('/batch/naik/{id}', [BatchController::class, 'increasePrice'])->name('batch.naik');

    // Diskon
    Route::get('/diskon', [ProdukDiskonController::class, 'produkDiskon'])->name('diskon');
    Route::get('/detail_diskon/{id_produk}', [ProdukDiskonController::class, 'detailDiskon'])->name('detailDiskon');

    // Komponen Produk
    Route::prefix('komponen')->name('komponen.')->group(function () {
        Route::get('/', [KomponenProdukController::class, 'index'])->name('index');
        
        // Kategori
        Route::post('/kategori', [KomponenProdukController::class, 'storeKategori'])->name('kategori.store');
        Route::put('/kategori/{id}', [KomponenProdukController::class, 'updateKategori'])->name('kategori.update');
        Route::delete('/kategori/{id}', [KomponenProdukController::class, 'destroyKategori'])->name('kategori.destroy');
        Route::post('/kategori/move', [KomponenProdukController::class, 'moveKategori'])->name('kategori.move');

        // Satuan
        Route::post('/satuan', [KomponenProdukController::class, 'storeSatuan'])->name('satuan.store');
        Route::put('/satuan/{id}', [KomponenProdukController::class, 'updateSatuan'])->name('satuan.update');
        Route::delete('/satuan/{id}', [KomponenProdukController::class, 'destroySatuan'])->name('satuan.destroy');
        Route::post('/satuan/move', [KomponenProdukController::class, 'moveSatuan'])->name('satuan.move');

        // Supplier
        Route::post('/supplier', [KomponenProdukController::class, 'storeSupplier'])->name('supplier.store');
        Route::put('/supplier/{id}', [KomponenProdukController::class, 'updateSupplier'])->name('supplier.update');
        Route::delete('/supplier/{id}', [KomponenProdukController::class, 'destroySupplier'])->name('supplier.destroy');
        Route::post('/supplier/move', [KomponenProdukController::class, 'moveSupplier'])->name('supplier.move');
    });

    // Kelola Stok
    Route::get('/kelola_stok', [PengelolaanStokController::class, 'index'])->name('kelola_stok');

    // Arsip Produk
    Route::get('/arsip', [ProdukArsipController::class, 'arsipProduk'])->name('arsip');

    // Produk Rusak Cacat
    Route::get('/rusak_cacat', [ProdukRusakCacatController::class, 'index'])->name('rusak_cacat.index');
    Route::get('/rusak_cacat/{id_produk}', [ProdukRusakCacatController::class, 'show'])->name('rusak_cacat.show');
    Route::post('/rusak_cacat/store', [ProdukRusakCacatController::class, 'store'])->name('rusak_cacat.store');
});

// Restore Arsip Produk
Route::prefix('arsip-produk')->middleware('auth')->group(function () {
    Route::post('/restore/{id}', [ProdukArsipController::class, 'restoreProduk']);
    Route::post('/restore-selected', [ProdukArsipController::class, 'restoreSelectedProduk']);
    Route::post('/restore-all', [ProdukArsipController::class, 'restoreAllProduk']);
});

// Staff Purchasing
Route::prefix('purchasing')->middleware('auth')->name('staff_purchasing.')->group(function () {
    Route::get('/dashboard', [PemesananController::class, 'dashboardPurchasing'])->name('dashboard');

    // Pesanan Masuk
    Route::get('/pesanan_masuk', [PemesananController::class, 'pesananMasuk'])->name('pesanan_masuk');
    Route::get('/detail_pesanan/{pemesanan}', [PemesananController::class, 'showPurchasing'])->name('detail_pesanan');

    // Terima/Tolak Pesanan
    Route::post('/terima_pesanan/{pemesanan}', [PemesananController::class, 'terimaPesanan'])->name('terima_pesanan');
    Route::post('/terima_semua_pesanan', [PemesananController::class, 'terimaSemuaPesanan'])->name('terima_semua_pesanan');
    Route::post('/terima_dipilih', [PemesananController::class, 'terimaDipilih'])->name('terima_dipilih');
    Route::post('/tolak_dipilih_staff', [PemesananController::class, 'tolakDipilihStaff'])->name('tolak_dipilih_staff');
    Route::post('/tolak_pesanan/{pemesanan}', [PemesananController::class, 'tolakPesanan'])->name('tolak_pesanan');

    // Cari & Assign Kurir
    Route::get('/cari_kurir', [PemesananController::class, 'cariKurir'])->name('cari_kurir');
    Route::post('/assign_kurir', [PemesananController::class, 'assignKurir'])->name('assign_kurir');

    // Pesanan Berjalan
    Route::get('/pesanan_berjalan', [PemesananController::class, 'pesananBerjalan'])->name('pesanan_berjalan');
    Route::post('/pesanan_berjalan/{pemesanan}/to_siap_diambil', [PemesananController::class, 'toSiapDiambil'])->name('to_siap_diambil');
    Route::post('/pesanan_berjalan/{pemesanan}/to_dikirim', [PemesananController::class, 'toDikirim'])->name('to_dikirim');

    // Riwayat
    Route::get('/riwayat_pesanan', [PemesananController::class, 'riwayatPurchasing'])->name('riwayat');

    // Konfirmasi Pembayaran
    Route::get('/konfirmasi_pembayaran', [PemesananController::class, 'konfirmasiPembayaranPage'])->name('konfirmasi_pembayaran');
    Route::post('/konfirmasi_pembayaran/{pemesanan}/terima', [PemesananController::class, 'terimaPembayaran'])->name('terima_pembayaran');
    Route::post('/konfirmasi_pembayaran/{pemesanan}/tolak', [PemesananController::class, 'tolakPembayaran'])->name('tolak_pembayaran');

    // Ongkir & Daerah
    Route::get('/kelola_ongkir', [OngkirDaerahController::class, 'index'])->name('ongkir.index');
    
    // Kecamatan
    Route::get('/kecamatan', [OngkirDaerahController::class, 'kecamatanIndex'])->name('kecamatan.index');
    Route::post('/kecamatan', [OngkirDaerahController::class, 'kecamatanStore'])->name('kecamatan.store');
    Route::put('/kecamatan/{id}', [OngkirDaerahController::class, 'kecamatanUpdate'])->name('kecamatan.update');
    Route::delete('/kecamatan/{id}', [OngkirDaerahController::class, 'kecamatanDestroy'])->name('kecamatan.destroy');
    
    // Kelurahan
    Route::get('/kelurahan', [OngkirDaerahController::class, 'kelurahanIndex'])->name('kelurahan.index');
    Route::post('/kelurahan', [OngkirDaerahController::class, 'kelurahanStore'])->name('kelurahan.store');
    Route::put('/kelurahan/{id}', [OngkirDaerahController::class, 'kelurahanUpdate'])->name('kelurahan.update');
    Route::delete('/kelurahan/{id}', [OngkirDaerahController::class, 'kelurahanDestroy'])->name('kelurahan.destroy');
    
    // Kode Pos
    Route::get('/kode-pos', [OngkirDaerahController::class, 'kodeposIndex'])->name('kodepos.index');
    Route::post('/kode-pos', [OngkirDaerahController::class, 'kodeposStore'])->name('kodepos.store');
    Route::put('/kode-pos/{id}', [OngkirDaerahController::class, 'kodeposUpdate'])->name('kodepos.update');
    Route::delete('/kode-pos/{id}', [OngkirDaerahController::class, 'kodeposDestroy'])->name('kodepos.destroy');
    
    // Ajax
    Route::get('/kelurahan-by-kecamatan/{id}', [OngkirDaerahController::class, 'getKelurahanByKecamatan'])->name('kelurahan.byKecamatan');
});

/* ================= SUPER ADMIN ROUTES ================= */

Route::prefix('super_admin')->middleware('auth')->name('super_admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [LaporanController::class, 'dashboardSuperAdmin'])->name('dashboard');

    // Manajemen Pengguna
    Route::get('/manajemen_pengguna', [ManajemenPenggunaController::class, 'index'])->name('pengguna.index');
    Route::put('/manajemen_pengguna/{id}', [ManajemenPenggunaController::class, 'updateRole'])->name('pengguna.update');

    // Manajemen Kurir
    Route::get('/manajemen_kurir', [ManajemenKurirController::class, 'index'])->name('manajemen_kurir.index');
    Route::put('/manajemen_kurir/{id}', [ManajemenKurirController::class, 'updateRole'])->name('manajemen_kurir.updateRole');
    Route::delete('/manajemen_kurir/{id}', [ManajemenKurirController::class, 'destroy'])->name('manajemen_kurir.destroy');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'laporan'])->name('laporan');

    // Manajemen Pengurus
    Route::get('/manajemen_pengurus', [PengurusController::class, 'index'])->name('pengurus.index');
    Route::post('/manajemen_pengurus', [PengurusController::class, 'store'])->name('pengurus.store');
    Route::put('/manajemen_pengurus/{id}', [PengurusController::class, 'update'])->name('pengurus.update');
    Route::delete('/manajemen_pengurus/{id}', [PengurusController::class, 'destroy'])->name('pengurus.destroy');
});
