<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Produk</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .carousel {
                height: 350px;
                overflow: hidden;
                border-radius: 1rem;
                margin: 0 auto;
            }

            .carousel-item img {
                height: 100%;
                width: 100%;
                object-fit: cover;
            }

            .search-wrapper {
                border: 1px solid #ced4da;
                border-radius: 0.375rem;
                transition: all 0.2s ease;
            }

            .search-wrapper:focus-within {
                border-color: #198754; /* hijau pas fokus */
                box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, .25);
            }

            .search-wrapper .form-control,
            .search-wrapper .input-group-text {
                border: none;
                box-shadow: none !important;
                background-color: var(--bs-body-bg);
            }

            .input-group-text {
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .input-group-text:hover i {
                color: #198754 !important;
            }

            .search-wrapper:focus-within .input-group-text i {
                color: #198754 !important;
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
        @section('content')

            <div class="container py-4 mt-5">

            {{-- Carousel --}}
                <div id="carouselExampleCaptions" class="carousel slide mb-4">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>

                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/slide1.png') }}" class="d-block w-100" alt="Slide 1">
                            <div class="carousel-caption d-none d-md-block">
                            <h5>First Slide</h5>
                            <p>Promo produk segar hari ini!</p>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('images/slide2.png') }}" class="d-block w-100" alt="Slide 2">
                            <div class="carousel-caption d-none d-md-block">
                            <h5>Second Slide</h5>
                            <p>Diskon besar untuk produk lokal</p>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('images/slide3.png') }}" class="d-block w-100" alt="Slide 3">
                            <div class="carousel-caption d-none d-md-block">
                            <h5>Third Slide</h5>
                            <p>Langsung dari kebun milik dinas</p>
                            </div>
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                {{-- Kategori --}}
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <!-- Tombol Kategori (Kiri) -->
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <button class="btn btn-success rounded-2 px-3 py-1">Kategori</button>
                        <button class="btn btn-outline-success rounded-2 px-3 py-1">Bahan Pokok</button>
                        <button class="btn btn-outline-success rounded-2 px-3 py-1">Sayuran</button>
                        <button class="btn btn-outline-success rounded-2 px-3 py-1">Buah-Buahan</button>
                        <button class="btn btn-outline-success rounded-2 px-3 py-1">Kacang-Kacangan</button>
                    </div>

                    <!-- Form Search (Kanan) -->
                    <form class="d-flex mt-3 mt-md-0" role="search" style="width: 350px;">
                        <div class="input-group search-wrapper w-100">
                        <input type="text" class="form-control" placeholder="Cari produk..." aria-label="Search">
                        <button class="input-group-text border-start-0" type="submit">
                            <i class="fa fa-search text-muted"></i>
                        </button>
                        </div>
                    </form>
                </div>


                {{-- Terlaris --}}
                {{-- Etalase Terlaris --}}
                <div class="container ps-md-2" style="margin-top: 4rem;">
                    <h2 class="fw-bold" style="font-family: 'Montserrat', sans-serif;">Produk Terlaris</h2>
                    <h6>Produk Pangan Paling Banyak Diminati</h6>

                    <div class="container mt-4">
                        <div class="row g-4">
                            @foreach ($produkTerlaris as $produk)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="produk-card text-center d-flex flex-column justify-content-between">
                                    <img src="{{ asset($produk['gambar']) }}" alt="{{ $produk['nama_produk'] }}">
                                    <div class="mt-2">
                                        <h5 class="card-title">{{ $produk['nama_produk'] }}</h5>
                                        <p class="card-subtitle">{{ $produk['satuan_berat'] }}</p>
                                        <p class="card-text fw-bold text-success">{{ $produk['harga'] }}</p>
                                    </div>

                                    <div class="mt-auto">
                                        <a href="#" class="btn btn-outline-success btn-sm mb-2 w-100">Lihat Detail</a>
                                        <form action="#" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100">Masukkan Keranjang</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>

        @endsection


    </body>
</html>
