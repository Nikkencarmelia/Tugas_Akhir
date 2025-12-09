<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

Route::get('/', function () {
    return view('User/landingPage', [
        'kepengurusan' => [
            [
                'gambar' => 'images/gambar_1.jpg',
                'nama' => 'Liam Vandenberg',
                'jabatan' => 'Kepala Dinas',
                'deskripsi' => 'Memimpin dan mengarahkan seluruh kegiatan strategis dinas.',
            ],
            [
                'gambar' => 'images/gambar_2.jpg',
                'nama' => 'Sophia Delacroix',
                'jabatan' => 'Sekretaris',
                'deskripsi' => 'Mengelola dokumen dan koordinasi administrasi internal.',
            ],
            [
                'gambar' => 'images/gambar_3.jpg',
                'nama' => 'Matteo Alvarez',
                'jabatan' => 'Kabid Ketersediaan Pangan',
                'deskripsi' => 'Mengatur ketersediaan logistik pangan secara tepat waktu.',
            ],
            [
                'gambar' => 'images/gambar_4.jpg',
                'nama' => 'Amelia Rothschild',
                'jabatan' => 'Analis Pangan',
                'deskripsi' => 'Menganalisis data untuk perencanaan dan evaluasi pangan.',
            ],
            [
                'gambar' => 'images/gambar_5.jpg',
                'nama' => 'Noah Leclerc',
                'jabatan' => 'Staff IT & Administrasi',
                'deskripsi' => 'Mengelola sistem digital dan data administrasi dinas.',
            ],
            [
                'gambar' => 'images/gambar_6.jpg',
                'nama' => 'Elena Novikova',
                'jabatan' => 'Kabid Konsumsi dan Keamanan Pangan',
                'deskripsi' => 'Menjamin keamanan dan kualitas pangan bagi konsumen.',
            ],
        ],
            'produkUnggul' => [
            [
                'gambar' => 'images/beras.jpg',
                'nama_produk' => 'Beras Kutai Premium',
                'satuan_berat' => '5 kg',
                'harga' => 'Rp 75.000',
            ],
            [
                'gambar' => 'images/pokcoy.jpg',
                'nama_produk' => 'Sayur Pokcoy Segar',
                'satuan_berat' => '250 gram',
                'harga' => 'Rp 4.800',
            ],
            [
                'gambar' => 'images/telur_kampung.jpg',
                'nama_produk' => 'Telur Ayam Kampung',
                'satuan_berat' => '1 kg',
                'harga' => 'Rp 30.000',
            ],
            [
                'gambar' => 'images/ayam.jpg',
                'nama_produk' => 'Ayam Kampung Segar',
                'satuan_berat' => '1 ekor (~1 kg)',
                'harga' => 'Rp 45.000',
            ],
            [
                'gambar' => 'images/madu.jpg',
                'nama_produk' => 'Madu Hutan Asli',
                'satuan_berat' => '250 ml',
                'harga' => 'Rp 40.000',
            ],
            [
                'gambar' => 'images/singkong.jpg',
                'nama_produk' => 'Singkong Organik',
                'satuan_berat' => '2 kg',
                'harga' => 'Rp 12.000',
            ],
            [
                'gambar' => 'images/pisang.jpg',
                'nama_produk' => 'Pisang Kepok Manis',
                'satuan_berat' => '1 sisir',
                'harga' => 'Rp 22.000',
            ],
            [
                'gambar' => 'images/bawang_merah.jpg',
                'nama_produk' => 'Bawang Merah Lokal',
                'satuan_berat' => '250 gr',
                'harga' => 'Rp 18.000',
            ],
            [
                'gambar' => 'images/cabe_rawit.jpg',
                'nama_produk' => 'Cabe Rawit Merah',
                'satuan_berat' => '250 gr',
                'harga' => 'Rp 10.000',
            ],
            [
                'gambar' => 'images/jagung.jpg',
                'nama_produk' => 'Jagung Manis Segar',
                'satuan_berat' => '1 kg',
                'harga' => 'Rp 9.000',
            ],
            [
                'gambar' => 'images/jambu_air.jpg',
                'nama_produk' => 'Jambu Air Merah',
                'satuan_berat' => '1 kg',
                'harga' => 'Rp 15.000',
            ],
            [
                'gambar' => 'images/ubi_ungu.jpg',
                'nama_produk' => 'Ubi Ungu Organik',
                'satuan_berat' => '2 kg',
                'harga' => 'Rp 20.000',
            ],

        ]
    ]);
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/detail_produk', function () {
    return view('User/detailProduk', [
        'produk' => [

                'gambar' => 'images/ubi_ungu.jpg',
                'nama_produk' => 'Ubi Ungu Organik',
                'satuan_berat' => '2 kg',
                'harga' => 'Rp 20.000',
        ]
    ]);
});

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

