<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\UserProdukController;
use App\Http\Controllers\KeranjangController;
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
use App\Http\Controllers\ManajemenUserController;



Route::get('/', [UserProdukController::class, 'beranda'])->name('beranda');


Route::get('/detail_pesanan', function () {
    return view('User/detailPesanan', [
        'detail' => [
            'nama_penerima' => 'Rina Marlina',
            'no_telp' => '0812-3456-7890',
            'alamat_jalan' => 'Jl. Mawar No. 12',
            'kelurahan' => 'Barong Tongkok',
            'kecamatan' => 'Barong',
            'kabupaten' => 'Kutai Barat',
            'kode_pos' => '75776',
            'tanggal' => '2025-10-25',
            'produk_list' => [
                [
                    'gambar' => 'images/beras.jpg',
                    'produk' => 'Beras Kutai Premium',
                    'jumlah' => 2,
                    'supplier' => 'Bulog',
                    'harga' => 50000,
                ],
                [
                    'gambar' => 'images/pokcoy.jpg',
                    'produk' => 'Sayur Pokcoy Segar',
                    'jumlah' => 5,
                    'supplier' => 'Petani',
                    'harga' => 15000,
                ]
            ],
            'ongkir' => 'Rp 15.000',
        ]
    ]);
});



Route::get('/keranjang', function () {
    return view('User/keranjang', [
        'keranjang' => [
            [
                'gambar' => 'images/beras.jpg',
                'nama_produk' => 'Beras Kutai Premium',
                'satuan_berat' => '5 kg',
                'harga' => '75000',
            ],
            [
                'gambar' => 'images/pokcoy.jpg',
                'nama_produk' => 'Sayur Pokcoy Segar',
                'satuan_berat' => '250 gram',
                'harga' => '4800',
            ],
            [
                'gambar' => 'images/telur_kampung.jpg',
                'nama_produk' => 'Telur Ayam Kampung',
                'satuan_berat' => '1 kg',
                'harga' => '30000',
            ],
            [
                'gambar' => 'images/ayam.jpg',
                'nama_produk' => 'Ayam Kampung Segar',
                'satuan_berat' => '1 ekor (~1 kg)',
                'harga' => '45000',
            ],
            [
                'gambar' => 'images/madu.jpg',
                'nama_produk' => 'Madu Hutan Asli',
                'satuan_berat' => '250 ml',
                'harga' => '40000',
            ],
            [
                'gambar' => 'images/singkong.jpg',
                'nama_produk' => 'Singkong Organik',
                'satuan_berat' => '2 kg',
                'harga' => '12000',
            ],

        ]
    ]);
});

Route::get('/checkout', function () {
    return view('User/checkout', [
        'checkout' => [
            [
                'gambar' => 'images/beras.jpg',
                'nama_produk' => 'Beras Kutai Premium',
                'satuan_berat' => '5 kg',
                'jumlah' => 2,
                'harga_satuan' => 75000,
                'harga' => 150000,
            ],
            [
                'gambar' => 'images/pokcoy.jpg',
                'nama_produk' => 'Sayur Pokcoy Segar',
                'satuan_berat' => '250 gram',
                'jumlah' => 3,
                'harga_satuan' => 4800,
                'harga' => 14400,
            ],
            [
                'gambar' => 'images/telur_kampung.jpg',
                'nama_produk' => 'Telur Ayam Kampung',
                'satuan_berat' => '1 kg',
                'jumlah' => 1,
                'harga_satuan' => 30000,
                'harga' => 30000,
            ],
            [
                'gambar' => 'images/ayam.jpg',
                'nama_produk' => 'Ayam Kampung Segar',
                'satuan_berat' => '1 ekor (~1 kg)',
                'jumlah' => 1,
                'harga_satuan' => 45000,
                'harga' => 45000,
            ],
            [
                'gambar' => 'images/madu.jpg',
                'nama_produk' => 'Madu Hutan Asli',
                'satuan_berat' => '250 ml',
                'jumlah' => 2,
                'harga_satuan' => 40000,
                'harga' => 80000,
            ],
            [
                'gambar' => 'images/singkong.jpg',
                'nama_produk' => 'Singkong Organik',
                'satuan_berat' => '2 kg',
                'jumlah' => 4,
                'harga_satuan' => 12000,
                'harga' => 48000,
            ],
            [
                'gambar' => 'images/pisang.jpg',
                'nama_produk' => 'Pisang Kepok Manis',
                'satuan_berat' => '1 sisir',
                'jumlah' => 1,
                'harga_satuan' => 22000,
                'harga' => 22000,
            ],
            [
                'gambar' => 'images/bawang_merah.jpg',
                'nama_produk' => 'Bawang Merah Lokal',
                'satuan_berat' => '250 gr',
                'jumlah' => 2,
                'harga_satuan' => 18000,
                'harga' => 36000,
            ],
            [
                'gambar' => 'images/cabe_rawit.jpg',
                'nama_produk' => 'Cabe Rawit Merah',
                'satuan_berat' => '250 gr',
                'jumlah' => 5,
                'harga_satuan' => 10000,
                'harga' => 50000,
            ],
            [
                'gambar' => 'images/jagung.jpg',
                'nama_produk' => 'Jagung Manis Segar',
                'satuan_berat' => '1 kg',
                'jumlah' => 3,
                'harga_satuan' => 9000,
                'harga' => 27000,
            ],
            [
                'gambar' => 'images/jambu_air.jpg',
                'nama_produk' => 'Jambu Air Merah',
                'satuan_berat' => '1 kg',
                'jumlah' => 1,
                'harga_satuan' => 15000,
                'harga' => 15000,
            ],
            [
                'gambar' => 'images/ubi_ungu.jpg',
                'nama_produk' => 'Ubi Ungu Organik',
                'satuan_berat' => '2 kg',
                'jumlah' => 2,
                'harga_satuan' => 20000,
                'harga' => 40000,
            ],
        ],

        'alamat' => [
            [
                'nama' => 'Nikken Carmelia',
                'telepon' => '081234567890',
                'kecamatan' => 'Kecamatan A',
                'kelurahan' => 'Kelurahan X',
                'kodepos' => '12345',
                'alamat_lengkap' => 'Jl. Contoh No. 1 RT 01 RW 02'
            ],
            [
                'nama' => 'John Doe',
                'telepon' => '089876543210',
                'kecamatan' => 'Kecamatan B',
                'kelurahan' => 'Kelurahan Y',
                'kodepos' => '67890',
                'alamat_lengkap' => 'Jl. Contoh No. 2 RT 03 RW 04'
            ]
        ]

    ]);
});

