<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Landing Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #E5ECCD;
                font-family: 'Poppins', sans-serif;
            }

            .full-screen-section {
                min-height: 100vh;
                display: flex;
                align-items: center;
                background-color: #E5ECCD;
            }

            /* Container Carousel */
            #kepengurusanCarousel {
                max-width: 1200px;
                margin: 0 auto;
                padding-bottom: 4rem; /* Tambahan baru: ruang di bawah indicators */
            }

            /* Card Styling (Clean & Compact) */
            .square-card {
                background-color: #fff;
                border-radius: 20px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                padding: 0;
                transition: all 0.3s ease;
                height: 100%;
                overflow: hidden;
                position: relative;
                border: 1px solid #f1f3f4;
            }

            .square-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            }

            .card-img-wrapper {
                height: 220px; /* Fixed height buat img fit */
                overflow: hidden;
            }

            .square-card img {
                width: 100%;
                height: 100%;
                object-fit: cover; /* Crop & fit tanpa distort */
                transition: transform 0.3s ease;
            }

            .square-card:hover img {
                transform: scale(1.05);
            }

            .card-content {
                padding: 1.25rem;
                height: calc(100% - 220px);
                display: flex;
                flex-direction: column;
            }

            .card-title {
                font-weight: 600;
                font-size: 18px;
                margin-bottom: 4px;
                color: #2a522a;
                line-height: 1.3;
            }

            .card-subtitle {
                font-size: 14px;
                color: #198754;
                margin-bottom: 8px;
                font-weight: 500;
            }

            .card-text {
                font-size: 14px;
                color: #555;
                flex-grow: 1;
                line-height: 1.5;
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 4;
                -webkit-box-orient: vertical;
            }

            /* Indicators (Dots di bawah, clean) */
            .carousel-indicators {
                bottom: -2rem;
            }

            /* .carousel-indicators [data-bs-target] {
                width: 12px;
                height: 12px;
                border-radius: 100%;
                margin: 0 6px;
                background-color: #dee2e6;
                border: none;
                transition: all 0.3s ease;
            } */

            /* .carousel-indicators .active {
                background-color: #198754 !important;
                transform: scale(1.2);
            } */

            /* Indicators (Dots di bawah, clean & bulat paksa) */
            .carousel-indicators {
                bottom: -2rem;
            }

            .carousel-indicators [data-bs-target] {
                width: 12px !important;
                height: 12px !important;
                border-radius: 50% !important; /* Paksa bulat, override Bootstrap */
                margin: 0 6px;
                background-color: #E5ECCD !important; /* Ganti ke warna lo: abu-hijau muda */
                border: none;
                transition: all 0.3s ease;
            }

            .carousel-indicators .active {
                background-color: #198754 !important; /* Hijau aktif, tetep */
                transform: scale(1.2);
            }

            /* Arrows (Lebih lebar & posisi aman biar gak nimpa card) */
            .carousel-control-prev, .carousel-control-next {
                width: 8%; /* Naikin dari 5% ke 8% biar lebih lebar & gak overlap */
                opacity: 0.5;
                transition: opacity 0.3s ease;
                filter: invert(1) sepia(1) saturate(5) hue-rotate(140deg); /* Bikin ijo sesuai theme */
            }

            .carousel-control-prev:hover, .carousel-control-next:hover {
                opacity: 1;
            }

            /* Responsif: Mobile 1, tablet 2, desktop 3 */
            @media (max-width: 768px) {
                .carousel-inner .row {
                    --bs-gutter-x: 1rem;
                }
                .card-img-wrapper {
                    height: 180px;
                }
                .card-content {
                    padding: 1rem;
                    height: calc(100% - 180px);
                }
                /* Di mobile, arrows lebih lebar lagi */
                .carousel-control-prev, .carousel-control-next {
                    width: 15%;
                }
            }

            .produk-card {
                background: #fff;
                border-radius: 1rem;
                padding: 1rem;
                box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.08);
                transition: transform 0.2s ease;
                height: 100%;
            }

            .produk-card:hover {
                transform: translateY(-5px);
            }

            .produk-card img {
                width: 100%;
                height: 120px;
                object-fit: cover;
                border-radius: 0.5rem;
            }

            .produk-card .card-title {
                font-size: 0.9rem;
                font-weight: 600;
                margin: 0.5rem 0 0.25rem;
            }

            .produk-card .card-subtitle {
                font-size: 0.75rem;
                color: #888;
                margin-bottom: 0.25rem;
            }

            .produk-card .card-text {
                font-size: 0.85rem;
                margin-bottom: 0.5rem;
            }

            .produk-card .btn {
                font-size: 0.75rem;
            }

        </style>
    </head>

    <body>
        @extends('components.user')

        @section('navbar-class')
            transparent
        @endsection

        @section('content_full')
        {{-- Hero Section --}}

        <div class="full-screen-section">
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-md-6">
                        <h1 class="fw-bold mb-3">Food Center</h1>
                        <h4 class="mb-4">Dinas Ketahanan Pangan Kabupaten Kutai Barat</h4>
                        <p style="font-size: 1.1rem; line-height: 1.8;">
                            Tempat terbaik untuk memenuhi kebutuhan pangan lokal dengan kualitas terbaik!
                            <strong>Food Center</strong> hadir sebagai sarana pemasaran digital yang menghubungkan langsung produsen pangan lokal dengan masyarakat.
                        </p>
                    </div>
                    <div class="col-md-6 d-none d-md-block">
                        <img src="{{ asset('images/gambar_pembuka.png') }}" class="img-fluid" alt="Food Center">
                    </div>
                </div>
            </div>
        </div>

        {{-- Kepengurusan --}}
        <div class="mt-5 mb-5">
            <h2 class="fw-bold text-center mb-3">Kepengurusan Food Center</h2>
            <h5 class="text-center mb-4 text-muted">Dinas Ketahanan Pangan Kabupaten Kutai Barat</h5>

            <div id="kepengurusanCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    @foreach (collect($kepengurusan)->chunk(3) as $index => $chunk)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row g-4 justify-content-center">
                                @foreach ($chunk as $person)
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <div class="square-card h-100">
                                            <div class="card-img-wrapper">
                                                <img src="{{ asset($person['gambar']) }}" alt="{{ $person['nama'] }}" class="card-img">
                                            </div>
                                            <div class="card-content">
                                                <h5 class="mb-2">{{ $person['nama'] }}</h5>
                                                <small class="text-success fw-semibold mb-2 d-block">{{ $person['jabatan'] }}</small>
                                                <p class="card-text small">{{ $person['deskripsi'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Arrows -->
                <button class="carousel-control-prev" type="button" data-bs-target="#kepengurusanCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#kepengurusanCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

                <!-- Indicators -->
                <div class="carousel-indicators">
                    @foreach (collect($kepengurusan)->chunk(3) as $index => $chunk)
                        <button type="button" data-bs-target="#kepengurusanCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Etalase Produk Unggulan --}}
        <div class="container mt-5">
            <h2 class="fw-bold">Etalase Pangan Produk Unggulan Dinas</h2>
            <div class="row g-4 mt-2">
                @foreach ($produkUnggul as $item)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="produk-card text-center d-flex flex-column justify-content-between">
                            <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama_produk'] }}">
                            <h5 class="card-title">{{ $item['nama_produk'] }}</h5>
                            <p class="card-subtitle">{{ $item['satuan_berat'] }}</p>
                            <p class="card-text fw-bold text-success">{{ $item['harga'] }}</p>
                            <div class="mt-auto">
                                <a href="#" class="btn btn-outline-success btn-sm w-100 mb-2">Lihat Detail</a>
                                <form method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm w-100">Masukkan Keranjang</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Etalase Produk Petani Lokal --}}
        <div class="container mt-5">
            <h2 class="fw-bold">Etalase Pangan Produk Petani Lokal</h2>
            <div class="row g-4 mt-2">
                @foreach ($produkUnggul as $item)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="produk-card text-center d-flex flex-column justify-content-between">
                            <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama_produk'] }}">
                            <h5 class="card-title">{{ $item['nama_produk'] }}</h5>
                            <p class="card-subtitle">{{ $item['satuan_berat'] }}</p>
                            <p class="card-text fw-bold text-success">{{ $item['harga'] }}</p>
                            <div class="mt-auto">
                                <a href="/detail_produk" class="btn btn-outline-success btn-sm w-100 mb-2">Lihat Detail</a>
                                <form method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm w-100">Masukkan Keranjang</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @endsection

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
