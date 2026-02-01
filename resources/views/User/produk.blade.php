<!DOCTYPE html>
<html lang="id">
<head>
    <title>Produk</title>
</head>
<body>
@extends('Components.user')

@section('content')
<style>
    .carousel {
        height: 400px;
        overflow: hidden;
        border-radius: 1.5rem;
        margin: 0 auto;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .carousel-item img {
        height: 400px;
        width: 100%;
        object-fit: cover;
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(8px);
        border-radius: 1rem;
        padding: 1.5rem;
        bottom: 2rem;
        max-width: 60%;
        margin: 0 auto;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .carousel-caption h5 {
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .carousel-caption p {
        font-size: 1rem;
        margin-bottom: 0;
        opacity: 0.9;
    }

    .search-wrapper {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }

    .search-wrapper:focus-within {
        border-color: #198754;
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

    .category-title {
        font-size: 2.2rem;
        font-weight: bold;
        color: #198754;
        font-family: 'Montserrat', sans-serif;
        margin-top: 4rem;
        margin-bottom: 2rem;
    }

    .no-produk {
        text-align: center;
        padding: 100px 20px;
        color: #888;
    }

    .search-result-info {
        margin: 2rem 0;
        font-size: 1.1rem;
        color: #555;
    }

    .highlight {
        background-color: #fff3cd;
        padding: 0.1em 0.2em;
        border-radius: 0.2em;
        font-weight: 600;
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

<div class="container py-4 mt-5">

<div id="carouselExampleCaptions" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/slide1.png') }}" class="d-block w-100" alt="Promo">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/slide2.png') }}" class="d-block w-100" alt="Produk Lokal">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/slide3.png') }}" class="d-block w-100" alt="Kualitas Terjamin">
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

<div class="d-flex justify-content-end mb-5">
        <div class="input-group search-wrapper" style="width: 350px;">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari produk (nama, kategori, deskripsi)...">
            <button class="input-group-text border-start-0" type="button" id="searchClear" style="display:none;">
                <i class="fa fa-times text-muted"></i>
            </button>
            <button class="input-group-text border-start-0" type="button" id="searchBtn">
                <i class="fa fa-search text-muted"></i>
            </button>
        </div>
    </div>

<div class="search-result-info text-center mb-4" id="searchInfo" style="display: none;">
        Menampilkan hasil pencarian untuk: <strong id="searchTerm"></strong>
    </div>

    <div id="produkContainer">
        @if($produks->isEmpty())
            <div class="no-produk">
                <h3>Belum Ada Produk Tersedia</h3>
                <p>Silakan cek kembali nanti ya!</p>
            </div>
        @else
            @foreach($produksGrouped as $kategori => $items)
                <div class="category-section">
                    <div class="text-start mb-4">
                        <h2 class="category-title">{{ $kategori }}</h2>
                    </div>
                    <div class="row g-4 mb-5 justify-content-start produk-row">
                        @foreach($items as $produk)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 produk-item">
                                <div class="produk-card text-center d-flex flex-column justify-content-between">
                                    @if($produk['is_diskon'])
                                        <span class="badge-diskon">-{{ $produk['persen_diskon'] }}%</span>
                                    @endif
                                    <img src="{{ $produk['gambar_url'] }}"
                                         alt="{{ $produk['nama_produk'] }}"
                                         onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                    <div class="mt-2">
                                        <h5 class="card-title produk-nama">{{ $produk['nama_produk'] }}</h5>
                                        <p class="card-subtitle mb-0 fw-bold supplier-name">
                                            {{ $produk['supplier'] }}
                                        </p>
                                        <p class="card-subtitle">
                                            {{ $produk['jumlah_satuan'] }} {{ $produk['satuan'] }}
                                        </p>
                                        @if($produk['is_diskon'])
                                            <p class="card-text fw-bold text-success mb-0">
                                                {{ $produk['harga_formatted'] }}
                                            </p>
                                            <p class="text-muted text-decoration-line-through small">
                                                {{ $produk['harga_awal_formatted'] }}
                                            </p>
                                        @else
                                            <p class="card-text fw-bold text-success">
                                                {{ $produk['harga_formatted'] }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="mt-auto">
                                        <a href="{{ route('produk.detail', $produk['id']) }}"
                                           class="btn btn-outline-success btn-sm mb-2 w-100">
                                            Lihat Detail
                                        </a>
                                        <button class="btn btn-success btn-sm w-100 add-to-cart"
                                                data-id="{{ $produk['id'] }}"
                                                data-batch-id="{{ $produk['batch_id'] ?? '' }}"
                                                data-quantity="{{ $produk['quantity'] ?? 1 }}">
                                            Masukkan Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

<div id="noResult" class="no-produk" style="display: none;">
        <h3>Tidak ditemukan produk dengan kata kunci "<span id="noResultTerm"></span>"</h3>
        <p>Silakan coba kata kunci lain ya!</p>
    </div>

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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchClear = document.getElementById('searchClear');
        const searchBtn = document.getElementById('searchBtn');
        const searchInfo = document.getElementById('searchInfo');
        const searchTermEl = document.getElementById('searchTerm');
        const noResult = document.getElementById('noResult');
        const noResultTerm = document.getElementById('noResultTerm');

        let searchTimeout;
        function fetchFilteredData() {
            const search = searchInput.value;

            // Visual loading state
            const container = document.getElementById('produkContainer');
            if (container) container.style.opacity = '0.5';

            fetch('{{ route('produk') }}?search=' + encodeURIComponent(search), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.getElementById('produkContainer');
                
                if (newContent) {
                    $('#produkContainer').html(newContent.innerHTML);
                    
                    // Simple count check based on visibility in the returned HTML
                    const hasProduk = newContent.querySelectorAll('.produk-item').length > 0;

                    if (search.trim() !== '') {
                        searchInfo.style.display = 'block';
                        searchTermEl.textContent = search;
                        searchClear.style.display = 'block';
                        
                        if (!hasProduk) {
                            noResult.style.display = 'block';
                            noResultTerm.textContent = search;
                            searchInfo.style.display = 'none';
                        } else {
                            noResult.style.display = 'none';
                        }
                    } else {
                        searchInfo.style.display = 'none';
                        noResult.style.display = 'none';
                        searchClear.style.display = 'none';
                    }
                }

                if (container) container.style.opacity = '1';
            })
            .catch(err => {
                console.error('Fetch error:', err);
                if (container) container.style.opacity = '1';
            });
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchFilteredData();
            }, 500);
        });

        searchClear.addEventListener('click', () => {
            searchInput.value = '';
            fetchFilteredData();
            searchInput.focus();
        });
        searchBtn.addEventListener('click', () => searchInput.focus());

const toastEl = document.getElementById('addToCartToast');
        const toast = new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: 3000
        });

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

        $(document).on('click', '.add-to-cart', function() {
                const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
                if (!isAuthenticated) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }

                const productId = this.dataset.id;
                const batchId = this.dataset.batchId || null;
                const quantity = parseInt(this.dataset.quantity) || 1;

                const btn = this;
                btn.disabled = true;
                const originalContent = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambahkan...';

                fetch('{{ route("keranjang.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: parseInt(productId),
                        batch_id: batchId ? parseInt(batchId) : null,
                        quantity: quantity
                    })
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        throw new Error(data.message || `HTTP error! status: ${response.status}`);
                    }
                    return data;
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById('toastMessage').textContent = `Berhasil ditambahkan ${quantity} item ke keranjang!`;
                        toast.show();
                        updateCartBadge(data.cart_count || 0);
                    } else {
                        document.getElementById('toastMessage').textContent = 'Gagal: ' + (data.message || 'Unknown error');
                        toast.show();
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    document.getElementById('toastMessage').textContent = 'Terjadi kesalahan: ' + error.message;
                    toast.show();
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                });
        });
    });
</script>
@endsection
</body>
</html>