Route::get('/riwayat', function () {
    return view('User/riwayat',[
        'konfirmasi_pesanan' => [
            [
                'tanggal' => '2025-10-13',
                'total' => 'Rp 50.000',
                'gambar' => 'images/beras.jpg',
                'produk' => 'Beras Kutai Premium',
                'status' => 'Menunggu Pembayaran',
                'jumlah' => rand(1, 5),
                'total_produk' => rand(1, 4)
            ],
            [
                'tanggal' => '2025-10-12',
                'total' => 'Rp 80.000',
                'gambar' => 'images/pokcoy.jpg',
                'produk' => 'Sayur Pokcoy Fresh',
                'status' => 'Menunggu Pembayaran',
                'jumlah' => rand(1, 5),
                'total_produk' => 1
            ],
        ],

        'menunggu_pembayaran' => [
            [
                'tanggal' => '2025-10-10',
                'total' => 'Rp 50.000',
                'gambar' => 'images/beras.jpg',
                'produk' => 'Beras Kutai Premium',
                'status' => 'Menunggu Pembayaran',
                'jumlah' => rand(1, 5),
                'total_produk' => rand(1, 4)
            ],
            [
                'tanggal' => '2025-10-10',
                'total' => 'Rp 65.000',
                'gambar' => 'images/pokcoy.jpg',
                'produk' => 'Sayur Pokcoy Fresh',
                'status' => 'Menunggu Pembayaran',
                'jumlah' => rand(1, 5),
                'total_produk' => 1
            ],
        ],

        'verifikasi_pembayaran' => [
            [
                'tanggal' => '2025-10-11',
                'total' => 'Rp 120.000',
                'gambar' => 'images/madu.jpg',
                'produk' => 'Madu Hutan Asli',
                'status' => 'Verifikasi Pembayaran',
                'jumlah' => rand(1, 5),
                'total_produk' => rand(1, 4)
            ],
            [
                'tanggal' => '2025-10-11',
                'total' => 'Rp 95.000',
                'gambar' => 'images/kopi.jpg',
                'produk' => 'Kopi Bubuk Kutai',
                'status' => 'Verifikasi Pembayaran',
                'jumlah' => rand(1, 5),
                'total_produk' => 1
            ],
        ],

        'diproses' => [
            // Menunggu Verifikasi Pembayaran (2 data)
            [
                'tanggal' => '2025-10-11',
                'total' => 'Rp 120.000',
                'gambar' => 'images/madu.jpg',
                'produk' => 'Madu Hutan Asli',
                'status' => 'Menunggu Verifikasi Pembayaran',
                'jumlah' => rand(1, 5),
                'total_produk' => rand(1, 4)
            ],
            [
                'tanggal' => '2025-10-11',
                'total' => 'Rp 95.000',
                'gambar' => 'images/kopi.jpg',
                'produk' => 'Kopi Bubuk Kutai',
                'status' => 'Menunggu Verifikasi Pembayaran',
                'jumlah' => rand(1, 5),
                'total_produk' => 1
            ],

            // Menyiapkan Pesanan (2 data)
            [
                'tanggal' => '2025-10-12',
                'total' => 'Rp 130.000',
                'gambar' => 'images/minyak_kelapa.jpg',
                'produk' => 'Minyak Kelapa Murni',
                'status' => 'Menyiapkan Pesanan',
                'jumlah' => rand(1, 5),
                'total_produk' => rand(1, 4)
            ],
            [
                'tanggal' => '2025-10-12',
                'total' => 'Rp 70.000',
                'gambar' => 'images/tempe.jpg',
                'produk' => 'Tempe Daun Jati',
                'status' => 'Menyiapkan Pesanan',
                'jumlah' => rand(1, 5),
                'total_produk' => 1
            ],
        ],

        'dikirim' => [
            [
                'tanggal' => '2025-10-13',
                'total' => 'Rp 110.000',
                'gambar' => 'images/bawang_merah.jpg',
                'produk' => 'Bawang Merah Lokal',
                'status' => 'Dikirim',
                'jumlah' => rand(1, 5),
                'total_produk' => rand(1, 4)
            ],
            [
                'tanggal' => '2025-10-13',
                'total' => 'Rp 150.000',
                'gambar' => 'images/ikan_asin.jpg',
                'produk' => 'Ikan Asin Tenggiri',
                'status' => 'Dikirim',
                'jumlah' => rand(1, 5),
                'total_produk' => 1
            ],
        ],

        'selesai' => [
            [
                'tanggal' => '2025-10-14',
                'total' => 'Rp 90.000',
                'gambar' => 'images/gula_aren.jpg',
                'produk' => 'Gula Aren Cair',
                'status' => 'Selesai',
                'jumlah' => rand(1, 5),
                'total_produk' => rand(1, 4)
            ],
            [
                'tanggal' => '2025-10-14',
                'total' => 'Rp 105.000',
                'gambar' => 'images/jambu_air.jpg',
                'produk' => 'Jambu Air Manis',
                'status' => 'Selesai',
                'jumlah' => rand(1, 5),
                'total_produk' => 1
            ],
        ],

        'dibatalkan' => [
            [
                'tanggal' => '2025-10-15',
                'total' => 'Rp 60.000',
                'gambar' => 'images/kangkung.jpg',
                'produk' => 'Sayur Kangkung',
                'status' => 'Dibatalkan',
                'jumlah' => rand(1, 5),
                'total_produk' => rand(1, 4)
            ],
            [
                'tanggal' => '2025-10-15',
                'total' => 'Rp 85.000',
                'gambar' => 'images/singkong.jpg',
                'produk' => 'Singkong Kutai',
                'status' => 'Dibatalkan',
                'jumlah' => rand(1, 5),
                'total_produk' => 1
            ],
        ]
    ]);
});

