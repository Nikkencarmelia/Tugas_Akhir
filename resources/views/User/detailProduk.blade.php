<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - {{ $produk->nama_produk }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Tambah Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .product-container {
            max-width: 1100px;
            margin: 80px auto 0;
            background: white;
            border-radius: 16px;
            padding: 30px 30px 30px 70px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            display: flex;
            gap: 30px;
            position: relative;
            overflow: hidden;
        }

        /* Tombol Back dengan ikon */
        .btn-back {
            position: absolute;
            top: 20px;
            left: 15px;
            font-size: 1.5rem;
            color: #000;
            background: transparent;
            border: none;
            cursor: pointer;
            z-index: 30;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .btn-back:hover {
            color: #333;
            transform: scale(1.05);
        }

        .image-section {
            flex: 1;
            position: relative;
        }

        .product-image {
            width: 100%;
            height: 350px;
            border-radius: 12px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 16px;
        }

        .badge-diskon {
            position: absolute;
            top: 25px;
            left: 70px;
            background: linear-gradient(135deg, #FFC107, #FFB300);
            color: #ffffff;
            font-weight: bold;
            font-size: 0.9rem;
            padding: 0.4rem 1rem;
            border-radius: 10px;
            z-index: 20;
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.4);
        }

        .detail-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .product-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            line-height: 1.3;
        }

        .product-price {
            font-size: 26px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 6px;
        }

        .price-original {
            font-size: 16px;
            color: #999;
            text-decoration: line-through;
            margin-bottom: 12px;
        }

        .product-weight {
            font-size: 16px;
            color: #666;
            margin-bottom: 6px;
        }

        .product-stock {
            font-size: 14px;
            color: #666;
            margin-bottom: 24px;
        }

        .product-description {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 24px;
            flex-grow: 1;
        }

        .quantity-section {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .quantity-label {
            font-size: 16px;
            margin-right: 16px;
            font-weight: 600;
            color: #333;
        }

        .qty-box {
            display: flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #198754;
            border-radius: 6px;
            overflow: hidden;
        }

        .btn-minus, .btn-plus {
            width: 35px;
            height: 35px;
            background: transparent;
            border: none;
            color: #198754;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-minus:hover, .btn-plus:hover {
            background: #198754;
            color: white;
        }

        .qty-input {
            width: 60px;
            height: 35px;
            text-align: center;
            border: none;
            font-size: 16px;
            background: #f8fff9;
        }

        .action-buttons {
            display: flex;
            gap: 16px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-outline-success {
            background: transparent;
            color: #198754;
            border: 2px solid #198754;
        }

        .btn-outline-success:hover {
            background: #198754;
            color: white;
        }

        .btn-success {
            background: #198754;
            color: white;
            border: none;
        }

        .btn-success:hover {
            background: #157347;
        }

        /* Improved responsive design */
        @media (max-width: 992px) {
            .product-container {
                margin-top: 70px;
                padding: 25px 25px 25px 65px;
                gap: 25px;
            }

            .product-image {
                height: 320px;
            }

            .product-title {
                font-size: 22px;
            }

            .product-price {
                font-size: 24px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .product-container {
                flex-direction: column;
                margin-top: 60px;
                padding: 20px;
                gap: 20px;
                border-radius: 12px;
            }

            .btn-back {
                top: 15px;
                left: 10px;
                font-size: 1.3rem;
                width: 40px;
                height: 40px;
            }

            .badge-diskon {
                top: 15px;
                left: 55px;
                font-size: 0.8rem;
                padding: 0.3rem 0.8rem;
            }

            /* Gambar di atas, detail di bawah (default order) */
            .image-section {
                order: 1;
            }

            .detail-section {
                order: 2;
                padding-top: 10px;
                border-top: 1px solid #eee; /* Garis pemisah seperti card */
            }

            .product-image {
                height: 280px;
            }

            .product-title {
                font-size: 20px;
            }

            .product-price {
                font-size: 22px;
            }

            .quantity-section {
                justify-content: flex-start;
            }

            .action-buttons {
                flex-direction: column; /* Stack buttons vertically on small screens */
            }

            .btn {
                padding: 14px;
            }
        }

        @media (max-width: 480px) {
            .product-container {
                padding: 15px;
                margin-top: 50px;
            }

            .product-image {
                height: 250px;
            }

            .product-title {
                font-size: 18px;
            }

            .product-price {
                font-size: 20px;
            }

            .quantity-label {
                margin-right: 10px;
                font-size: 14px;
            }

            .qty-box {
                gap: 4px;
            }

            .btn-minus, .btn-plus {
                width: 30px;
                height: 30px;
                font-size: 14px;
            }

            .qty-input {
                width: 50px;
                height: 30px;
                font-size: 14px;
            }
        }

        .add-to-cart-btn:disabled {
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

@section('content')

<div class="product-container">

    <!-- Tombol Back dengan ikon Bootstrap Icons -->
    <a href="{{ $backUrl ?? 'javascript:history.back()' }}" class="btn-back" title="Kembali">
        <i class="bi bi-chevron-left"></i>
    </a>

    <!-- Badge Diskon -->
    @php
        $batchTertua = $produk->batch->where('stok', '>', 0)->sortBy('tgl_masuk')->first();
        $hargaSaatIni = $batchTertua?->harga_saat_ini ?? 0;
        $hargaNormal = $batchTertua?->harga_normal ?? $hargaSaatIni;
        $keteranganHarga = $batchTertua?->keterangan_harga ?? 'normal';

        $isDiskon = ($keteranganHarga === 'diskon') || ($hargaSaatIni < $hargaNormal && $hargaNormal > 0);
        $persenDiskon = $isDiskon && $hargaNormal > 0 ? round((($hargaNormal - $hargaSaatIni) / $hargaNormal) * 100) : 0;
    @endphp

    @if($isDiskon)
        <span class="badge-diskon">-{{ $persenDiskon }}%</span>
    @endif

    <!-- Gambar Produk -->
    <div class="image-section">
        <div class="product-image" style="background-image: url('{{ $produk->gambar ? asset('storage/' . $produk->gambar) : asset('images/default-product.jpg') }}');">
            @if(!$produk->gambar)
                {{ $produk->nama_produk }}
            @endif
        </div>
    </div>

    <!-- Detail Produk -->
    <div class="detail-section">
        <h1 class="product-title">{{ $produk->nama_produk }}</h1>

        <div>
            <div class="product-price">Rp {{ number_format($hargaTampil, 0, ',', '.') }}</div>
            @if($isDiskon)
                <div class="price-original">Rp {{ number_format($hargaNormal, 0, ',', '.') }}</div>
            @endif
        </div>

        <div class="product-weight">{{ $satuanLengkap }}</div>
        <div class="product-stock">Stok: {{ $totalStok }}</div>

        <div class="product-description">
            {{ $produk->deskripsi ?? 'Deskripsi produk belum tersedia.' }}
        </div>

        <div class="quantity-section">
            <label class="quantity-label">Jumlah:</label>
            <div class="qty-box">
                <button class="btn-minus" type="button">-</button>
                <input type="number" class="qty-input" value="1" min="1" max="{{ $totalStok }}" id="quantity">
                <button class="btn-plus" type="button">+</button>
            </div>
        </div>

        <div class="action-buttons">
            <button class="btn btn-outline-success add-to-cart-btn" 
                    type="button"
                    data-product-id="{{ $produk->id }}"
                    data-batch-id="{{ $batchId ?? '' }}">
                Tambahkan ke Keranjang
            </button>
            <button class="btn btn-success" type="button">
                Beli Sekarang
            </button>
        </div>
    </div>
</div>

{{-- Toast Container --}}
<div class="toast-container">
    <div id="addToCartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="bi bi-cart-check text-success me-2"></i>
            <strong class="me-auto">Keranjang</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <span id="toastMessage"></span>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Quantity controls
    document.querySelector('.btn-minus').addEventListener('click', () => updateQuantity(-1));
    document.querySelector('.btn-plus').addEventListener('click', () => updateQuantity(1));

    function updateQuantity(change) {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value) + change;
        const max = parseInt(input.max);
        value = Math.max(1, Math.min(max, value));
        input.value = value;
    }

    // Add to Cart functionality
    document.addEventListener('DOMContentLoaded', function() {
        const toastEl = document.getElementById('addToCartToast');
        const toast = new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: 3000
        });
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

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

        document.querySelector('.add-to-cart-btn').addEventListener('click', function() {
            const button = this;
            const productId = button.dataset.productId;
            const batchId = button.dataset.batchId || null;
            const quantity = parseInt(document.getElementById('quantity').value) || 1;

            button.disabled = true;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-hourglass-split"></i> Menambahkan...';

            const payload = {
                product_id: parseInt(productId),
                quantity: quantity
            };

            if (batchId && batchId !== '') {
                payload.batch_id = parseInt(batchId);
            }

            fetch('{{ route("keranjang.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById('toastMessage').textContent = `Berhasil ditambahkan ${quantity} item ke keranjang!`;
                    toast.show();

                    // Update cart badge
                    updateCartBadge(data.cart_count || 0);

                    // Redirect ke halaman keranjang setelah 1.5 detik
                    setTimeout(() => {
                        window.location.href = '{{ route("keranjang.index") }}';
                    }, 1500);
                } else {
                    document.getElementById('toastMessage').textContent = 'Gagal: ' + (data.message || 'Unknown error');
                    toast.show();
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                document.getElementById('toastMessage').textContent = 'Terjadi kesalahan: ' + error.message;
                toast.show();
                button.disabled = false;
                button.innerHTML = originalText;
            });
        });
    });
</script>

@endsection
</body>
</html>