Route::get('/produk', function () {
    return view('User/produk', [
        'produkTerlaris' => [
            [
                'gambar' => 'images/beras.jpg',
                'nama_produk' => 'Beras Kutai Premium',
                'satuan_berat' => '5 kg',
                'harga' => 'Rp 75.000',
            ],
            [
                'gambar' => 'images/pokcoy.jpg',
                'nama_produk' => 'Sayur Pokcoy Segar',
                'satuan_berat' => '250 gram',
                'harga' => 'Rp 4.800',
            ],
            [
                'gambar' => 'images/telur_kampung.jpg',
                'nama_produk' => 'Telur Ayam Kampung',
                'satuan_berat' => '1 kg',
                'harga' => 'Rp 30.000',
            ],
            [
                'gambar' => 'images/ayam.jpg',
                'nama_produk' => 'Ayam Kampung Segar',
                'satuan_berat' => '1 ekor (~1 kg)',
                'harga' => 'Rp 45.000',
            ],
            [
                'gambar' => 'images/madu.jpg',
                'nama_produk' => 'Madu Hutan Asli',
                'satuan_berat' => '250 ml',
                'harga' => 'Rp 40.000',
            ],
            [
                'gambar' => 'images/singkong.jpg',
                'nama_produk' => 'Singkong Organik',
                'satuan_berat' => '2 kg',
                'harga' => 'Rp 12.000',
            ],
            [
                'gambar' => 'images/pisang.jpg',
                'nama_produk' => 'Pisang Kepok Manis',
                'satuan_berat' => '1 sisir',
                'harga' => 'Rp 22.000',
            ],
            [
                'gambar' => 'images/bawang_merah.jpg',
                'nama_produk' => 'Bawang Merah Lokal',
                'satuan_berat' => '250 gr',
                'harga' => 'Rp 18.000',
            ],
            [
                'gambar' => 'images/cabe_rawit.jpg',
                'nama_produk' => 'Cabe Rawit Merah',
                'satuan_berat' => '250 gr',
                'harga' => 'Rp 10.000',
            ],
            [
                'gambar' => 'images/jagung.jpg',
                'nama_produk' => 'Jagung Manis Segar',
                'satuan_berat' => '1 kg',
                'harga' => 'Rp 9.000',
            ],
            [
                'gambar' => 'images/jambu_air.jpg',
                'nama_produk' => 'Jambu Air Merah',
                'satuan_berat' => '1 kg',
                'harga' => 'Rp 15.000',
            ],
            [
                'gambar' => 'images/ubi_ungu.jpg',
                'nama_produk' => 'Ubi Ungu Organik',
                'satuan_berat' => '2 kg',
                'harga' => 'Rp 20.000',
            ],
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

Route::get('/profil', function () {
    return view('User/profil');
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

Route::get('/dashboard_produk', function () {
    return view('Staff_Produk/dashboard', [
        'produk' => [
            [
        'id' => 'PRD001',
        'gambar' => 'images/beras.jpg',
        'nama_produk' => 'Beras Kutai Premium',
        'deskripsi' => 'Beras berkualitas tinggi dari Kutai, panen terbaru',
        'satuan_berat' => '5 kg',
        'harga' => 'Rp 75.000',
        'stok' => 50,
        'status_stok' => 'tersedia',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Bulog',
    ],
    [
        'id' => 'PRD002',
        'gambar' => 'images/pokcoy.jpg',
        'nama_produk' => 'Sayur Pokcoy Segar',
        'deskripsi' => 'Sayuran segar organik, bebas pestisida',
        'satuan_berat' => '250 gram',
        'harga' => 'Rp 4.800',
        'stok' => 3,
        'status_stok' => 'Menipis',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Petani',
    ],
    [
        'id' => 'PRD003',
        'gambar' => 'images/telur_kampung.jpg',
        'nama_produk' => 'Telur Ayam Kampung',
        'deskripsi' => 'Telur segar dari peternakan lokal, kaya nutrisi',
        'satuan_berat' => '1 kg',
        'harga' => 'Rp 30.000',
        'stok' => 0,
        'status_stok' => 'habis',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Peternak',
    ],
    [
        'id' => 'PRD004',
        'gambar' => 'images/ayam.jpg',
        'nama_produk' => 'Ayam Kampung Segar',
        'deskripsi' => 'Ayam kampung segar, dipotong harian',
        'satuan_berat' => '1 ekor (~1 kg)',
        'harga' => 'Rp 45.000',
        'stok' => 12,
        'status_stok' => 'tersedia',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Peternak',
    ],
    [
        'id' => 'PRD005',
        'gambar' => 'images/madu.jpg',
        'nama_produk' => 'Madu Hutan Asli',
        'deskripsi' => 'Madu alami dari hutan tropis, 100% murni',
        'satuan_berat' => '250 ml',
        'harga' => 'Rp 40.000',
        'stok' => 20,
        'status_stok' => 'tersedia',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Petani',
    ],
        ]
    ]);
});

// Route::get('/data_produk', function () {
//     return view('Staff_Produk/dataProduk', [
//         'produk' => [
//             [
//                 'id' => 'PRD001',
//                 'gambar' => 'images/beras.jpg',
//                 'nama_produk' => 'Beras Kutai Premium',
//                 'deskripsi' => 'Beras kualitas tinggi dari hasil panen lokal.',
//                 'satuan_berat' => '5 kg',
//                 'harga' => 'Rp 75.000',
//                 'stok' => 50,
//                 'status_stok' => 'Tersedia',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier' => 'Bulog',
//                 'kategori' => 'Beras',
//                 'batches' => [
//                     ['id' => 1, 'jumlah' => 100],
//                     ['id' => 2, 'jumlah' => 150],
//                     ['id' => 3, 'jumlah' => 200],
//                 ],
//             ],
//             [
//                 'id' => 'PRD002',
//                 'gambar' => 'images/pokcoy.jpg',
//                 'nama_produk' => 'Sayur Pokcoy Segar',
//                 'deskripsi' => 'Sayuran hijau segar, cocok untuk tumisan.',
//                 'satuan_berat' => '250 gram',
//                 'harga' => 'Rp 4.800',
//                 'stok' => 5,
//                 'status_stok' => 'Menipis',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier' => 'Petani',
//                 'kategori' => 'Sayuran',
//                 'batches' => [
//                     ['id' => 1, 'jumlah' => 50],
//                 ],
//             ],
//             [
//                 'id' => 'PRD003',
//                 'gambar' => 'images/telur_kampung.jpg',
//                 'nama_produk' => 'Telur Ayam Kampung',
//                 'deskripsi' => 'Telur segar dari peternakan lokal.',
//                 'satuan_berat' => '1 kg',
//                 'harga' => 'Rp 30.000',
//                 'stok' => 0,
//                 'status_stok' => 'Habis',
//                 'status_tampil' => 'Diarsipkan',
//                 'supplier' => 'Peternak',
//                 'kategori' => 'Daging',
//                 'batches' => [],
//             ],
//             [
//                 'id' => 'PRD004',
//                 'gambar' => 'images/cabe_rawit.jpg',
//                 'nama_produk' => 'Cabai Merah Lokal',
//                 'deskripsi' => 'Cabai merah pedas pilihan dari petani lokal.',
//                 'satuan_berat' => '250 gram',
//                 'harga' => 'Rp 10.000',
//                 'stok' => 20,
//                 'status_stok' => 'Tersedia',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier' => 'Petani',
//                 'kategori' => 'Sayuran',
//                 'batches' => [
//                     ['id' => 1, 'jumlah' => 100],
//                     ['id' => 2, 'jumlah' => 150],
//                     ['id' => 3, 'jumlah' => 200],
//                     ['id' => 4, 'jumlah' => 250],
//                 ],
//             ],
//             [
//                 'id' => 'PRD005',
//                 'gambar' => 'images/bawang_merah.jpg',
//                 'nama_produk' => 'Bawang Merah',
//                 'deskripsi' => 'Bumbu dapur segar hasil petani lokal.',
//                 'satuan_berat' => '500 gram',
//                 'harga' => 'Rp 15.000',
//                 'stok' => 8,
//                 'status_stok' => 'Menipis',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier' => 'Petani',
//                 'kategori' => 'Sayuran',
//                 'batches' => [
//                     ['id' => 1, 'jumlah' => 30],
//                     ['id' => 2, 'jumlah' => 40],
//                 ],
//             ],
//             [
//                 'id' => 'PRD006',
//                 'gambar' => 'images/ayam.jpg',
//                 'nama_produk' => 'Daging Ayam Potong',
//                 'deskripsi' => 'Daging ayam segar siap olah.',
//                 'satuan_berat' => '1 kg',
//                 'harga' => 'Rp 38.000',
//                 'stok' => 15,
//                 'status_stok' => 'Tersedia',
//                 'status_tampil' => 'Diarsipkan',
//                 'supplier' => 'Peternak',
//                 'kategori' => 'Daging',
//                 'batches' => [
//                     ['id' => 1, 'jumlah' => 60],
//                 ],
//             ],
//             [
//                 'id' => 'PRD007',
//                 'gambar' => 'images/lele.jpeg',
//                 'nama_produk' => 'Ikan Lele Segar',
//                 'deskripsi' => 'Ikan lele hasil budidaya air tawar.',
//                 'satuan_berat' => '1 kg',
//                 'harga' => 'Rp 28.000',
//                 'stok' => 3,
//                 'status_stok' => 'Menipis',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier' => 'Peternak',
//                 'kategori' => 'Daging',
//                 'batches' => [],
//             ],
//             [
//                 'id' => 'PRD008',
//                 'gambar' => 'images/kangkung.jpg',
//                 'nama_produk' => 'Kangkung Organik',
//                 'deskripsi' => 'Sayur kangkung segar bebas pestisida.',
//                 'satuan_berat' => '250 gram',
//                 'harga' => 'Rp 3.500',
//                 'stok' => 0,
//                 'status_stok' => 'Habis',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier' => 'Petani',
//                 'kategori' => 'Sayuran',
//                 'batches' => [
//                     ['id' => 1, 'jumlah' => 20],
//                 ],
//             ],
//             [
//                 'id' => 'PRD009',
//                 'gambar' => 'images/tahu.jpeg',
//                 'nama_produk' => 'Tahu Putih Segar',
//                 'deskripsi' => 'Tahu lembut produksi harian.',
//                 'satuan_berat' => '10 pcs',
//                 'harga' => 'Rp 8.000',
//                 'stok' => 25,
//                 'status_stok' => 'Tersedia',
//                 'status_tampil' => 'Diarsipkan',
//                 'supplier' => 'Petani',
//                 'kategori' => 'Sayuran',
//                 'batches' => [
//                     ['id' => 1, 'jumlah' => 100],
//                     ['id' => 2, 'jumlah' => 120],
//                 ],
//             ],
//             [
//                 'id' => 'PRD010',
//                 'gambar' => 'images/tempe.jpg',
//                 'nama_produk' => 'Tempe Daun Segar',
//                 'deskripsi' => 'Tempe fermentasi alami, dibungkus daun.',
//                 'satuan_berat' => '10 pcs',
//                 'harga' => 'Rp 6.000',
//                 'stok' => 12,
//                 'status_stok' => 'Tersedia',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier' => 'Petani',
//                 'kategori' => 'Sayuran',
//                 'batches' => [],
//             ],
//             [
//                 'id' => 'PRD011',
//                 'gambar' => 'images/gula_aren.jpg',
//                 'nama_produk' => 'Gula Merah Asli',
//                 'deskripsi' => 'Gula merah murni dari nira kelapa.',
//                 'satuan_berat' => '500 gram',
//                 'harga' => 'Rp 12.000',
//                 'stok' => 7,
//                 'status_stok' => 'Menipis',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier' => 'Petani',
//                 'kategori' => 'Buah',
//                 'batches' => [
//                     ['id' => 1, 'jumlah' => 50],
//                     ['id' => 2, 'jumlah' => 70],
//                 ],
//             ],
//             [
//                 'id' => 'PRD012',
//                 'gambar' => 'images/susu.jpeg',
//                 'nama_produk' => 'Susu Sapi Segar',
//                 'deskripsi' => 'Susu sapi murni tanpa pengawet.',
//                 'satuan_berat' => '1 liter',
//                 'harga' => 'Rp 18.000',
//                 'stok' => 30,
//                 'status_stok' => 'Tersedia',
//                 'status_tampil' => 'Diarsipkan',
//                 'supplier' => 'Peternak',
//                 'kategori' => 'Daging',
//                 'batches' => [
//                     ['id' => 1, 'jumlah' => 80],
//                 ],
//             ],
//         ],
//     ]);
// });


// Route::get('/tambah_produk', function () {
//     return view('Staff_Produk/tambahProduk');
// });

Route::get('/batch_stok', function () {
    return view('Staff_Produk/batchStok', [
        'batches' => [
            [
                'id' => 1,
                'tanggal_masuk' => '2025-11-01',
                'tanggal_kadaluarsa' => '2026-01-01', // 67 hari lagi
                'jumlah' => 20,
                'harga_normal' => 'Rp 75.000',
                'diskon' => 0,
                'harga_saat_ini' => 'Rp 75.000', // normal
                'tanggal_perubahan_harga' => '2025-11-01',
            ],
            [
                'id' => 2,
                'tanggal_masuk' => '2025-11-03',
                'tanggal_kadaluarsa' => '2025-12-15', // 20 hari lagi
                'jumlah' => 15,
                'harga_normal' => 'Rp 75.000',
                'diskon' => 5,
                'harga_saat_ini' => 'Rp 71.250', // diskon
                'tanggal_perubahan_harga' => '2025-11-10',
            ],
            [
                'id' => 3,
                'tanggal_masuk' => '2025-11-05',
                'tanggal_kadaluarsa' => '2026-02-05', // 72 hari lagi
                'jumlah' => 10,
                'harga_normal' => 'Rp 75.000',
                'diskon' => 0,
                'harga_saat_ini' => 'Rp 82.000', // NAIK
                'tanggal_perubahan_harga' => '2025-11-15',
            ],
            [
                'id' => 4,
                'tanggal_masuk' => '2025-11-07',
                'tanggal_kadaluarsa' => '2025-12-10', // 15 hari lagi
                'jumlah' => 25,
                'harga_normal' => 'Rp 78.000',
                'diskon' => 10,
                'harga_saat_ini' => 'Rp 70.200', // diskon
                'tanggal_perubahan_harga' => '2025-11-12',
            ],
            [
                'id' => 5,
                'tanggal_masuk' => '2025-11-09',
                'tanggal_kadaluarsa' => '2026-01-09', // 75 hari lagi
                'jumlah' => 30,
                'harga_normal' => 'Rp 75.000',
                'diskon' => 0,
                'harga_saat_ini' => 'Rp 75.000', // normal
                'tanggal_perubahan_harga' => '2025-11-09',
            ],
            [
                'id' => 6,
                'tanggal_masuk' => '2025-11-11',
                'tanggal_kadaluarsa' => '2025-12-05', // 10 hari lagi
                'jumlah' => 18,
                'harga_normal' => 'Rp 77.000',
                'diskon' => 3,
                'harga_saat_ini' => 'Rp 74.690', // diskon
                'tanggal_perubahan_harga' => '2025-11-18',
            ],
            [
                'id' => 7,
                'tanggal_masuk' => '2025-11-12',
                'tanggal_kadaluarsa' => '2026-02-12', // 79 hari lagi
                'jumlah' => 22,
                'harga_normal' => 'Rp 75.000',
                'diskon' => 0,
                'harga_saat_ini' => 'Rp 80.000', // NAIK
                'tanggal_perubahan_harga' => '2025-11-20',
            ],
            [
                'id' => 8,
                'tanggal_masuk' => '2025-11-13',
                'tanggal_kadaluarsa' => '2025-12-02', // 7 hari lagi
                'jumlah' => 12,
                'harga_normal' => 'Rp 79.500',
                'diskon' => 7,
                'harga_saat_ini' => 'Rp 73.935', // diskon
                'tanggal_perubahan_harga' => '2025-11-22',
            ],
            [
                'id' => 9,
                'tanggal_masuk' => '2025-11-14',
                'tanggal_kadaluarsa' => '2026-01-14', // 80 hari lagi
                'jumlah' => 28,
                'harga_normal' => 'Rp 75.000',
                'diskon' => 0,
                'harga_saat_ini' => 'Rp 75.000', // normal
                'tanggal_perubahan_harga' => '2025-11-14',
            ],
            [
                'id' => 10,
                'tanggal_masuk' => '2025-10-30',
                'tanggal_kadaluarsa' => '2025-11-15', // -10 hari lalu
                'jumlah' => 16,
                'harga_normal' => 'Rp 76.000',
                'diskon' => 2,
                'harga_saat_ini' => 'Rp 74.480', // diskon
                'tanggal_perubahan_harga' => '2025-11-05',
            ],
            [
                'id' => 11,
                'tanggal_masuk' => '2025-10-28',
                'tanggal_kadaluarsa' => '2026-01-28', // 64 hari lagi
                'jumlah' => 35,
                'harga_normal' => 'Rp 75.000',
                'diskon' => 0,
                'harga_saat_ini' => 'Rp 79.000', // NAIK
                'tanggal_perubahan_harga' => '2025-11-01',
            ],
            [
                'id' => 12,
                'tanggal_masuk' => '2025-10-25',
                'tanggal_kadaluarsa' => '2025-11-10', // -15 hari lalu
                'jumlah' => 20,
                'harga_normal' => 'Rp 77.500',
                'diskon' => 5,
                'harga_saat_ini' => 'Rp 73.625', // diskon
                'tanggal_perubahan_harga' => '2025-11-08',
            ],
            [
                'id' => 13,
                'tanggal_masuk' => '2025-10-20',
                'tanggal_kadaluarsa' => '2026-01-20', // 56 hari lagi
                'jumlah' => 14,
                'harga_normal' => 'Rp 75.000',
                'diskon' => 0,
                'harga_saat_ini' => 'Rp 75.000', // normal
                'tanggal_perubahan_harga' => '2025-10-20',
            ],
            [
                'id' => 14,
                'tanggal_masuk' => '2025-10-15',
                'tanggal_kadaluarsa' => '2025-11-26', // 1 hari lagi
                'jumlah' => 26,
                'harga_normal' => 'Rp 78.250',
                'diskon' => 8,
                'harga_saat_ini' => 'Rp 71.190', // diskon
                'tanggal_perubahan_harga' => '2025-11-20',
            ],
            [
                'id' => 15,
                'tanggal_masuk' => '2025-10-10',
                'tanggal_kadaluarsa' => '2026-02-10', // 77 hari lagi
                'jumlah' => 19,
                'harga_normal' => 'Rp 75.000',
                'diskon' => 0,
                'harga_saat_ini' => 'Rp 83.000', // NAIK
                'tanggal_perubahan_harga' => '2025-11-15',
            ],
        ],

        'produk' => [
            'id' => 'PRD001',
            'gambar' => 'images/beras.jpg',
            'nama_produk' => 'Beras Kutai Premium',
            'deskripsi' => 'Beras kualitas tinggi dari hasil panen lokal.',
            'satuan_berat' => '5 kg',
            'harga' => 'Rp 75.000',
            'stok' => 50,
            'status_stok' => 'Tersedia',
            'status_tampil' => 'Ditampilkan',
            'supplier' => 'Bulog',
            'kategori' => 'Beras',
        ]
    ]);
});

Route::get('/detail_diskon', function () {
    return view('Staff_Produk/detailDiskon', [
        'batches' => [
    [
        'id'                 => 2,
        'tanggal_diskon'     => '2025-11-03',
        'tanggal_masuk'      => '2025-08-15',
        'tanggal_kadaluarsa' => '2025-12-20',   // 25 hari lagi → Masih Lama
        'harga_normal'       => 'Rp 75.000',
        'harga_diskon'       => 'Rp 71.250',
        'diskon'             => 5,
        'jumlah'             => 0,              // HABIS
    ],
    [
        'id'                 => 4,
        'tanggal_diskon'     => '2025-11-07',
        'tanggal_masuk'      => '2025-08-20',
        'tanggal_kadaluarsa' => '2025-12-10',   // 15 hari lagi → Masih Lama
        'harga_normal'       => 'Rp 78.000',
        'harga_diskon'       => 'Rp 70.200',
        'diskon'             => 10,
        'jumlah'             => 0,              // HABIS
    ],
    [
        'id'                 => 6,
        'tanggal_diskon'     => '2025-11-11',
        'tanggal_masuk'      => '2025-09-01',
        'tanggal_kadaluarsa' => '2025-12-05',   // 10 hari lagi → Masih Lama
        'harga_normal'       => 'Rp 77.000',
        'harga_diskon'       => 'Rp 74.690',
        'diskon'             => 3,
        'jumlah'             => 0,              // HABIS
    ],
    [
        'id'                 => 8,
        'tanggal_diskon'     => '2025-11-13',
        'tanggal_masuk'      => '2025-09-10',
        'tanggal_kadaluarsa' => '2025-12-02',   // 7 hari lagi → Sebentar Lagi
        'harga_normal'       => 'Rp 79.500',
        'harga_diskon'       => 'Rp 73.935',
        'diskon'             => 7,
        'jumlah'             => 5,              // MENIPIS (satu-satunya!)
    ],
    [
        'id'                 => 10,
        'tanggal_diskon'     => '2025-10-30',
        'tanggal_masuk'      => '2025-07-25',
        'tanggal_kadaluarsa' => '2025-11-15',   // 10 hari lalu → Sudah Kadaluarsa
        'harga_normal'       => 'Rp 76.000',
        'harga_diskon'       => 'Rp 74.480',
        'diskon'             => 2,
        'jumlah'             => 0,              // HABIS
    ],
    [
        'id'                 => 12,
        'tanggal_diskon'     => '2025-10-25',
        'tanggal_masuk'      => '2025-07-10',
        'tanggal_kadaluarsa' => '2025-11-10',   // 15 hari lalu → Sudah Kadaluarsa
        'harga_normal'       => 'Rp 77.500',
        'harga_diskon'       => 'Rp 73.625',
        'diskon'             => 5,
        'jumlah'             => 0,              // HABIS
    ],
    [
        'id'                 => 14,
        'tanggal_diskon'     => '2025-10-15',
        'tanggal_masuk'      => '2025-06-20',
        'tanggal_kadaluarsa' => '2025-11-26',   // Besok expired → Sebentar Lagi (1 hari lagi)
        'harga_normal'       => 'Rp 78.250',
        'harga_diskon'       => 'Rp 71.190',
        'diskon'             => 8,
        'jumlah'             => 0,              // HABIS
    ],
    [
        'id'                 => 17,
        'tanggal_diskon'     => '2025-11-18',
        'tanggal_masuk'      => '2025-10-01',
        'tanggal_kadaluarsa' => '2026-05-10',   // Masih 166 hari → Masih Lama
        'harga_normal'       => 'Rp 75.000',
        'harga_diskon'       => 'Rp 67.500',
        'diskon'             => 10,
        'jumlah'             => 42,             // Tersedia (satu-satunya yang banyak!)
    ],
    [
        'id'                 => 19,
        'tanggal_diskon'     => '2025-11-20',
        'tanggal_masuk'      => '2025-10-10',
        'tanggal_kadaluarsa' => '2025-12-30',   // 35 hari lagi → Masih Lama
        'harga_normal'       => 'Rp 80.000',
        'harga_diskon'       => 'Rp 68.000',
        'diskon'             => 15,
        'jumlah'             => 0,              // HABIS
    ],
    [
        'id'                 => 21,
        'tanggal_diskon'     => '2025-11-22',
        'tanggal_masuk'      => '2025-10-15',
        'tanggal_kadaluarsa' => '2025-12-15',   // 20 hari lagi → Masih Lama
        'harga_normal'       => 'Rp 76.500',
        'harga_diskon'       => 'Rp 68.850',
        'diskon'             => 10,
        'jumlah'             => 0,              // HABIS
    ],
        ],

        'produk' => [
            'id' => 'PRD001',
            'gambar' => 'images/beras.jpg',
            'nama_produk' => 'Beras Kutai Premium',
            'deskripsi' => 'Beras kualitas tinggi dari hasil panen lokal.',
            'satuan_berat' => '5 kg',
            'harga' => 'Rp 75.000',
            'stok' => 50,
            'status_stok' => 'Tersedia',
            'status_tampil' => 'Ditampilkan',
            'supplier' => 'Bulog',
            'kategori' => 'Beras',
        ]
    ]);
});


Route::prefix('staff_produk')->name('produk.')->group(function () {
    Route::get('/dashboard', [ProdukController::class, 'dashboardProduk'])->name('dashboard');
    Route::get('/data', [ProdukController::class, 'dataProduk'])->name('data');
    Route::get('/diskon', [ProdukController::class, 'diskonProduk'])->name('diskon');
    Route::get('/stok', [ProdukController::class, 'kelolaStok'])->name('stok');
    Route::get('/arsip', [ProdukController::class, 'arsipProduk'])->name('arsip');
    Route::get('/rusak', [ProdukController::class, 'rusakCacat'])->name('rusak');

    //CRUD
    Route::get('/tambah', [ProdukController::class, 'tambahProduk'])->name('tambah');
    Route::post('/store', [ProdukController::class, 'storeProduk'])->name('store');

    Route::get('/edit_produk/{id}', [ProdukController::class, 'edit'])->name('edit');
    Route::put('/update_produk/{id}', [ProdukController::class, 'update'])->name('update');

    Route::delete('/delete/{id}', [ProdukController::class, 'destroy'])->name('delete');
});


// Route::get('/diskon_produk', function () {
//     return view('Staff_Produk/diskonProduk', [   // pastikan nama view-nya sesuai
//         'produk' => [
//             [
//                 'id'            => 'PRD001',
//                 'gambar'        => 'images/beras.jpg',
//                 'nama_produk'   => 'Beras Kutai Premium',
//                 'deskripsi'     => 'Beras kualitas tinggi dari hasil panen lokal.',
//                 'satuan_berat'  => '5 kg',
//                 'harga'         => 'Rp 75.000',           // harga normal (tetap ditampilkan di detail)
//                 'diskon_persen' => 20,                    // DISKON 20%
//                 'harga_diskon'  => 'Rp 60.000',           // harga setelah diskon
//                 'stok'          => 50,
//                 'status_stok'   => 'Tersedia',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier'      => 'Bulog',
//                 'kategori'      => 'Beras',
//                 'batches'       => [
//                     ['id' => 1, 'jumlah' => 100],
//                     ['id' => 2, 'jumlah' => 150],
//                 ],
//             ],
//             [
//                 'id'            => 'PRD002',
//                 'gambar'        => 'images/pokcoy.jpg',
//                 'nama_produk'   => 'Sayur Pokcoy Segar',
//                 'deskripsi'     => 'Sayuran hijau segar, cocok untuk tumisan.',
//                 'satuan_berat'  => '250 gram',
//                 'harga'         => 'Rp 4.800',
//                 'diskon_persen' => 15,
//                 'harga_diskon'  => 'Rp 4.080',
//                 'stok'          => 5,
//                 'status_stok'   => 'Menipis',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier'      => 'Petani',
//                 'kategori'      => 'Sayuran',
//                 'batches'       => [['id' => 1, 'jumlah' => 50]],
//             ],
//             [
//                 'id'            => 'PRD003',
//                 'gambar'        => 'images/telur_kampung.jpg',
//                 'nama_produk'   => 'Telur Ayam Kampung',
//                 'deskripsi'     => 'Telur segar dari peternakan lokal.',
//                 'satuan_berat'  => '1 kg',
//                 'harga'         => 'Rp 30.000',
//                 'diskon_persen' => 0,                     // tidak ada diskon
//                 'harga_diskon'  => null,
//                 'stok'          => 0,
//                 'status_stok'   => 'Habis',
//                 'status_tampil' => 'Diarsipkan',
//                 'supplier'      => 'Peternak',
//                 'kategori'      => 'Daging',
//                 'batches'       => [],
//             ],
//             [
//                 'id'            => 'PRD004',
//                 'gambar'        => 'images/cabe_rawit.jpg',
//                 'nama_produk'   => 'Cabai Merah Lokal',
//                 'deskripsi'     => 'Cabai merah pedas pilihan dari petani lokal.',
//                 'satuan_berat'  => '250 gram',
//                 'harga'         => 'Rp 10.000',
//                 'diskon_persen' => 30,
//                 'harga_diskon'  => 'Rp 7.000',
//                 'stok'          => 20,
//                 'status_stok'   => 'Tersedia',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier'      => 'Petani',
//                 'kategori'      => 'Sayuran',
//                 'batches'       => [
//                     ['id' => 1, 'jumlah' => 100],
//                     ['id' => 2, 'jumlah' => 150],
//                 ],
//             ],
//             [
//                 'id'            => 'PRD005',
//                 'gambar'        => 'images/bawang_merah.jpg',
//                 'nama_produk'   => 'Bawang Merah',
//                 'deskripsi'     => 'Bumbu dapur segar hasil petani lokal.',
//                 'satuan_berat'  => '500 gram',
//                 'harga'         => 'Rp 15.000',
//                 'diskon_persen' => 10,
//                 'harga_diskon'  => 'Rp 13.500',
//                 'stok'          => 8,
//                 'status_stok'   => 'Menipis',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier'      => 'Petani',
//                 'kategori'      => 'Sayuran',
//                 'batches'       => [['id' => 1, 'jumlah' => 30]],
//             ],
//             [
//                 'id'            => 'PRD006',
//                 'gambar'        => 'images/ayam.jpg',
//                 'nama_produk'   => 'Daging Ayam Potong',
//                 'deskripsi'     => 'Daging ayam segar siap olah.',
//                 'satuan_berat'  => '1 kg',
//                 'harga'         => 'Rp 38.000',
//                 'diskon_persen' => 25,
//                 'harga_diskon'  => 'Rp 28.500',
//                 'stok'          => 15,
//                 'status_stok'   => 'Tersedia',
//                 'status_tampil' => 'Diarsipkan',
//                 'supplier'      => 'Peternak',
//                 'kategori'      => 'Daging',
//                 'batches'       => [['id' => 1, 'jumlah' => 60]],
//             ],
//             [
//                 'id'            => 'PRD007',
//                 'gambar'        => 'images/lele.jpeg',
//                 'nama_produk'   => 'Ikan Lele Segar',
//                 'deskripsi'     => 'Ikan lele hasil budidaya air tawar.',
//                 'satuan_berat'  => '1 kg',
//                 'harga'         => 'Rp 28.000',
//                 'diskon_persen' => 0,
//                 'harga_diskon'  => null,
//                 'stok'          => 3,
//                 'status_stok'   => 'Menipis',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier'      => 'Peternak',
//                 'kategori'      => 'Daging',
//                 'batches'       => [],
//             ],
//             [
//                 'id'            => 'PRD008',
//                 'gambar'        => 'images/kangkung.jpg',
//                 'nama_produk'   => 'Kangkung Organik',
//                 'deskripsi'     => 'Sayur kangkung segar bebas pestisida.',
//                 'satuan_berat'  => '250 gram',
//                 'harga'         => 'Rp 3.500',
//                 'diskon_persen' => 40,
//                 'harga_diskon'  => 'Rp 2.100',
//                 'stok'          => 0,
//                 'status_stok'   => 'Habis',
//                 'status_tampil' => 'Ditampilkan',
//                 'supplier'      => 'Petani',
//                 'kategori'      => 'Sayuran',
//                 'batches'       => [['id' => 1, 'jumlah' => 20]],
//             ],
//         ]
//     ]);
// });


// Route::get('/arsip_produk', function () {
//     return view('Staff_Produk/arsipProduk', [
//         'produk' => [
//     [
//         'id' => 'PRD001',
//         'gambar' => 'images/beras.jpg',
//         'nama_produk' => 'Beras Kutai Premium',
//         'deskripsi' => 'Beras kualitas tinggi dari hasil panen lokal.',
//         'satuan_berat' => '5 kg',
//         'harga' => 'Rp 75.000',
//         'stok' => 3,
//         'status_stok' => 'Menipis',
//         'status_tampil' => 'Diarsipkan',
//         'supplier' => 'Bulog',
//         'kategori' => 'Makanan Pokok',
//     ],
//     [
//         'id' => 'PRD002',
//         'gambar' => 'images/pokcoy.jpg',
//         'nama_produk' => 'Sayur Pokcoy Segar',
//         'deskripsi' => 'Sayuran hijau segar, cocok untuk tumisan.',
//         'satuan_berat' => '250 gram',
//         'harga' => 'Rp 4.800',
//         'stok' => 2,
//         'status_stok' => 'Menipis',
//         'status_tampil' => 'Diarsipkan',
//         'supplier' => 'Petani',
//         'kategori' => 'Sayuran',
//     ],
//     [
//         'id' => 'PRD003',
//         'gambar' => 'images/telur_kampung.jpg',
//         'nama_produk' => 'Telur Ayam Kampung',
//         'deskripsi' => 'Telur segar dari peternakan lokal.',
//         'satuan_berat' => '1 kg',
//         'harga' => 'Rp 30.000',
//         'stok' => 0,
//         'status_stok' => 'Habis',
//         'status_tampil' => 'Diarsipkan',
//         'supplier' => 'Peternak',
//         'kategori' => 'Telur',
//     ],
//     [
//         'id' => 'PRD004',
//         'gambar' => 'images/cabe_rawit.jpg',
//         'nama_produk' => 'Cabai Merah Lokal',
//         'deskripsi' => 'Cabai merah pedas pilihan dari petani lokal.',
//         'satuan_berat' => '250 gram',
//         'harga' => 'Rp 10.000',
//         'stok' => 4,
//         'status_stok' => 'Menipis',
//         'status_tampil' => 'Diarsipkan',
//         'supplier' => 'Petani',
//         'kategori' => 'Bumbu',
//     ],
//     [
//         'id' => 'PRD005',
//         'gambar' => 'images/bawang_merah.jpg',
//         'nama_produk' => 'Bawang Merah',
//         'deskripsi' => 'Bumbu dapur segar hasil petani lokal.',
//         'satuan_berat' => '500 gram',
//         'harga' => 'Rp 15.000',
//         'stok' => 5,
//         'status_stok' => 'Menipis',
//         'status_tampil' => 'Diarsipkan',
//         'supplier' => 'Petani',
//         'kategori' => 'Bumbu',
//     ],
//     [
//         'id' => 'PRD006',
//         'gambar' => 'images/ayam.jpg',
//         'nama_produk' => 'Daging Ayam Potong',
//         'deskripsi' => 'Daging ayam segar siap olah.',
//         'satuan_berat' => '1 kg',
//         'harga' => 'Rp 38.000',
//         'stok' => 1,
//         'status_stok' => 'Menipis',
//         'status_tampil' => 'Diarsipkan',
//         'supplier' => 'Peternak',
//         'kategori' => 'Daging',
//     ],
//     [
//         'id' => 'PRD007',
//         'gambar' => 'images/lele.jpeg',
//         'nama_produk' => 'Ikan Lele Segar',
//         'deskripsi' => 'Ikan lele hasil budidaya air tawar.',
//         'satuan_berat' => '1 kg',
//         'harga' => 'Rp 28.000',
//         'stok' => 0,
//         'status_stok' => 'Habis',
//         'status_tampil' => 'Diarsipkan',
//         'supplier' => 'Peternak',
//         'kategori' => 'Ikan',
//     ],
//     [
//         'id' => 'PRD008',
//         'gambar' => 'images/kangkung.jpg',
//         'nama_produk' => 'Kangkung Organik',
//         'deskripsi' => 'Sayur kangkung segar bebas pestisida.',
//         'satuan_berat' => '250 gram',
//         'harga' => 'Rp 3.500',
//         'stok' => 2,
//         'status_stok' => 'Menipis',
//         'status_tampil' => 'Diarsipkan',
//         'supplier' => 'Petani',
//         'kategori' => 'Sayuran',
//     ],
//     [
//         'id' => 'PRD009',
//         'gambar' => 'images/tahu.jpeg',
//         'nama_produk' => 'Tahu Putih Segar',
//         'deskripsi' => 'Tahu lembut produksi harian.',
//         'satuan_berat' => '10 pcs',
//         'harga' => 'Rp 8.000',
//         'stok' => 4,
//         'status_stok' => 'Menipis',
//         'status_tampil' => 'Diarsipkan',
//         'supplier' => 'Petani',
//         'kategori' => 'Protein Nabati',
//     ],
//     [
//         'id' => 'PRD010',
//         'gambar' => 'images/tempe.jpg',
//         'nama_produk' => 'Tempe Daun Segar',
//         'deskripsi' => 'Tempe fermentasi alami, dibungkus daun.',
//         'satuan_berat' => '10 pcs',
//         'harga' => 'Rp 6.000',
//         'stok' => 0,
//         'status_stok' => 'Habis',
//         'status_tampil' => 'Diarsipkan',
//         'supplier' => 'Petani',
//         'kategori' => 'Protein Nabati',
//     ],
//     [
//         'id' => 'PRD011',
//         'gambar' => 'images/gula_aren.jpg',
//         'nama_produk' => 'Gula Merah Asli',
//         'deskripsi' => 'Gula merah murni dari nira kelapa.',
//         'satuan_berat' => '500 gram',
//         'harga' => 'Rp 12.000',
//         'stok' => 5,
//         'status_stok' => 'Menipis',
//         'status_tampil' => 'Diarsipkan',
//         'supplier' => 'Petani',
//         'kategori' => 'Pemanis',
//     ],
//     [
//         'id' => 'PRD012',
//         'gambar' => 'images/susu.jpeg',
//         'nama_produk' => 'Susu Sapi Segar',
//         'deskripsi' => 'Susu sapi murni tanpa pengawet.',
//         'satuan_berat' => '1 liter',
//         'harga' => 'Rp 18.000',
//         'stok' => 1,
//         'status_stok' => 'Menipis',
//         'status_tampil' => 'Diarsipkan',
//         'supplier' => 'Peternak',
//         'kategori' => 'Susu',
//     ],
// ],
//     ]);
// });

Route::get('/produk_rusak', function () {
    return view('Staff_Produk/rusakCacat', [
        'produk' => [
    [
        'id' => 'PRD001',
        'gambar' => 'images/beras.jpg',
        'nama_produk' => 'Beras Kutai Premium',
        'deskripsi' => 'Beras kualitas tinggi dari hasil panen lokal.',
        'satuan_berat' => '5 kg',
        'harga' => 'Rp 75.000',
        'stok' => 50,
        'status_stok' => 'Tersedia',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Bulog',
        'kategori' => 'Beras',
        'batches' => [
            ['id' => 1, 'jumlah' => 100],
            ['id' => 2, 'jumlah' => 150],
            ['id' => 3, 'jumlah' => 200],
        ],
        'damaged_batches' => [
            [
                'batch_id' => 1,
                'tanggal_masuk' => '2025-10-15',
                'jumlah_rusak' => 15,
                'harga_normal' => 'Rp 75.000',
                'harga_saat_ini' => 'Rp 50.000',
                'keterangan' => 'Rusak karena kelembaban tinggi',
                'status' => 'Menunggu Konfirmasi',
                'bukti_foto' => 'images/beras_rusak.jpg'
            ]
        ],
    ],
    [
        'id' => 'PRD002',
        'gambar' => 'images/pokcoy.jpg',
        'nama_produk' => 'Sayur Pokcoy Segar',
        'deskripsi' => 'Sayuran hijau segar, cocok untuk tumisan.',
        'satuan_berat' => '250 gram',
        'harga' => 'Rp 4.800',
        'stok' => 5,
        'status_stok' => 'Menipis',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Petani',
        'kategori' => 'Sayuran',
        'batches' => [
            ['id' => 1, 'jumlah' => 50],
        ],
        'damaged_batches' => [],
    ],
    [
        'id' => 'PRD003',
        'gambar' => 'images/telur_kampung.jpg',
        'nama_produk' => 'Telur Ayam Kampung',
        'deskripsi' => 'Telur segar dari peternakan lokal.',
        'satuan_berat' => '1 kg',
        'harga' => 'Rp 30.000',
        'stok' => 0,
        'status_stok' => 'Habis',
        'status_tampil' => 'Diarsipkan',
        'supplier' => 'Peternak',
        'kategori' => 'Daging',
        'batches' => [],
        'damaged_batches' => [
            [
                'batch_id' => 1,
                'tanggal_masuk' => '2025-11-01',
                'jumlah_rusak' => 8,
                'harga_normal' => 'Rp 30.000',
                'harga_saat_ini' => 'Rp 20.000',
                'keterangan' => 'Retak karena transportasi',
                'status' => 'Dikonfirmasi',
                'bukti_foto' => 'images/telur_rusak.jpg'
            ]
        ],
    ],
    [
        'id' => 'PRD004',
        'gambar' => 'images/cabe_rawit.jpg',
        'nama_produk' => 'Cabai Merah Lokal',
        'deskripsi' => 'Cabai merah pedas pilihan dari petani lokal.',
        'satuan_berat' => '250 gram',
        'harga' => 'Rp 10.000',
        'stok' => 20,
        'status_stok' => 'Tersedia',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Petani',
        'kategori' => 'Sayuran',
        'batches' => [
            ['id' => 1, 'jumlah' => 100],
            ['id' => 2, 'jumlah' => 150],
            ['id' => 3, 'jumlah' => 200],
            ['id' => 4, 'jumlah' => 250],
        ],
        'damaged_batches' => [],
    ],
    [
        'id' => 'PRD005',
        'gambar' => 'images/bawang_merah.jpg',
        'nama_produk' => 'Bawang Merah',
        'deskripsi' => 'Bumbu dapur segar hasil petani lokal.',
        'satuan_berat' => '500 gram',
        'harga' => 'Rp 15.000',
        'stok' => 8,
        'status_stok' => 'Menipis',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Petani',
        'kategori' => 'Sayuran',
        'batches' => [
            ['id' => 1, 'jumlah' => 30],
            ['id' => 2, 'jumlah' => 40],
        ],
        'damaged_batches' => [
            [
                'batch_id' => 2,
                'tanggal_masuk' => '2025-10-20',
                'jumlah_rusak' => 5,
                'harga_normal' => 'Rp 15.000',
                'harga_saat_ini' => 'Rp 10.000',
                'keterangan' => 'Busuk akibat suhu tinggi',
                'status' => 'Menunggu Konfirmasi',
                'bukti_foto' => 'images/bawang_rusak.jpg'
            ]
        ],
    ],
    [
        'id' => 'PRD006',
        'gambar' => 'images/ayam.jpg',
        'nama_produk' => 'Daging Ayam Potong',
        'deskripsi' => 'Daging ayam segar siap olah.',
        'satuan_berat' => '1 kg',
        'harga' => 'Rp 38.000',
        'stok' => 15,
        'status_stok' => 'Tersedia',
        'status_tampil' => 'Diarsipkan',
        'supplier' => 'Peternak',
        'kategori' => 'Daging',
        'batches' => [
            ['id' => 1, 'jumlah' => 60],
        ],
        'damaged_batches' => [],
    ],
    [
        'id' => 'PRD007',
        'gambar' => 'images/lele.jpeg',
        'nama_produk' => 'Ikan Lele Segar',
        'deskripsi' => 'Ikan lele hasil budidaya air tawar.',
        'satuan_berat' => '1 kg',
        'harga' => 'Rp 28.000',
        'stok' => 3,
        'status_stok' => 'Menipis',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Peternak',
        'kategori' => 'Daging',
        'batches' => [],
        'damaged_batches' => [
            [
                'batch_id' => 1,
                'tanggal_masuk' => '2025-11-10',
                'jumlah_rusak' => 2,
                'harga_normal' => 'Rp 28.000',
                'harga_saat_ini' => 'Rp 18.000',
                'keterangan' => 'Bau amis karena penyimpanan salah',
                'status' => 'Dikonfirmasi',
                'bukti_foto' => 'images/lele_rusak.jpg'
            ]
        ],
    ],
    [
        'id' => 'PRD008',
        'gambar' => 'images/kangkung.jpg',
        'nama_produk' => 'Kangkung Organik',
        'deskripsi' => 'Sayur kangkung segar bebas pestisida.',
        'satuan_berat' => '250 gram',
        'harga' => 'Rp 3.500',
        'stok' => 0,
        'status_stok' => 'Habis',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Petani',
        'kategori' => 'Sayuran',
        'batches' => [
            ['id' => 1, 'jumlah' => 20],
        ],
        'damaged_batches' => [],
    ],
    [
        'id' => 'PRD009',
        'gambar' => 'images/tahu.jpeg',
        'nama_produk' => 'Tahu Putih Segar',
        'deskripsi' => 'Tahu lembut produksi harian.',
        'satuan_berat' => '10 pcs',
        'harga' => 'Rp 8.000',
        'stok' => 25,
        'status_stok' => 'Tersedia',
        'status_tampil' => 'Diarsipkan',
        'supplier' => 'Petani',
        'kategori' => 'Sayuran',
        'batches' => [
            ['id' => 1, 'jumlah' => 100],
            ['id' => 2, 'jumlah' => 120],
        ],
        'damaged_batches' => [
            [
                'batch_id' => 1,
                'tanggal_masuk' => '2025-10-25',
                'jumlah_rusak' => 12,
                'harga_normal' => 'Rp 8.000',
                'harga_saat_ini' => 'Rp 5.000',
                'keterangan' => 'Lendir karena kelembaban',
                'status' => 'Menunggu Konfirmasi',
                'bukti_foto' => 'images/tahu_rusak.jpg'
            ]
        ],
    ],
    [
        'id' => 'PRD010',
        'gambar' => 'images/tempe.jpg',
        'nama_produk' => 'Tempe Daun Segar',
        'deskripsi' => 'Tempe fermentasi alami, dibungkus daun.',
        'satuan_berat' => '10 pcs',
        'harga' => 'Rp 6.000',
        'stok' => 12,
        'status_stok' => 'Tersedia',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Petani',
        'kategori' => 'Sayuran',
        'batches' => [],
        'damaged_batches' => [],
    ],
    [
        'id' => 'PRD011',
        'gambar' => 'images/gula_aren.jpg',
        'nama_produk' => 'Gula Merah Asli',
        'deskripsi' => 'Gula merah murni dari nira kelapa.',
        'satuan_berat' => '500 gram',
        'harga' => 'Rp 12.000',
        'stok' => 7,
        'status_stok' => 'Menipis',
        'status_tampil' => 'Ditampilkan',
        'supplier' => 'Petani',
        'kategori' => 'Buah',
        'batches' => [
            ['id' => 1, 'jumlah' => 50],
            ['id' => 2, 'jumlah' => 70],
        ],
        'damaged_batches' => [
            [
                'batch_id' => 2,
                'tanggal_masuk' => '2025-11-05',
                'jumlah_rusak' => 3,
                'harga_normal' => 'Rp 12.000',
                'harga_saat_ini' => 'Rp 8.000',
                'keterangan' => 'Kristal rusak karena pecah',
                'status' => 'Dikonfirmasi',
                'bukti_foto' => 'images/gula_rusak.jpg'
            ]
        ],
    ],
    [
        'id' => 'PRD012',
        'gambar' => 'images/susu.jpeg',
        'nama_produk' => 'Susu Sapi Segar',
        'deskripsi' => 'Susu sapi murni tanpa pengawet.',
        'satuan_berat' => '1 liter',
        'harga' => 'Rp 18.000',
        'stok' => 30,
        'status_stok' => 'Tersedia',
        'status_tampil' => 'Diarsipkan',
        'supplier' => 'Peternak',
        'kategori' => 'Daging',
        'batches' => [
            ['id' => 1, 'jumlah' => 80],
        ],
        'damaged_batches' => [],
    ],
],
    ]);
});

Route::get('/pengiriman_masuk', function () {
    return view('Kurir/pengirimanMasuk', [
        'pengiriman_masuk' => [
            [
                'tanggal' => '2025-10-25',
                'produk' => 'Sayur Kangkung Segar',
                'jumlah' => '2 ikat',
                'ongkir' => 'Rp 5.000',
                'alamat' => 'Jl. Mawar No. 12, Sendawar',
                'gambar' => 'images/kangkung.jpg',
                'supplier' => 'Petani',
                'total_produk' => 1  // Hanya 1 produk
            ],
            [
                'tanggal' => '2025-10-24',
                'produk' => 'Beras Kutai Premium 5kg',
                'jumlah' => '1 karung',
                'ongkir' => 'Rp 10.000',
                'alamat' => 'Jl. Melati No. 8, Barong Tongkok',
                'gambar' => 'images/beras.jpg',
                'supplier' => 'Bulog',
                'total_produk' => 3  // Ada 3 produk total (beras + 2 lain)
            ],
            [
                'tanggal' => '2025-10-24',
                'produk' => 'Telur Ayam Kampung',
                'jumlah' => '1 rak (30 butir)',
                'ongkir' => 'Rp 7.000',
                'alamat' => 'Jl. Sawo No. 22, Linggang Bigung',
                'gambar' => 'images/telur_kampung.jpg',
                'supplier' => 'Peternak',
                'total_produk' => 2  // Ada 2 produk total
            ],
            [
                'tanggal' => '2025-10-23',
                'produk' => 'Sayur Bayam Segar',
                'jumlah' => '3 ikat',
                'ongkir' => 'Rp 4.000',
                'alamat' => 'Jl. Kenanga No. 9, Sekolaq Darat',
                'gambar' => 'images/bayam.jpeg',
                'supplier' => 'Petani',
                'total_produk' => 1  // Hanya 1 produk
            ],
            [
                'tanggal' => '2025-10-22',
                'produk' => 'Ikan Gabus Segar',
                'jumlah' => '2 ekor (1kg)',
                'ongkir' => 'Rp 12.000',
                'alamat' => 'Jl. Mawar Putih No. 5, Melak',
                'gambar' => 'images/ikan.jpeg',
                'supplier' => 'Nelayan',
                'total_produk' => 4  // Ada 4 produk total
            ],
        ]
    ]);
});

Route::get('/detail_rusak', function () {
    return view('Staff_Produk/detailRusak', [
        'produk' => [
            'nama_produk' => 'Beras Premium Kutai',
            'deskripsi' => 'Beras premium dengan kualitas tinggi, cocok untuk konsumsi harian.',
            'supplier' => 'Bulog',
            'kategori' => 'Beras',
            'satuan_berat' => '5 kg',
            'gambar' => 'images/beras.jpg',
        ], // PERBAIKAN: Mengubah titik koma (;) menjadi koma (,)

        'damaged_batches' => [
            [
                'batch_id' => 1,
                'tanggal_masuk' => '2025-11-01',
                'harga_normal' => 'Rp 75.000',
                'harga_saat_ini' => 'Rp 75.000',
                'selisih_harga' => '0',
                'jumlah_rusak' => 3,
                'tingkat_kerusakan' => 'Ringan',
                'keterangan' => 'Kemasan penyok akibat pengiriman.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 2,
                'tanggal_masuk' => '2025-11-03',
                'harga_normal' => 'Rp 75.000',
                'harga_saat_ini' => 'Rp 71.250',
                'selisih_harga' => '-3.750',
                'jumlah_rusak' => 2,
                'tingkat_kerusakan' => 'Ringan',
                'keterangan' => 'Karung sedikit robek.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 3,
                'tanggal_masuk' => '2025-11-05',
                'harga_normal' => 'Rp 75.000',
                'harga_saat_ini' => 'Rp 82.000',
                'selisih_harga' => '+7.000',
                'jumlah_rusak' => 5,
                'tingkat_kerusakan' => 'Sedang',
                'keterangan' => 'Beberapa bagian basah karena penyimpanan buruk.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 4,
                'tanggal_masuk' => '2025-11-07',
                'harga_normal' => 'Rp 78.000',
                'harga_saat_ini' => 'Rp 70.200',
                'selisih_harga' => '-7.800',
                'jumlah_rusak' => 1,
                'tingkat_kerusakan' => 'Ringan',
                'keterangan' => 'Karung lecet di bagian bawah.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 5,
                'tanggal_masuk' => '2025-11-09',
                'harga_normal' => 'Rp 75.000',
                'harga_saat_ini' => 'Rp 75.000',
                'selisih_harga' => '0',
                'jumlah_rusak' => 4,
                'tingkat_kerusakan' => 'Sedang',
                'keterangan' => 'Kemasan terkena tekanan saat ditumpuk.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 6,
                'tanggal_masuk' => '2025-11-11',
                'harga_normal' => 'Rp 77.000',
                'harga_saat_ini' => 'Rp 74.690',
                'selisih_harga' => '-2.310',
                'jumlah_rusak' => 3,
                'tingkat_kerusakan' => 'Ringan',
                'keterangan' => 'Plastik segel sedikit sobek.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 7,
                'tanggal_masuk' => '2025-11-12',
                'harga_normal' => 'Rp 75.000',
                'harga_saat_ini' => 'Rp 80.000',
                'selisih_harga' => '+5.000',
                'jumlah_rusak' => 6,
                'tingkat_kerusakan' => 'Sedang',
                'keterangan' => 'Karung terkena cipratan air hujan.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 8,
                'tanggal_masuk' => '2025-11-13',
                'harga_normal' => 'Rp 79.500',
                'harga_saat_ini' => 'Rp 73.935',
                'selisih_harga' => '-5.565',
                'jumlah_rusak' => 2,
                'tingkat_kerusakan' => 'Ringan',
                'keterangan' => 'Segel samping terbuka sedikit.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 9,
                'tanggal_masuk' => '2025-11-14',
                'harga_normal' => 'Rp 75.000',
                'harga_saat_ini' => 'Rp 75.000',
                'selisih_harga' => '0',
                'jumlah_rusak' => 3,
                'tingkat_kerusakan' => 'Ringan',
                'keterangan' => 'Penyok karena tertimpa barang.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 10,
                'tanggal_masuk' => '2025-10-30',
                'harga_normal' => 'Rp 76.000',
                'harga_saat_ini' => 'Rp 74.480',
                'selisih_harga' => '-1.520',
                'jumlah_rusak' => 1,
                'tingkat_kerusakan' => 'Ringan',
                'keterangan' => 'Karung kotor karena debu gudang.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            // Batch 11 - 20 (lebih banyak & bervariasi)
            [
                'batch_id' => 11,
                'tanggal_masuk' => '2025-10-28',
                'harga_normal' => 'Rp 75.000',
                'harga_saat_ini' => 'Rp 79.000',
                'selisih_harga' => '+4.000',
                'jumlah_rusak' => 7,
                'tingkat_kerusakan' => 'Berat',
                'keterangan' => 'Air masuk ke area penyimpanan, karung basah parah.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 12,
                'tanggal_masuk' => '2025-10-25',
                'harga_normal' => 'Rp 77.500',
                'harga_saat_ini' => 'Rp 73.625',
                'selisih_harga' => '-3.875',
                'jumlah_rusak' => 4,
                'tingkat_kerusakan' => 'Sedang',
                'keterangan' => 'Terdapat noda hitam pada kemasan luar.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 13,
                'tanggal_masuk' => '2025-10-20',
                'harga_normal' => 'Rp 75.000',
                'harga_saat_ini' => 'Rp 75.000',
                'selisih_harga' => '0',
                'jumlah_rusak' => 2,
                'tingkat_kerusakan' => 'Ringan',
                'keterangan' => 'Terkikis di bagian pojok karung.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 14,
                'tanggal_masuk' => '2025-10-18',
                'harga_normal' => 'Rp 78.200',
                'harga_saat_ini' => 'Rp 68.000',
                'selisih_harga' => '-10.200',
                'jumlah_rusak' => 8,
                'tingkat_kerusakan' => 'Berat',
                'keterangan' => 'Terkena rembesan air dari lantai gudang.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 15,
                'tanggal_masuk' => '2025-10-15',
                'harga_normal' => 'Rp 78.250',
                'harga_saat_ini' => 'Rp 71.190',
                'selisih_harga' => '-7.060',
                'jumlah_rusak' => 3,
                'tingkat_kerusakan' => 'Ringan',
                'keterangan' => 'Segel atas agak longgar.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 16,
                'tanggal_masuk' => '2025-10-13',
                'harga_normal' => 'Rp 75.000',
                'harga_saat_ini' => 'Rp 84.000',
                'selisih_harga' => '+9.000',
                'jumlah_rusak' => 9,
                'tingkat_kerusakan' => 'Berat',
                'keterangan' => 'Karung sobek besar, sebagian tumpah.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 17,
                'tanggal_masuk' => '2025-10-11',
                'harga_normal' => 'Rp 76.500',
                'harga_saat_ini' => 'Rp 75.000',
                'selisih_harga' => '-1.500',
                'jumlah_rusak' => 4,
                'tingkat_kerusakan' => 'Sedang',
                'keterangan' => 'Kotor karena tumpahan barang lain.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 18,
                'tanggal_masuk' => '2025-10-10',
                'harga_normal' => 'Rp 75.000',
                'harga_saat_ini' => 'Rp 83.000',
                'selisih_harga' => '+8.000',
                'jumlah_rusak' => 5,
                'tingkat_kerusakan' => 'Berat',
                'keterangan' => 'Berjamur di bagian luar karung.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 19,
                'tanggal_masuk' => '2025-10-08',
                'harga_normal' => 'Rp 74.500',
                'harga_saat_ini' => 'Rp 74.500',
                'selisih_harga' => '0',
                'jumlah_rusak' => 1,
                'tingkat_kerusakan' => 'Ringan',
                'keterangan' => 'Karet pengikat karung longgar.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
            [
                'batch_id' => 20,
                'tanggal_masuk' => '2025-10-05',
                'harga_normal' => 'Rp 77.000',
                'harga_saat_ini' => 'Rp 65.000',
                'selisih_harga' => '-12.000',
                'jumlah_rusak' => 10,
                'tingkat_kerusakan' => 'Berat',
                'keterangan' => 'Karung rusak parah akibat serangan tikus.',
                'gambar' => 'images/beras_rusak.jpg',
            ],
        ],
    ]);
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

Route::get('/profil_kurir', function () {
    return view('Kurir/profil');
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

Route::get('/purchasing/kelola_ongkir', function () {
    return view('Staff_Purchasing/ongkirDaerah');
});

Route::get('/super_admin/dashboard', function () {
    return view('Super_Admin/dashboard');
});

Route::get('/super_admin/manajemen_user', function () {
    return view('Super_Admin/manajemenUser', [
        'users' => [
        // Super Admin (1)
        [
            'id' => 1,
            'nama_lengkap' => 'Admin Utama',
            'email' => 'admin@super.com',
            'no_telpon' => '081234567890',
            'role' => 'Super Admin',
            'aktif' => 'Aktif'
        ],

        // Staff Purchasing (2)
        [
            'id' => 2,
            'nama_lengkap' => 'Staff Purchasing 1',
            'email' => 'staff1@purchasing.com',
            'no_telpon' => '081234567891',
            'role' => 'Staff Purchasing',
            'aktif' => 'Aktif'
        ],
        [
            'id' => 3,
            'nama_lengkap' => 'Staff Purchasing 2',
            'email' => 'staff2@purchasing.com',
            'no_telpon' => '081234567892',
            'role' => 'Staff Purchasing',
            'aktif' => 'Aktif'
        ],

        // Staff Produk (2)
        [
            'id' => 4,
            'nama_lengkap' => 'Staff Produk 1',
            'email' => 'staff1@produk.com',
            'no_telpon' => '081234567893',
            'role' => 'Staff Produk',
            'aktif' => 'Aktif'
        ],
        [
            'id' => 5,
            'nama_lengkap' => 'Staff Produk 2',
            'email' => 'staff2@produk.com',
            'no_telpon' => '081234567894',
            'role' => 'Staff Produk',
            'aktif' => 'Tidak Aktif'
        ],

        // Kurir (5)
        [
            'id' => 6,
            'nama_lengkap' => 'Kurir Ahmad',
            'email' => 'kurir1@kurir.com',
            'no_telpon' => '081234567895',
            'role' => 'Kurir',
            'aktif' => 'Aktif'
        ],
        [
            'id' => 7,
            'nama_lengkap' => 'Kurir Siti',
            'email' => 'kurir2@kurir.com',
            'no_telpon' => '081234567896',
            'role' => 'Kurir',
            'aktif' => 'Aktif'
        ],
        [
            'id' => 8,
            'nama_lengkap' => 'Kurir Budi',
            'email' => 'kurir3@kurir.com',
            'no_telpon' => '081234567897',
            'role' => 'Kurir',
            'aktif' => 'Tidak Aktif'
        ],
        [
            'id' => 9,
            'nama_lengkap' => 'Kurir Indah',
            'email' => 'kurir4@kurir.com',
            'no_telpon' => '081234567898',
            'role' => 'Kurir',
            'aktif' => 'Aktif'
        ],
        [
            'id' => 10,
            'nama_lengkap' => 'Kurir Rudi',
            'email' => 'kurir5@kurir.com',
            'no_telpon' => '081234567899',
            'role' => 'Kurir',
            'aktif' => 'Aktif'
        ],

        // User/Konsumen (5)
        [
            'id' => 11,
            'nama_lengkap' => 'User Konsumen 1',
            'email' => 'user1@konsumen.com',
            'no_telpon' => '081234567900',
            'role' => 'User',
            'aktif' => 'Aktif'
        ],
        [
            'id' => 12,
            'nama_lengkap' => 'User Konsumen 2',
            'email' => 'user2@konsumen.com',
            'no_telpon' => '081234567901',
            'role' => 'User',
            'aktif' => 'Aktif'
        ],
        [
            'id' => 13,
            'nama_lengkap' => 'User Konsumen 3',
            'email' => 'user3@konsumen.com',
            'no_telpon' => '081234567902',
            'role' => 'User',
            'aktif' => 'Tidak Aktif'
        ],
        [
            'id' => 14,
            'nama_lengkap' => 'User Konsumen 4',
            'email' => 'user4@konsumen.com',
            'no_telpon' => '081234567903',
            'role' => 'User',
            'aktif' => 'Aktif'
        ],
        [
            'id' => 15,
            'nama_lengkap' => 'User Konsumen 5',
            'email' => 'user5@konsumen.com',
            'no_telpon' => '081234567904',
            'role' => 'User',
            'aktif' => 'Aktif'
        ],
        ]
    ]);
});

Route::get('/super_admin/manajemen_pengurus', function () {
    return view('Super_Admin/manajemenPengurus', [
        'kepengurusan' => [
            [
                'gambar' => 'images/gambar_1.jpg',
                'nama' => 'Liam Vandenberg',
                'jabatan' => 'Kepala Dinas',
                'deskripsi' => 'Memimpin dan mengarahkan seluruh kegiatan strategis dinas.',
            ],
            [
                'gambar' => 'images/gambar_2.jpg',
                'nama' => 'Sophia Delacroix',
                'jabatan' => 'Sekretaris',
                'deskripsi' => 'Mengelola dokumen dan koordinasi administrasi internal.',
            ],
            [
                'gambar' => 'images/gambar_3.jpg',
                'nama' => 'Matteo Alvarez',
                'jabatan' => 'Kabid Ketersediaan Pangan',
                'deskripsi' => 'Mengatur ketersediaan logistik pangan secara tepat waktu.',
            ],
            [
                'gambar' => 'images/gambar_4.jpg',
                'nama' => 'Amelia Rothschild',
                'jabatan' => 'Analis Pangan',
                'deskripsi' => 'Menganalisis data untuk perencanaan dan evaluasi pangan.',
            ],
            [
                'gambar' => 'images/gambar_5.jpg',
                'nama' => 'Noah Leclerc',
                'jabatan' => 'Staff IT & Administrasi',
                'deskripsi' => 'Mengelola sistem digital dan data administrasi dinas.',
            ],
            [
                'gambar' => 'images/gambar_6.jpg',
                'nama' => 'Elena Novikova',
                'jabatan' => 'Kabid Konsumsi dan Keamanan Pangan',
                'deskripsi' => 'Menjamin keamanan dan kualitas pangan bagi konsumen.',
            ],
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
