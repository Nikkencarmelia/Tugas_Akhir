<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #E5ECCD;
            font-family: 'Poppins', sans-serif;
        }

        .full-screen-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #E5ECCD 0%, #d4dbb8 100%);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .full-screen-section::before {
            content: '';
            position: absolute;
            top: -10%;
            right: -10%;
            width: 40%;
            height: 40%;
            background: radial-gradient(circle, rgba(25, 135, 84, 0.05) 0%, transparent 70%);
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-img-wrapper {
            position: relative;
            z-index: 1;
            transition: all 0.5s ease;
        }

        .hero-img-wrapper img {
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.15));
        }


        @media (max-width: 991px) {
            .full-screen-section {
                padding: 100px 0 50px;
            }
        }

        #kepengurusanCarousel {
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 4rem;
        }

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
            height: 220px;
            overflow: hidden;
        }

        .square-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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

        .square-card .card-text {
            text-align: justify;
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

        .carousel-indicators {
            bottom: -2rem;
        }

        .carousel-indicators [data-bs-target] {
            width: 12px !important;
            height: 12px !important;
            border-radius: 50% !important;
            margin: 0 6px;
            background-color: #E5ECCD !important;
            border: none;
        }

        .carousel-indicators .active {
            background-color: #198754 !important;
            transform: scale(1.2);
        }

        .carousel-control-prev, .carousel-control-next {
            width: 8%;
            opacity: 0.5;
            filter: invert(1) sepia(1) saturate(5) hue-rotate(140deg);
        }

        .carousel-control-prev:hover, .carousel-control-next:hover {
            opacity: 1;
        }

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
        }

        .produk-card {
            background: #fff;
            border-radius: 1rem;
            padding: 1rem;
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            height: 100%;
            position: relative;
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

        .badge-diskon {
            position: absolute;
            top: 8px;
            left: 8px;
            background: linear-gradient(135deg, #FFC107, #FFB300);
            color: #ffffff;
            font-weight: bold;
            font-size: 0.85rem;
            padding: 0.35rem 0.7rem;
            border-radius: 0.5rem;
            z-index: 10;
            box-shadow: 0 2px 6px rgba(255, 193, 7, 0.5);
        }

        .btn-lihat-semua {
            background: transparent;
            color: #198754;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-lihat-semua:hover {
            color: #157347;
            text-decoration: underline;
        }

        .add-to-cart {
            cursor: pointer;
        }

        .add-to-cart:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
        }
    </style>
</head>
<body>
@extends('Components.user')

@section('navbar-class')
    transparent
@endsection

@section('content_full')

<div class="full-screen-section">
    <div class="container">
        <div class="row align-items-center gy-5 hero-content">
            <div class="col-lg-6">
                <h1 class="fw-bold mb-3">Food Center</h1>
                <h4 class="mb-4">Dinas Ketahanan Pangan Kabupaten Kutai Barat</h4>
                <p style="font-size: 1.1rem; line-height: 1.8; text-align: justify;">
                    Tempat terbaik untuk memenuhi kebutuhan pangan lokal dengan kualitas terbaik!
                    <strong>Food Center</strong> hadir sebagai sarana pemasaran digital yang menghubungkan langsung produsen pangan lokal dengan masyarakat secara efisien dan transparan.
                </p>
                <!-- TOMBOl BELANJA SEKARANG PAKAI STYLE BOOTSTRAP SUCCESS DEFAULT SAJA -->
                <a href="{{ route('produk') }}" class="btn btn-success fw-bold mt-4">
                    Belanja Sekarang!
                </a>
            </div>
            <div class="col-lg-6">
                <div class="hero-img-wrapper text-center">
                    <img src="{{ asset('images/gambar_pembuka.png') }}" class="img-fluid" alt="Food Center Hero" style="max-height: 500px;">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sisa kode tetap sama -->
<div class="mt-5 mb-5">
    <h2 class="fw-bold text-center mb-3">Kepengurusan Food Center</h2>
    <h5 class="text-center mb-4 text-muted">Dinas Ketahanan Pangan Kabupaten Kutai Barat</h5>

    @if(isset($kepengurusan) && $kepengurusan->count() > 0)
        <div id="kepengurusanCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach (collect($kepengurusan)->chunk(3) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row g-4 justify-content-center">
                            @foreach ($chunk as $person)
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="square-card h-100">
                                        <div class="card-img-wrapper">
                                            <img src="{{ asset($person->gambar) }}" alt="{{ $person->nama }}" onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                        </div>
                                        <div class="card-content">
                                            <h5 class="mb-2">{{ $person->nama }}</h5>
                                            <small class="text-success fw-semibold mb-2 d-block">{{ $person->jabatan }}</small>
                                            <p class="card-text small">{{ $person->deskripsi }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#kepengurusanCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#kepengurusanCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <div class="carousel-indicators">
                @foreach (collect($kepengurusan)->chunk(3) as $index => $chunk)
                    <button type="button" data-bs-target="#kepengurusanCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <p class="text-muted">Belum ada data kepengurusan</p>
        </div>
    @endif
</div>

<div class="container mt-5" id="produk-terbaru">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold text-start">Produk Terbaru</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('produk') }}" class="btn btn-lihat-semua">Lihat Semua >></a>
        </div>
    </div>
    <div class="row g-4 mt-2 justify-content-start">
        @foreach ($produkTerbaru as $item)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="produk-card text-center d-flex flex-column justify-content-between">
                    @if($item['is_diskon'])
                        <span class="badge-diskon">-{{ $item['persen_diskon'] }}%</span>
                    @endif
                    <img src="{{ $item['gambar'] }}" alt="{{ $item['nama_produk'] }}" onerror="this.src='{{ asset('images/default-product.png') }}'">
                    <h5 class="card-title">{{ $item['nama_produk'] }}</h5>
                    <p class="card-subtitle">{{ $item['satuan_berat'] }}</p>
                    @if($item['is_diskon'])
                        <p class="card-text fw-bold text-success mb-0 text-center">{{ $item['harga_formatted'] }}</p>
                        <p class="text-muted text-decoration-line-through small text-center">{{ $item['harga_awal_formatted'] }}</p>
                    @else
                        <p class="card-text fw-bold text-success text-center">{{ $item['harga_formatted'] }}</p>
                    @endif
                    <div class="mt-auto">
                        <a href="{{ route('produk.detail', $item['id']) }}" class="btn btn-outline-success btn-sm w-100 mb-2">
                            Lihat Detail
                        </a>
                        <button class="btn btn-success btn-sm w-100 add-to-cart" 
                                data-id="{{ $item['id'] }}" 
                                data-batch-id="{{ $item['batch_id'] ?? '' }}" 
                                data-quantity="{{ $item['quantity'] ?? 1 }}">
                            Masukkan Keranjang
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@if($produkTerlaris->isNotEmpty())
    <div class="container mt-5 mb-5">
        <div class="row align-items-center mb-4">
            <div class="col">
                <h2 class="fw-bold text-start">Produk Terlaris</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('produk') }}" class="btn btn-lihat-semua">Lihat Semua >></a>
            </div>
        </div>
        <div class="row g-4 mt-2 justify-content-start">
            @foreach ($produkTerlaris as $item)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="produk-card text-center d-flex flex-column justify-content-between">
                        @if($item['is_diskon'])
                            <span class="badge-diskon">-{{ $item['persen_diskon'] }}%</span>
                        @endif
                        <img src="{{ $item['gambar'] }}" alt="{{ $item['nama_produk'] }}" onerror="this.src='{{ asset('images/default-product.png') }}'">
                        <h5 class="card-title">{{ $item['nama_produk'] }}</h5>
                        <p class="card-subtitle">{{ $item['satuan_berat'] }}</p>
                        @if($item['is_diskon'])
                            <p class="card-text fw-bold text-success mb-0 text-center">{{ $item['harga_formatted'] }}</p>
                            <p class="text-muted text-decoration-line-through small text-center">{{ $item['harga_awal_formatted'] }}</p>
                        @else
                            <p class="card-text fw-bold text-success text-center">{{ $item['harga_formatted'] }}</p>
                        @endif
                        <div class="mt-auto">
                            <a href="{{ route('produk.detail', $item['id']) }}" class="btn btn-outline-success btn-sm w-100 mb-2">Lihat Detail</a>
                            <button class="btn btn-success btn-sm w-100 add-to-cart" 
                                    data-id="{{ $item['id'] }}" 
                                    data-batch-id="{{ $item['batch_id'] ?? '' }}" 
                                    data-quantity="{{ $item['quantity'] ?? 1 }}">
                                Masukkan Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div id="addToCartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-shopping-cart text-success me-2"></i>
            <strong class="me-auto">Keranjang</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <span id="toastMessage"></span>
        </div>
    </div>
