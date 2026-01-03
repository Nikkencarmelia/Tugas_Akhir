<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            background-color: #E5ECCD;
        }

        /* Container Carousel */
        #kepengurusanCarousel {
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 4rem;
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

        /* Indicators */
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

        /* Arrows */
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
            transition: transform 0.2s ease;
            height: 100%;
            position: relative; /* untuk badge diskon */
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
                <a href="{{ route('user.produk') }}" class="btn bg-success text-white fw-bold px-5 py-3 mt-4 shadow-lg rounded-pill">
                    Belanja Sekarang!
                </a>
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
                                            <img src="{{ asset('storage/' . $person->gambar) }}" alt="{{ $person->nama }}" onerror="this.src='{{ asset('images/default-avatar.png') }}'">
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

{{-- Produk Terbaru --}}
<div class="container mt-5" id="produk-terbaru">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold text-start">Produk Terbaru</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('user.produk') }}" class="btn btn-lihat-semua">Lihat Semua >></a>
        </div>
    </div>
    <div class="row g-4 mt-2 justify-content-center">
        @foreach ($produkUnggul->take(12) as $item)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="produk-card text-center d-flex flex-column justify-content-between">
                    @if($item['is_diskon'])
                        <span class="badge-diskon">-{{ $item['persen_diskon'] }}%</span>
                    @endif
                    <img src="{{ $item['gambar'] }}" alt="{{ $item['nama_produk'] }}" onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                    <h5 class="card-title">{{ $item['nama_produk'] }}</h5>
                    <p class="card-subtitle">{{ $item['satuan_berat'] }}</p>
                    @if($item['is_diskon'])
                        <p class="card-text fw-bold text-success mb-0">{{ $item['harga_formatted'] }}</p>
                        <p class="text-muted text-decoration-line-through small">{{ $item['harga_awal_formatted'] }}</p>
                    @else
                        <p class="card-text fw-bold text-success">{{ $item['harga_formatted'] }}</p>
                    @endif
                    <div class="mt-auto">
                        <a href="{{ route('user.produk.detail', $item['id']) }}" class="btn btn-outline-success btn-sm w-100 mb-2">
                            Lihat Detail
                        </a>
                        <button class="btn btn-success btn-sm w-100 add-to-cart" data-id="{{ $item['id'] }}" data-batch-id="{{ $item['batch_id'] ?? '' }}" data-quantity="{{ $item['quantity'] ?? 1 }}">Masukkan Keranjang</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Produk Terlaris --}}
@if($produkUnggul->count() > 12)
    <div class="container mt-5 mb-5">
        <div class="row align-items-center mb-4">
            <div class="col">
                <h2 class="fw-bold text-start">Produk Terlaris</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('user.produk') }}" class="btn btn-lihat-semua">Lihat Semua >></a>
            </div>
        </div>
        <div class="row g-4 mt-2 justify-content-center">
            @foreach ($produkUnggul->skip(12)->take(12) as $item)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="produk-card text-center d-flex flex-column justify-content-between">
                        @if($item['is_diskon'])
                            <span class="badge-diskon">-{{ $item['persen_diskon'] }}%</span>
                        @endif
                        <img src="{{ $item['gambar'] }}" alt="{{ $item['nama_produk'] }}" onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                        <h5 class="card-title">{{ $item['nama_produk'] }}</h5>
                        <p class="card-subtitle">{{ $item['satuan_berat'] }}</p>
                        @if($item['is_diskon'])
                            <p class="card-text fw-bold text-success mb-0">{{ $item['harga_formatted'] }}</p>
                            <p class="text-muted text-decoration-line-through small">{{ $item['harga_awal_formatted'] }}</p>
                        @else
                            <p class="card-text fw-bold text-success">{{ $item['harga_formatted'] }}</p>
                        @endif
                        <div class="mt-auto">
                            <a href="{{ route('user.produk.detail', $item['id']) }}" class="btn btn-outline-success btn-sm w-100 mb-2">Lihat Detail</a>
                            <button class="btn btn-success btn-sm w-100 add-to-cart" data-id="{{ $item['id'] }}" data-batch-id="{{ $item['batch_id'] ?? '' }}" data-quantity="{{ $item['quantity'] ?? 1 }}">Masukkan Keranjang</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

{{-- Toast Container --}}
<div class="toast-container">
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
        // Cek CSRF token ada atau nggak
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('CSRF TOKEN MISSING! Tambah <meta name="csrf-token" content="{{ csrf_token() }}"> di layout head.');
            return;
        }

        // Init toast dengan autohide
        const toastEl = document.getElementById('addToCartToast');
        const toast = new bootstrap.Toast(toastEl, {
            autohide: true,  // Auto hide setelah delay
            delay: 3000      // 3 detik
        });

        // Function to update cart badge
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

        // Fungsi helper buat show toast (success/error)
        function showToast(message, isSuccess = true) {
            const toastBody = document.getElementById('toastMessage');
            toastBody.textContent = message;

            // Ganti icon/header berdasarkan status
            const toastHeader = toastEl.querySelector('.toast-header strong');
            const icon = toastEl.querySelector('.toast-header i');
            if (isSuccess) {
                toastHeader.textContent = 'Keranjang';
                icon.className = 'fas fa-shopping-cart text-success me-2';
                toastEl.classList.remove('bg-danger', 'text-white');  // Reset kalau ada error class
            } else {
                toastHeader.textContent = 'Error';
                icon.className = 'fas fa-exclamation-triangle text-danger me-2';
                toastEl.classList.add('bg-danger', 'text-white');  // Styling error
            }

            toast.show();
        }

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.id;
                const batchId = this.dataset.batchId || null;
                const quantity = parseInt(this.dataset.quantity) || 1;

                // Optional: Ambil nama produk dari card title terdekat (buat message lebih bagus)
                const cardTitle = this.closest('.produk-card').querySelector('.card-title');
                const namaProduk = cardTitle ? cardTitle.textContent.trim() : 'item';

                console.log('Sending to cart:', { product_id: productId, batch_id: batchId, quantity: quantity });

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
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Error response:', text);
                            throw new Error(`HTTP ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        // Message lebih personal dengan nama produk
                        showToast(`Berhasil! ${quantity} ${namaProduk} ditambahkan ke keranjang.`, true);

                        // Update cart badge
                        updateCartBadge(data.cart_count || 0);

                        // Optional: Redirect ke keranjang setelah toast selesai (uncomment kalau mau)
                        // toastEl.addEventListener('hidden.bs.toast', () => {
                        //     window.location.href = '{{ route("keranjang.index") }}';
                        // }, { once: true });

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