Route::get('/pembayaran', function () {
    return view('User/pembayaran', [
        'pembayaran' => [
            [
                'gambar' => 'images/beras.jpg',
                'nama_produk' => 'Beras Kutai Premium',
                'satuan_berat' => '5 kg',
                'jumlah' => 2,
                'harga_satuan' => 75000,  // Numeric per item
                'harga' => 150000,  // String formatted (total = jumlah * satuan)
            ],
            [
                'gambar' => 'images/pokcoy.jpg',
                'nama_produk' => 'Sayur Pokcoy Segar',
                'satuan_berat' => '250 gram',
                'jumlah' => 3,
                'harga_satuan' => 4800,
                'harga' => 14400,
            ],
            [
                'gambar' => 'images/telur_kampung.jpg',
                'nama_produk' => 'Telur Ayam Kampung',
                'satuan_berat' => '1 kg',
                'jumlah' => 1,
                'harga_satuan' => 30000,
                'harga' => 30000,
            ],
            [
                'gambar' => 'images/ayam.jpg',
                'nama_produk' => 'Ayam Kampung Segar',
                'satuan_berat' => '1 ekor (~1 kg)',
                'jumlah' => 1,
                'harga_satuan' => 45000,
                'harga' => 45000,
            ],
            [
                'gambar' => 'images/madu.jpg',
                'nama_produk' => 'Madu Hutan Asli',
                'satuan_berat' => '250 ml',
                'jumlah' => 2,
                'harga_satuan' => 40000,
                'harga' => 80000,
            ],
            [
                'gambar' => 'images/singkong.jpg',
                'nama_produk' => 'Singkong Organik',
                'satuan_berat' => '2 kg',
                'jumlah' => 4,
                'harga_satuan' => 12000,
                'harga' => 48000,
            ],
            [
                'gambar' => 'images/pisang.jpg',
                'nama_produk' => 'Pisang Kepok Manis',
                'satuan_berat' => '1 sisir',
                'jumlah' => 1,
                'harga_satuan' => 22000,
                'harga' => 22000,
            ],
            [
                'gambar' => 'images/bawang_merah.jpg',
                'nama_produk' => 'Bawang Merah Lokal',
                'satuan_berat' => '250 gr',
                'jumlah' => 2,
                'harga_satuan' => 18000,
                'harga' => 36000,
            ],
            [
                'gambar' => 'images/cabe_rawit.jpg',
                'nama_produk' => 'Cabe Rawit Merah',
                'satuan_berat' => '250 gr',
                'jumlah' => 5,
                'harga_satuan' => 10000,
                'harga' => 50000,
            ],
            [
                'gambar' => 'images/jagung.jpg',
                'nama_produk' => 'Jagung Manis Segar',
                'satuan_berat' => '1 kg',
                'jumlah' => 3,
                'harga_satuan' => 9000,
                'harga' => 27000,
            ],
            [
                'gambar' => 'images/jambu_air.jpg',
                'nama_produk' => 'Jambu Air Merah',
                'satuan_berat' => '1 kg',
                'jumlah' => 1,
                'harga_satuan' => 15000,
                'harga' => 15000,
            ],
            [
                'gambar' => 'images/ubi_ungu.jpg',
                'nama_produk' => 'Ubi Ungu Organik',
                'satuan_berat' => '2 kg',
                'jumlah' => 2,
                'harga_satuan' => 20000,
                'harga' => 40000,
            ],
        ]
    ]);
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');

    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');

    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(SocialiteController::class)->group(function () {
    Route::get('auth/google', 'googleLogin')->name('auth.google');
    Route::get('auth/google-callback', 'googleAuthentication')->name('auth.google-callback');
});

// Forgot Password (publik, gak perlu auth)
Route::get('/lupa-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/lupa-password', [AuthController::class, 'forgotPassword'])->name('password.email');

// Reset Password (publik)
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// ROUTE USER (role 'user', staff, super_admin) - Prefix 'user', middleware 'auth'
    Route::prefix('user')->middleware('auth')->group(function () {

        Route::get('/beranda', [PengurusController::class, 'tampilBeranda'])->name('user.beranda'); // Ganti nama

        Route::get('/produk', [UserProdukController::class, 'produk'])->name('user.produk');
        Route::get('/produk/{id}', [UserProdukController::class, 'detailProduk'])->name('user.produk.detail');


        // PROFIL USER
        Route::get('/profil', [ProfilController::class, 'userIndex'])->name('user.profil');
            Route::put('/profil', [ProfilController::class, 'userUpdate'])->name('user.profil.update');
            Route::put('/profil/password', [ProfilController::class, 'userUpdatePassword'])->name('user.profil.password');

        // ALAMAT (CRUD)
        Route::post('/alamat', [AlamatController::class, 'store'])->name('user.alamat.store');
        Route::put('/alamat/{id}', [AlamatController::class, 'update'])->name('user.alamat.update');
        Route::delete('/alamat/{id}', [AlamatController::class, 'destroy'])->name('user.alamat.destroy');

        // DROPDOWN AJAX
        Route::get('/kelurahan/{kecamatan}', [AlamatController::class, 'kelurahanByKecamatan']);
        Route::get('/kodepos/{kelurahan}', [AlamatController::class, 'kodePosByKelurahan']);
    });

    Route::prefix('keranjang')->name('keranjang.')->group(function () {
        Route::get('/', [KeranjangController::class, 'index'])->name('index');
        Route::post('/add', [KeranjangController::class, 'add'])->name('add');
        Route::post('/update', [KeranjangController::class, 'update'])->name('update');
        Route::post('/delete-multiple', [KeranjangController::class, 'deleteMultiple'])->name('delete-multiple');
        Route::delete('/delete/{id}', [KeranjangController::class, 'delete'])->name('delete');
        Route::delete('/clear', [KeranjangController::class, 'clear'])->name('clear');
        Route::get('/checkout', [KeranjangController::class, 'checkout'])->name('checkout');
    });

Route::prefix('kurir')->middleware('auth')->group(function () {

        // PROFIL KURIR
        Route::get('/profil', [ProfilController::class, 'kurirIndex'])->name('kurir.profil');
        Route::put('/profil', [ProfilController::class, 'kurirUpdate'])->name('kurir.profil.update');
        Route::put('/profil/password', [ProfilController::class, 'kurirUpdatePassword'])->name('kurir.profil.password');

        // PENGIRIMAN MASUK (DUMMY)
        Route::get('/pengiriman_masuk', function () {
            return view('Kurir.pengirimanMasuk', [
                'pengiriman_masuk' => [
                    [
                        'id' => 1,
                        'tanggal' => '2025-10-25',
                        'produk' => 'Sayur Kangkung Segar',
                        'jumlah' => '2 ikat',
                        'ongkir' => 'Rp 5.000',
                        'alamat' => 'Jl. Mawar No. 12, Sendawar',
                        'gambar' => 'images/kangkung.jpg',
                        'supplier' => 'Petani',
                        'total_produk' => 1,
                        'status' => 'pending',
                    ],
                    [
                        'id' => 2,
                        'tanggal' => '2025-10-24',
                        'produk' => 'Beras Kutai Premium 5kg',
                        'jumlah' => '1 karung',
                        'ongkir' => 'Rp 10.000',
                        'alamat' => 'Jl. Melati No. 8, Barong Tongkok',
                        'gambar' => 'images/beras.jpg',
                        'supplier' => 'Bulog',
                        'total_produk' => 3,
                        'status' => 'dikirim',
                    ],
                    [
                        'id' => 3,
                        'tanggal' => '2025-10-24',
                        'produk' => 'Telur Ayam Kampung',
                        'jumlah' => '1 rak (30 butir)',
                        'ongkir' => 'Rp 7.000',
                        'alamat' => 'Jl. Sawo No. 22, Linggang Bigung',
                        'gambar' => 'images/telur_kampung.jpg',
                        'supplier' => 'Peternak',
                        'total_produk' => 2,
                        'status' => 'pending',
                    ],
                ]
            ]);
        })->name('kurir.pengiriman');

        // STATUS PENGIRIMAN (DUMMY)
        Route::get('/status_pengiriman', function () {
            return view('Kurir.statusPengiriman');
        })->name('kurir.status');

        // RIWAYAT PENGIRIMAN (DUMMY)
        Route::get('/riwayat_pengiriman', function () {
            return view('Kurir.riwayatPengiriman');
        })->name('kurir.riwayat');
    });

Route::prefix('staff_produk')->middleware('auth')->name('produk.')->group(function () {
    Route::get('/dashboard', [ProdukController::class, 'dashboardProduk'])->name('dashboard');
    Route::get('/data', [ProdukController::class, 'dataProduk'])->name('data');

    //Produk
    Route::get('/tambah', [ProdukController::class, 'tambahProduk'])->name('tambah');
    Route::post('/store', [ProdukController::class, 'storeProduk'])->name('store');
    Route::get('/edit_produk/{id}', [ProdukController::class, 'edit'])->name('edit');
    Route::put('/update_produk/{id}', [ProdukController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ProdukController::class, 'destroy'])->name('destroy');

    //Batch
    Route::get('/produk/{id_produk}/batch', [BatchController::class, 'index'])->name('batch.index');
    Route::post('/batch/store', [BatchController::class, 'store'])->name('batch.store');
    Route::put('/batch/update/{id}', [BatchController::class, 'update'])->name('batch.update');
    Route::delete('/batch/delete/{id}', [BatchController::class, 'destroy'])->name('batch.delete');
    Route::put('/batch/diskon/{id}', [BatchController::class, 'applyDiscount'])->name('batch.diskon');
    Route::put('/batch/naik/{id}', [BatchController::class, 'increasePrice'])->name('batch.naik');

    Route::get('/diskon', [ProdukDiskonController::class, 'produkDiskon'])->name('diskon');  // Diubah ke BatchController::produkDiskon
    Route::get('/detail_diskon/{id_produk}', [ProdukDiskonController::class, 'detailDiskon'])->name('detailDiskon'); // Route baru untuk detail_diskon

    //Komponen Produk
    Route::prefix('komponen')->name('komponen.')->group(function () {
        Route::get('/', [KomponenProdukController::class, 'index'])->name('index');
        // Kategori
        Route::post('/kategori', [KomponenProdukController::class, 'storeKategori'])->name('kategori.store');
        Route::put('/kategori/{id}', [KomponenProdukController::class, 'updateKategori'])->name('kategori.update');
        Route::delete('/kategori/{id}', [KomponenProdukController::class, 'destroyKategori'])->name('kategori.destroy');
        //Pindah Kategori
        Route::post('/kategori/move', [KomponenProdukController::class, 'moveKategori'])->name('kategori.move');

        //Satuan
        Route::post('/satuan', [KomponenProdukController::class, 'storeSatuan'])->name('satuan.store');
        Route::put('/satuan/{id}', [KomponenProdukController::class, 'updateSatuan'])->name('satuan.update');
        Route::delete('/satuan/{id}', [KomponenProdukController::class, 'destroySatuan'])->name('satuan.destroy');
        // Pindah Satuan
        Route::post('/satuan/move', [KomponenProdukController::class, 'moveSatuan'])->name('satuan.move');

        //Supplier
        Route::post('/supplier', [KomponenProdukController::class, 'storeSupplier'])->name('supplier.store');
        Route::put('/supplier/{id}', [KomponenProdukController::class, 'updateSupplier'])->name('supplier.update');
        Route::delete('/supplier/{id}', [KomponenProdukController::class, 'destroySupplier'])->name('supplier.destroy');
        //Pindah Supplier
        Route::post('/supplier/move', [KomponenProdukController::class, 'moveSupplier'])->name('supplier.move');
    });

    Route::get('/kelola_stok', [PengelolaanStokController::class, 'index'])->name('kelola_stok');

    Route::get('/arsip', [ProdukArsipController::class, 'arsipProduk'])->name('arsip');

    Route::get('/rusak_cacat', [ProdukRusakCacatController::class, 'index'])->name('rusak_cacat.index');
    Route::get('/rusak_cacat/{id_produk}', [ProdukRusakCacatController::class, 'show'])->name('rusak_cacat.show');
    Route::post('/rusak_cacat/store', [ProdukRusakCacatController::class, 'store'])->name('rusak_cacat.store');
});


Route::prefix('arsip-produk')->group(function () {
    Route::post('/restore/{id}', [ProdukArsipController::class, 'restoreProduk']);
    Route::post('/restore-selected', [ProdukArsipController::class, 'restoreSelectedProduk']);
    Route::post('/restore-all', [ProdukArsipController::class, 'restoreAllProduk']);
});

Route::prefix('purchasing')->middleware('auth')->name('staff_purchasing.')->group(function(){
    Route::get('/kelola_ongkir', [OngkirDaerahController::class, 'index'])->name('ongkir.index');

    // ================= KECAMATAN =================
    Route::get('/kecamatan',[OngkirDaerahController::class,'kecamatanIndex'])->name('kecamatan.index');
    Route::post('/kecamatan',[OngkirDaerahController::class,'kecamatanStore'])->name('kecamatan.store');
    Route::put('/kecamatan/{id}',[OngkirDaerahController::class,'kecamatanUpdate'])->name('kecamatan.update');
    Route::delete('/kecamatan/{id}',[OngkirDaerahController::class,'kecamatanDestroy'])->name('kecamatan.destroy');

    // ================= KELURAHAN =================
    Route::get('/kelurahan',[OngkirDaerahController::class,'kelurahanIndex'])->name('kelurahan.index');
    Route::post('/kelurahan',[OngkirDaerahController::class,'kelurahanStore'])->name('kelurahan.store');
    Route::put('/kelurahan/{id}',[OngkirDaerahController::class,'kelurahanUpdate'])->name('kelurahan.update');
    Route::delete('/kelurahan/{id}',[OngkirDaerahController::class,'kelurahanDestroy'])->name('kelurahan.destroy');

    // ================= KODE POS =================
    Route::get('/kode-pos',[OngkirDaerahController::class,'kodeposIndex'])->name('kodepos.index');
    Route::post('/kode-pos',[OngkirDaerahController::class,'kodeposStore'])->name('kodepos.store');
    Route::put('/kode-pos/{id}',[OngkirDaerahController::class,'kodeposUpdate'])->name('kodepos.update');
    Route::delete('/kode-pos/{id}',[OngkirDaerahController::class,'kodeposDestroy'])->name('kodepos.destroy');

    // ================= AJAX / HELPER =================
    Route::get('/kelurahan-by-kecamatan/{id}',[OngkirDaerahController::class,'getKelurahanByKecamatan'])
        ->name('kelurahan.byKecamatan');
});

Route::prefix('super_admin')->name('super_admin.')->middleware('auth') ->group(function () {
        /* ================= DASHBOARD ================= */
        Route::get('/dashboard', function () {
            return view('super_admin.dashboard');
        })->name('dashboard');

        /* ================= MANAJEMEN USER ================= */
        Route::get('/manajemen_user', [ManajemenUserController::class, 'index'])->name('user.index');
        Route::put('/manajemen_user/{id}', [ManajemenUserController::class, 'updateRole']) ->name('user.update');

        /* ================= MANAJEMEN PENGURUS ================= */
        Route::get('/manajemen_pengurus', [PengurusController::class, 'index'])->name('pengurus.index');
        Route::post('/manajemen_pengurus', [PengurusController::class, 'store'])->name('pengurus.store');
        Route::put('/manajemen_pengurus/{id}', [PengurusController::class, 'update'])->name('pengurus.update');
        Route::delete('/manajemen_pengurus/{id}', [PengurusController::class, 'destroy'])->name('pengurus.destroy');
    });

Route::get('/status_pengiriman', function () {
    return view('Kurir/statusPengiriman', [
        'pengiriman' => [
            [
                'tanggal' => '2025-10-25',
                'alamat' => 'Jl. Mawar No. 12, Barong Tongkok',
                'gambar' => 'images/beras.jpg',
                'produk' => 'Beras Kutai Premium',
                'jumlah' => '2 Karung (50kg)',
                'total' => 'Rp 520.000',
                'ongkir' => 'Rp 15.000',
                'status' => 'Menunggu Pengiriman',
                'total_produk' => 1,
                'supplier' => 'Bulog'
            ],
            [
                'tanggal' => '2025-10-24',
                'alamat' => 'Jl. Melati No. 8, Sendawar',
                'gambar' => 'images/pokcoy.jpg',
                'produk' => 'Sayur Pokcoy Segar',
                'jumlah' => '5 Ikat',
                'total' => 'Rp 35.000',
                'ongkir' => 'Rp 10.000',
                'status' => 'Menunggu Pengiriman',
                'total_produk' => 3,
                'supplier' => 'Petani'
            ],
            [
                'tanggal' => '2025-10-23',
                'alamat' => 'Jl. Kenanga No. 21, Linggang Bigung',
                'gambar' => 'images/telur_kampung.jpg',
                'produk' => 'Telur Ayam Kampung',
                'jumlah' => '2 Kg',
                'total' => 'Rp 90.000',
                'ongkir' => 'Rp 12.000',
                'status' => 'Menunggu Pengiriman',
                'total_produk' => 2,
                'supplier' => 'Petani'
            ],
            [
                'tanggal' => '2025-10-22',
                'alamat' => 'Jl. Dahlia No. 5, Tering Seberang',
                'gambar' => 'images/kangkung.jpg',
                'produk' => 'Sayur Kangkung Organik',
                'jumlah' => '3 Ikat',
                'total' => 'Rp 27.000',
                'ongkir' => 'Rp 8.000',
                'status' => 'Dikirim',
                'total_produk' => 1,
                'supplier' => 'Petani'
            ],
            [
                'tanggal' => '2025-10-21',
                'alamat' => 'Jl. A. Yani No. 7, Muara Pahu',
                'gambar' => 'images/ikan.jpeg',
                'produk' => 'Ikan Nila Segar',
                'jumlah' => '1 Kg',
                'total' => 'Rp 60.000',
                'ongkir' => 'Rp 10.000',
                'status' => 'Dikirim',
                'total_produk' => 4,
                'supplier' => 'Nelayan'
            ],
        ]
    ]);
});


Route::get('/riwayat_kurir', function () {
    return view('Kurir/riwayat', [
        'riwayat' => [
            [
                'tanggal' => '2025-10-25',
                'alamat' => 'Jl. Mawar No. 12, Barong Tongkok',
                'gambar' => 'images/beras.jpg',
                'produk' => 'Beras Kutai Premium',
                'jumlah' => '2 Karung (50kg)',
                'total' => 'Rp 520.000',
                'ongkir' => 'Rp 15.000',
                'status' => 'Selesai',
                'supplier' => 'Bulog',
                'total_produk' => 1  // Hanya 1 produk
            ],
            [
                'tanggal' => '2025-10-24',
                'alamat' => 'Jl. Melati No. 8, Sendawar',
                'gambar' => 'images/pokcoy.jpg',
                'produk' => 'Sayur Pokcoy Segar',
                'jumlah' => '5 Ikat',
                'total' => 'Rp 35.000',
                'ongkir' => 'Rp 10.000',
                'status' => 'Selesai',
                'supplier' => 'Petani',
                'total_produk' => 3  // Ada 3 produk total
            ],
            [
                'tanggal' => '2025-10-23',
                'alamat' => 'Jl. Kenanga No. 21, Linggang Bigung',
                'gambar' => 'images/telur_kampung.jpg',
                'produk' => 'Telur Ayam Kampung',
                'jumlah' => '2 Kg',
                'total' => 'Rp 90.000',
                'ongkir' => 'Rp 12.000',
                'status' => 'Ditolak',
                'supplier' => 'Peternak',
                'total_produk' => 2  // Ada 2 produk total
            ],
            [
                'tanggal' => '2025-10-22',
                'alamat' => 'Jl. Dahlia No. 5, Tering Seberang',
                'gambar' => 'images/kangkung.jpg',
                'produk' => 'Sayur Kangkung Organik',
                'jumlah' => '3 Ikat',
                'total' => 'Rp 27.000',
                'ongkir' => 'Rp 8.000',
                'status' => 'Ditolak',
                'supplier' => 'Petani',
                'total_produk' => 1  // Hanya 1 produk
            ],
            [
                'tanggal' => '2025-10-21',
                'alamat' => 'Jl. A. Yani No. 7, Muara Pahu',
                'gambar' => 'images/ikan.jpeg',
                'produk' => 'Ikan Nila Segar',
                'jumlah' => '1 Kg',
                'total' => 'Rp 60.000',
                'ongkir' => 'Rp 10.000',
                'status' => 'Selesai',
                'supplier' => 'Nelayan',
                'total_produk' => 4  // Ada 4 produk total
            ],
        ]
    ]);
});

Route::get('/kurir/detail', function () {
    return view('Kurir/lihatDetail', [
        'detail' => [
            'nama_penerima' => 'Rina Marlina',
            'no_telp' => '0812-3456-7890',
            'alamat_jalan' => 'Jl. Mawar No. 12',
            'kelurahan' => 'Barong Tongkok',
            'kecamatan' => 'Barong',
            'kabupaten' => 'Kutai Barat',
            'kode_pos' => '75776',
            'tanggal' => '2025-10-25',
            'produk_list' => [
                [
                    'gambar' => 'images/beras.jpg',
                    'produk' => 'Beras Kutai Premium',
                    'jumlah' => '2 Karung (50kg)',
                    'supplier' => 'Bulog',
                ],
                [
                    'gambar' => 'images/pokcoy.jpg',
                    'produk' => 'Sayur Pokcoy Segar',
                    'jumlah' => '5 Ikat',
                    'supplier' => 'Petani',
                ]
            ],
            'ongkir' => 'Rp 15.000',
        ]
    ]);
});


Route::get('/purchasing/dashboard', function () {
    // Dummy data pesanan
    $pesanan = [
        [
            'id' => 1,
            'pelanggan' => 'Budi Santoso',
            'alamat' => 'Jl. Melak No. 123, Kec. Melak',
            'total' => 150000,
            'tanggal' => '2025-11-25',
            'status' => 'Masuk'
        ],
        [
            'id' => 2,
            'pelanggan' => 'Siti Nurhaliza',
            'alamat' => 'Jl. Barong Tongkok No. 45, Kec. Barong Tongkok',
            'total' => 250000,
            'tanggal' => '2025-11-25',
            'status' => 'Konfirmasi Pembayaran'
        ],
        [
            'id' => 3,
            'pelanggan' => 'Ahmad Fauzi',
            'alamat' => 'Jl. Simpang Raya No. 78, Kec. Melak',
            'total' => 180000,
            'tanggal' => '2025-11-24',
            'status' => 'Belum Dapat Kurir'
        ],
        [
            'id' => 4,
            'pelanggan' => 'Dewi Sartika',
            'alamat' => 'Jl. Lain No. 12, Kec. Melak',
            'total' => 120000,
            'tanggal' => '2025-11-24',
            'status' => 'Di Proses'
        ],
        [
            'id' => 5,
            'pelanggan' => 'Rudi Hartono',
            'alamat' => 'Jl. Barong No. 56, Kec. Barong Tongkok',
            'total' => 300000,
            'tanggal' => '2025-11-23',
            'status' => 'Di Proses'
        ],
        [
            'id' => 6,
            'pelanggan' => 'Lina Sari',
            'alamat' => 'Jl. Melak Utara No. 90, Kec. Melak',
            'total' => 90000,
            'tanggal' => '2025-11-23',
            'status' => 'Masuk'
        ],
        [
            'id' => 7,
            'pelanggan' => 'Joko Widodo',
            'alamat' => 'Jl. Tongkok Selatan No. 34, Kec. Barong Tongkok',
            'total' => 220000,
            'tanggal' => '2025-11-22',
            'status' => 'Konfirmasi Pembayaran'
        ],
        [
            'id' => 8,
            'pelanggan' => 'Maya Indah',
            'alamat' => 'Jl. Simpang Raya Barat No. 67, Kec. Melak',
            'total' => 110000,
            'tanggal' => '2025-11-22',
            'status' => 'Belum Dapat Kurir'
        ]
    ];

    // Dummy data kecamatan (dari CRUD sebelumnya)
    $kecamatans = [
        ['id' => 1, 'nama' => 'Melak', 'ongkir' => 10000],
        ['id' => 2, 'nama' => 'Barong Tongkok', 'ongkir' => 15000],
        ['id' => 3, 'nama' => 'Long Bagun', 'ongkir' => 12000]
    ];

    return view('Staff_Purchasing.dashboard', compact('pesanan', 'kecamatans'));
   });

Route::get('/purchasing/pesanan_masuk', function () {
    return view('Staff_Purchasing/pesananMasuk', [
        'pengiriman_masuk' => [
            [
                'tanggal' => '2025-11-25',
                'produk' => 'Sayur Kangkung Segar',
                'jumlah' => '2 ikat',
                'ongkir' => 'Rp 5.000',
                'alamat' => 'Jl. Mawar No. 12, Sendawar',
                'gambar' => 'images/kangkung.jpg',
                'supplier' => 'Petani',
                'total_produk' => 1,  // Hanya 1 produk
                'total_produk_harga' => 15000,
                'metode_pengiriman' => 'pick-up'
            ],
            [
                'tanggal' => '2025-11-24',
                'produk' => 'Beras Kutai Premium 5kg',
                'jumlah' => '1 karung',
                'ongkir' => 'Rp 10.000',
                'alamat' => 'Jl. Melati No. 8, Barong Tongkok',
                'gambar' => 'images/beras.jpg',
                'supplier' => 'Bulog',
                'total_produk' => 3,  // Ada 3 produk total (beras + 2 lain)
                'total_produk_harga' => 75000,
                'metode_pengiriman' => 'diantar'
            ],
            [
                'tanggal' => '2025-11-24',
                'produk' => 'Telur Ayam Kampung',
                'jumlah' => '1 rak (30 butir)',
                'ongkir' => 'Rp 7.000',
                'alamat' => 'Jl. Sawo No. 22, Linggang Bigung',
                'gambar' => 'images/telur_kampung.jpg',
                'supplier' => 'Peternak',
                'total_produk' => 2,  // Ada 2 produk total
                'total_produk_harga' => 45000,
                'metode_pengiriman' => 'pick-up'
            ],
            [
                'tanggal' => '2025-11-23',
                'produk' => 'Sayur Bayam Segar',
                'jumlah' => '3 ikat',
                'ongkir' => 'Rp 4.000',
                'alamat' => 'Jl. Kenanga No. 9, Sekolaq Darat',
                'gambar' => 'images/bayam.jpeg',
                'supplier' => 'Petani',
                'total_produk' => 1,  // Hanya 1 produk
                'total_produk_harga' => 12000,
                'metode_pengiriman' => 'diantar'
            ],
            [
                'tanggal' => '2025-11-22',
                'produk' => 'Ikan Gabus Segar',
                'jumlah' => '2 ekor (1kg)',
                'ongkir' => 'Rp 12.000',
                'alamat' => 'Jl. Mawar Putih No. 5, Melak',
                'gambar' => 'images/ikan.jpeg',
                'supplier' => 'Nelayan',
                'total_produk' => 4,  // Ada 4 produk total
                'total_produk_harga' => 120000,
                'metode_pengiriman' => 'pick-up'
            ],
        ]
    ]);
});

Route::get('/purchasing/detail_pesanan', function () {
    return view('Staff_Purchasing/detailPesanan', [
        'detail' => [
            'nama_penerima' => 'Rina Marlina',
            'no_telp' => '0812-3456-7890',
            'alamat_jalan' => 'Jl. Mawar No. 12',
            'kelurahan' => 'Barong Tongkok',
            'kecamatan' => 'Barong',
            'kabupaten' => 'Kutai Barat',
            'kode_pos' => '75776',
            'tanggal' => '2025-10-25',
            'produk_list' => [
                [
                    'gambar' => 'images/beras.jpg',
                    'produk' => 'Beras Kutai Premium',
                    'deskripsi' => '5kg',
                    'jumlah' => '2 Karung',
                    'harga' => 75000,
                    'subtotal' => 150000,
                    'supplier' => 'Bulog',
                ],
                [
                    'gambar' => 'images/pokcoy.jpg',
                    'produk' => 'Sayur Pokcoy Segar',
                    'deskripsi' => '',
                    'jumlah' => '5 Ikat',
                    'harga' => 5000,
                    'subtotal' => 25000,
                    'supplier' => 'Petani',
                ]
            ],
            'ongkir' => 'Rp 15.000',
        ]
    ]);
});

Route::get('/purchasing/cari_kurir', function () {
    return view('Staff_Purchasing/cariKurir', [
        'pengiriman_masuk' => [
            [
                'tanggal' => '2025-11-25',
                'produk' => 'Sayur Kangkung Segar',
                'jumlah' => '2 ikat',
                'ongkir' => 'Rp 5.000',
                'alamat' => 'Jl. Mawar No. 12, Sendawar',
                'gambar' => 'images/kangkung.jpg',
                'supplier' => 'Petani',
                'total_produk' => 1,  // Hanya 1 produk
                'total_produk_harga' => 15000,
                'metode_pengiriman' => 'diantar'
            ],
            [
                'tanggal' => '2025-11-24',
                'produk' => 'Beras Kutai Premium 5kg',
                'jumlah' => '1 karung',
                'ongkir' => 'Rp 10.000',
                'alamat' => 'Jl. Melati No. 8, Barong Tongkok',
                'gambar' => 'images/beras.jpg',
                'supplier' => 'Bulog',
                'total_produk' => 3,  // Ada 3 produk total (beras + 2 lain)
                'total_produk_harga' => 75000,
                'metode_pengiriman' => 'diantar'
            ],
            [
                'tanggal' => '2025-11-24',
                'produk' => 'Telur Ayam Kampung',
                'jumlah' => '1 rak (30 butir)',
                'ongkir' => 'Rp 7.000',
                'alamat' => 'Jl. Sawo No. 22, Linggang Bigung',
                'gambar' => 'images/telur_kampung.jpg',
                'supplier' => 'Peternak',
                'total_produk' => 2,  // Ada 2 produk total
                'total_produk_harga' => 45000,
                'metode_pengiriman' => 'diantar'
            ],
            [
                'tanggal' => '2025-11-23',
                'produk' => 'Sayur Bayam Segar',
                'jumlah' => '3 ikat',
                'ongkir' => 'Rp 4.000',
                'alamat' => 'Jl. Kenanga No. 9, Sekolaq Darat',
                'gambar' => 'images/bayam.jpeg',
                'supplier' => 'Petani',
                'total_produk' => 1,  // Hanya 1 produk
                'total_produk_harga' => 12000,
                'metode_pengiriman' => 'diantar'
            ],
            [
                'tanggal' => '2025-11-22',
                'produk' => 'Ikan Gabus Segar',
                'jumlah' => '2 ekor (1kg)',
                'ongkir' => 'Rp 12.000',
                'alamat' => 'Jl. Mawar Putih No. 5, Melak',
                'gambar' => 'images/ikan.jpeg',
                'supplier' => 'Nelayan',
                'total_produk' => 4,  // Ada 4 produk total
                'total_produk_harga' => 120000,
                'metode_pengiriman' => 'diantar'
            ],
        ]
    ]);
});

Route::get('/purchasing/konfirmasi_pembayaran', function () {
    return view('Staff_Purchasing/konfirmasiPembayaran', [
        'pengiriman_masuk' => [
            [
                'tanggal' => '2025-11-25',
                'produk' => 'Sayur Kangkung Segar',
                'jumlah' => '2 ikat',
                'ongkir' => 'Rp 5.000',
                'alamat' => 'Jl. Mawar No. 12, Sendawar',
                'gambar' => 'images/kangkung.jpg',
                'supplier' => 'Petani',
                'total_produk' => 1,  // Hanya 1 produk
                'total_produk_harga' => 15000,
                'bukti_bayar' => 'images/bukti_bayar.jpeg',
                'metode_pengiriman' => 'pick-up'
            ],
            [
                'tanggal' => '2025-11-24',
                'produk' => 'Beras Kutai Premium 5kg',
                'jumlah' => '1 karung',
                'ongkir' => 'Rp 10.000',
                'alamat' => 'Jl. Melati No. 8, Barong Tongkok',
                'gambar' => 'images/beras.jpg',
                'supplier' => 'Bulog',
                'total_produk' => 3,  // Ada 3 produk total (beras + 2 lain)
                'total_produk_harga' => 75000,
                'bukti_bayar' => 'images/bukti_bayar.jpeg',
                'metode_pengiriman' => 'diantar'
            ],
            [
                'tanggal' => '2025-11-24',
                'produk' => 'Telur Ayam Kampung',
                'jumlah' => '1 rak (30 butir)',
                'ongkir' => 'Rp 7.000',
                'alamat' => 'Jl. Sawo No. 22, Linggang Bigung',
                'gambar' => 'images/telur_kampung.jpg',
                'supplier' => 'Peternak',
                'total_produk' => 2,  // Ada 2 produk total
                'total_produk_harga' => 45000,
                'bukti_bayar' => 'images/bukti_bayar.jpeg',
                'metode_pengiriman' => 'pick-up'
            ],
            [
                'tanggal' => '2025-11-23',
                'produk' => 'Sayur Bayam Segar',
                'jumlah' => '3 ikat',
                'ongkir' => 'Rp 4.000',
                'alamat' => 'Jl. Kenanga No. 9, Sekolaq Darat',
                'gambar' => 'images/bayam.jpeg',
                'supplier' => 'Petani',
                'total_produk' => 1,  // Hanya 1 produk
                'total_produk_harga' => 12000,
                'bukti_bayar' => 'images/bukti_bayar.jpeg',
                'metode_pengiriman' => 'diantar'
            ],
            [
                'tanggal' => '2025-11-22',
                'produk' => 'Ikan Gabus Segar',
                'jumlah' => '2 ekor (1kg)',
                'ongkir' => 'Rp 12.000',
                'alamat' => 'Jl. Mawar Putih No. 5, Melak',
                'gambar' => 'images/ikan.jpeg',
                'supplier' => 'Nelayan',
                'total_produk' => 4,  // Ada 4 produk total
                'total_produk_harga' => 120000,
                'bukti_bayar' => 'images/bukti_bayar.jpeg',
                'metode_pengiriman' => 'pick-up'
            ],
        ]
    ]);
});

Route::get('/purchasing/pesanan_berjalan', function () {
    return view('Staff_Purchasing/pesananBerjalan', [
        'pesananBerjalan' => [
            [
                'tanggal' => '2025-11-25',
                'produk' => 'Sayur Kangkung Segar',
                'jumlah' => '2 ikat',
                'ongkir' => 'Rp 5.000',
                'alamat' => 'Jl. Mawar No. 12, Sendawar',
                'gambar' => 'images/kangkung.jpg',
                'supplier' => 'Petani',
                'total_produk' => 1,
                'total_produk_harga' => 15000,
                'metode_pengiriman' => 'pick-up'
            ],
            [
                'tanggal' => '2025-11-24',
                'produk' => 'Beras Kutai Premium 5kg',
                'jumlah' => '1 karung',
                'ongkir' => 'Rp 10.000',
                'alamat' => 'Jl. Melati No. 8, Barong Tongkok',
                'gambar' => 'images/beras.jpg',
                'supplier' => 'Bulog',
                'total_produk' => 3,
                'total_produk_harga' => 75000,
                'metode_pengiriman' => 'diantar'
            ]
        ],
        'siapDiambil' => [
            [
                'tanggal' => '2025-11-24',
                'produk' => 'Telur Ayam Kampung',
                'jumlah' => '1 rak (30 butir)',
                'ongkir' => 'Rp 7.000',
                'alamat' => 'Jl. Sawo No. 22, Linggang Bigung',
                'gambar' => 'images/telur_kampung.jpg',
                'supplier' => 'Peternak',
                'total_produk' => 2,
                'total_produk_harga' => 45000,
                'metode_pengiriman' => 'pick-up'
            ],
            [
                'tanggal' => '2025-11-23',
                'produk' => 'Sayur Bayam Segar',
                'jumlah' => '3 ikat',
                'ongkir' => 'Rp 4.000',
                'alamat' => 'Jl. Kenanga No. 9, Sekolaq Darat',
                'gambar' => 'images/bayam.jpeg',
                'supplier' => 'Petani',
                'total_produk' => 1,
                'total_produk_harga' => 12000,
                'metode_pengiriman' => 'diantar'
            ]
        ],
        'menungguPembayaran' => [
            [
                'tanggal' => '2025-11-22',
                'produk' => 'Ikan Gabus Segar',
                'jumlah' => '2 ekor (1kg)',
                'ongkir' => 'Rp 12.000',
                'alamat' => 'Jl. Mawar Putih No. 5, Melak',
                'gambar' => 'images/ikan.jpeg',
                'supplier' => 'Nelayan',
                'total_produk' => 4,
                'total_produk_harga' => 120000,
                'metode_pengiriman' => 'pick-up'
            ],
            [
                'tanggal' => '2025-11-21',
                'produk' => 'Ayam Potong Segar',
                'jumlah' => '1 ekor (1.5kg)',
                'ongkir' => 'Rp 8.000',
                'alamat' => 'Jl. Anggrek No. 15, Tenggarong',
                'gambar' => 'images/ayam.jpg',
                'supplier' => 'Peternak',
                'total_produk' => 2,
                'total_produk_harga' => 60000,
                'metode_pengiriman' => 'diantar'
            ]
        ]
    ]);
});

Route::get('/purchasing/riwayat_pesanan', function () {
    return view('Staff_Purchasing/riwayat', [
        'dikirim' => [
            [
                'tanggal' => '2025-11-20',
                'produk' => 'Sayur Kangkung Segar',
                'jumlah' => '2 ikat',
                'ongkir' => 'Rp 5.000',
                'alamat' => 'Jl. Mawar No. 12, Sendawar',
                'gambar' => 'images/kangkung.jpg',
                'supplier' => 'Petani',
                'total_produk' => 1,
                'total_produk_harga' => 15000,
                'metode_pengiriman' => 'pick-up'
            ],
            [
                'tanggal' => '2025-11-19',
                'produk' => 'Beras Kutai Premium 5kg',
                'jumlah' => '1 karung',
                'ongkir' => 'Rp 10.000',
                'alamat' => 'Jl. Melati No. 8, Barong Tongkok',
                'gambar' => 'images/beras.jpg',
                'supplier' => 'Bulog',
                'total_produk' => 3,
                'total_produk_harga' => 75000,
                'metode_pengiriman' => 'diantar'
            ]
        ],
        'selesai' => [
            [
                'tanggal' => '2025-11-18',
                'produk' => 'Telur Ayam Kampung',
                'jumlah' => '1 rak (30 butir)',
                'ongkir' => 'Rp 7.000',
                'alamat' => 'Jl. Sawo No. 22, Linggang Bigung',
                'gambar' => 'images/telur_kampung.jpg',
                'supplier' => 'Peternak',
                'total_produk' => 2,
                'total_produk_harga' => 45000,
                'metode_pengiriman' => 'pick-up'
            ],
            [
                'tanggal' => '2025-11-17',
                'produk' => 'Sayur Bayam Segar',
                'jumlah' => '3 ikat',
                'ongkir' => 'Rp 4.000',
                'alamat' => 'Jl. Kenanga No. 9, Sekolaq Darat',
                'gambar' => 'images/bayam.jpeg',
                'supplier' => 'Petani',
                'total_produk' => 1,
                'total_produk_harga' => 12000,
                'metode_pengiriman' => 'diantar'
            ]
        ],
        'ditolak' => [
            [
                'tanggal' => '2025-11-16',
                'produk' => 'Ikan Gabus Segar',
                'jumlah' => '2 ekor (1kg)',
                'ongkir' => 'Rp 12.000',
                'alamat' => 'Jl. Mawar Putih No. 5, Melak',
                'gambar' => 'images/ikan.jpeg',
                'supplier' => 'Nelayan',
                'total_produk' => 4,
                'total_produk_harga' => 120000,
                'metode_pengiriman' => 'pick-up'
            ],
            [
                'tanggal' => '2025-11-15',
                'produk' => 'Ayam Potong Segar',
                'jumlah' => '1 ekor (1.5kg)',
                'ongkir' => 'Rp 8.000',
                'alamat' => 'Jl. Anggrek No. 15, Tenggarong',
                'gambar' => 'images/ayam.jpg',
                'supplier' => 'Peternak',
                'total_produk' => 2,
                'total_produk_harga' => 60000,
                'metode_pengiriman' => 'diantar'
            ]
        ]
    ]);
});

Route::get('/super_admin/manajemen_kurir', function () {
    return view('Super_Admin/manajemenKurir',[
        'kurir' => [
            [
                'id' => 1,
                'nama_lengkap' => 'Ahmad Santoso',
                'email' => 'ahmad.santoso@email.com',
                'no_telpon' => '081234567890',
                'role' => 'Kurir',
                'kendaraan' => 'Motor',
                'status_online' => 'Aktif',
                'status_antar' => 'Siap',
            ],
            [
                'id' => 2,
                'nama_lengkap' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@email.com',
                'no_telpon' => '081234567891',
                'role' => 'Kurir',
                'kendaraan' => 'Mobil',
                'status_online' => 'Aktif',
                'status_antar' => 'Sedang Antar',
            ],
            [
                'id' => 3,
                'nama_lengkap' => 'Budi Hartono',
                'email' => 'budi.hartono@email.com',
                'no_telpon' => '081234567892',
                'role' => 'Kurir',
                'kendaraan' => 'Motor',
                'status_online' => 'Tidak Aktif',
                'status_antar' => 'Siap',
            ],
            [
                'id' => 4,
                'nama_lengkap' => 'Dewi Sartika',
                'email' => 'dewi.sartika@email.com',
                'no_telpon' => '081234567893',
                'role' => 'Kurir',
                'kendaraan' => 'Motor',
                'status_online' => 'Aktif',
                'status_antar' => 'Siap',
            ],
            [
                'id' => 5,
                'nama_lengkap' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@email.com',
                'no_telpon' => '081234567894',
                'role' => 'Kurir',
                'kendaraan' => 'Mobil',
                'status_online' => 'Aktif',
                'status_antar' => 'Sedang Antar',
            ],
            [
                'id' => 6,
                'nama_lengkap' => 'Fatimah Azzahra',
                'email' => 'fatimah.azzahra@email.com',
                'no_telpon' => '081234567895',
                'role' => 'Kurir',
                'kendaraan' => 'Motor',
                'status_online' => 'Tidak Aktif',
                'status_antar' => 'Siap',
            ],
        ]
    ]);
});

Route::get('/super_admin/laporan', function () {
    return view('Super_Admin/laporan', [
        'penjualan' => [
            [
                'tanggal_transaksi' => '2025-11-15',
                'batch' => 'BATCH-001',
                'nama_produk' => 'Beras Kutai Premium',
                'gambar' => 'images/beras.jpg',
                'jumlah' => 10,
                'harga_satuan' => 50000,
                'total_harga' => 500000,
            ],
            [
                'tanggal_transaksi' => '2025-11-20',
                'batch' => 'BATCH-002',
                'nama_produk' => 'Sayur Pokcoy Segar',
                'gambar' => 'images/pokcoy.jpg',
                'jumlah' => 5,
                'harga_satuan' => 75000,
                'total_harga' => 375000,
            ],
            [
                'tanggal_transaksi' => '2025-12-01',
                'batch' => 'BATCH-003',
                'nama_produk' => 'Telur Ayam Kampung',
                'gambar' => 'images/telur_kampung.jpg',
                'jumlah' => 8,
                'harga_satuan' => 60000,
                'total_harga' => 480000,
            ],
        ],
        'pesanan' => [
            [
                'tanggal_pesanan' => '2025-11-10',
                'nama_pembeli' => 'John Doe',
                'total_item' => 3,
                'total_bayar' => 250000,
                'status_pesanan' => 'Selesai',
                'metode_pengiriman' => 'Diantar',
            ],
            [
                'tanggal_pesanan' => '2025-11-25',
                'nama_pembeli' => 'Jane Smith',
                'total_item' => 2,
                'total_bayar' => 150000,
                'status_pesanan' => 'Dikirim',
                'metode_pengiriman' => 'Pick-up',
            ],
            [
                'tanggal_pesanan' => '2025-12-03',
                'nama_pembeli' => 'Bob Johnson',
                'total_item' => 4,
                'total_bayar' => 400000,
                'status_pesanan' => 'Ditolak',
                'metode_pengiriman' => 'Diantar',
            ],
        ],
        'stok' => [
            [
                'nama_produk' => 'Beras Kutai Premium',
                'gambar' => 'images/beras.jpg',
                'total_batch' => 5,
                'batch_aktif' => 3,
                'sisa_batch' => 2,
                'stok_masuk' => 100,
                'stok_keluar' => 50,
                'sisa_stok' => 50,
                'tanggal_update' => '2025-12-05',
            ],
            [
                'nama_produk' => 'Sayur Pokcoy Segar',
                'gambar' => 'images/pokcoy.jpg',
                'total_batch' => 4,
                'batch_aktif' => 4,
                'sisa_batch' => 0,
                'stok_masuk' => 80,
                'stok_keluar' => 80,
                'sisa_stok' => 0,
                'tanggal_update' => '2025-12-04',
            ],
            [
                'nama_produk' => 'Telur Ayam Kampung',
                'gambar' => 'images/telur_kampung.jpg',
                'total_batch' => 6,
                'batch_aktif' => 2,
                'sisa_batch' => 4,
                'stok_masuk' => 120,
                'stok_keluar' => 30,
                'sisa_stok' => 90,
                'tanggal_update' => '2025-12-05',
            ],
        ],
        'terlaris' => [
            [
                'nama_produk' => 'Beras Kutai Premium',
                'gambar' => 'images/beras.jpg',
                'jumlah_terjual' => 50,
                'total_pendapatan' => 2500000,
                'persentase_penjualan' => 40,
            ],
            [
                'nama_produk' => 'Sayur Pokcoy Segar',
                'gambar' => 'images/pokcoy.jpg',
                'jumlah_terjual' => 30,
                'total_pendapatan' => 2250000,
                'persentase_penjualan' => 30,
            ],
            [
                'nama_produk' => 'Telur Ayam Kampung',
                'gambar' => 'images/telur_kampung.jpg',
                'jumlah_terjual' => 20,
                'total_pendapatan' => 1200000,
                'persentase_penjualan' => 20,
            ],
        ],
    ]);
});