</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('CSRF TOKEN MISSING!');
            return;
        }

        const toastEl = document.getElementById('addToCartToast');
        const toast = new bootstrap.Toast(toastEl, { autohide: true, delay: 3000 });

        function updateCartBadge(count) {
            const badge = document.getElementById('cartBadge');
            if (badge) {
                if (count > 0) {
                    badge.textContent = count > 99 ? '99+' : count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        }

        function showToast(message, isSuccess = true) {
            const toastBody = document.getElementById('toastMessage');
            toastBody.textContent = message;

            const toastHeader = toastEl.querySelector('.toast-header strong');
            const icon = toastEl.querySelector('.toast-header i');
            if (isSuccess) {
                toastHeader.textContent = 'Keranjang';
                icon.className = 'fas fa-shopping-cart text-success me-2';
                toastEl.classList.remove('bg-danger', 'text-white');
            } else {
                toastHeader.textContent = 'Error';
                icon.className = 'fas fa-exclamation-triangle text-danger me-2';
                toastEl.classList.add('bg-danger', 'text-white');
            }

            toast.show();
        }

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
                if (!isAuthenticated) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }

                const productId = this.dataset.id;
                const batchId = this.dataset.batchId || null;
                const quantity = parseInt(this.dataset.quantity) || 1;

                const cardTitle = this.closest('.produk-card').querySelector('.card-title');
                const namaProduk = cardTitle ? cardTitle.textContent.trim() : 'item';

                if (!productId || isNaN(productId)) {
                    showToast('Error: Product ID tidak valid!', false);
                    return;
                }

                const button = this;
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambahkan...';

                fetch('{{ route("keranjang.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: parseInt(productId),
                        batch_id: batchId ? parseInt(batchId) : null,
                        quantity: quantity
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error(`HTTP ${response.status}: ${text}`); });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showToast(`Berhasil! ${quantity} ${namaProduk} ditambahkan ke keranjang.`, true);
                        updateCartBadge(data.cart_count || 0);
                    } else {
                        showToast(`Gagal: ${data.message || 'Unknown error'}`, false);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    showToast(`Koneksi error: ${error.message}`, false);
                })
                .finally(() => {
                    button.disabled = false;
                    button.innerHTML = 'Masukkan Keranjang';
                });
            });
        });
    });
</script>
</body>
</html>