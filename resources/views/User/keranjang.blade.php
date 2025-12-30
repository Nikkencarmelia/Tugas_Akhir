<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <title>Keranjang</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

        <style>

            .cart-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2rem;
                background: white;
                padding: 1.5rem 2rem;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            }

            .cart-header h3 {
                font-weight: 700;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .header-left {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .cart-actions {
                display: flex;
                gap: 0.25rem;
            }

            .cart-actions .btn {
                border-radius: 12px;
                font-size: 12px;
                padding: 6px 12px;
                font-weight: 500;
                line-height: 1.2;
                min-width: auto;
            }

            .cart-actions .btn-outline-success {
                border-color: #198754;
                color: #198754;
            }

            .cart-actions .btn-outline-success:hover {
                background: #198754;
                color: white;
            }

            .cart-actions .btn-outline-danger {
                border-color: #dc3545;
                color: #dc3545;
            }

            .cart-actions .btn-outline-danger:hover {
                background: #dc3545;
                color: white;
            }

            .search-wrapper {
                border: 1px solid #ced4da; /* abu tipis bawaan Bootstrap */
                border-radius: 0.375rem;
                transition: all 0.2s ease;
                flex: 1;
                max-width: 300px;
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

            .cart-table-header {
                display: flex;
                justify-content: space-between;
                border-radius: 12px;
                padding: 1rem 1.5rem;
                font-weight: 600;
                color: #495057;
                margin-bottom: 1rem;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                background: white;
            }

            .cart-table-header > div {
                text-align: center;
                font-size: 14px;
            }

            .cart-item {
                background: white;
                border-radius: 16px;
                padding: 1.5rem;
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
                transition: all 0.3s ease;
                border: 1px solid #f1f3f4;
            }

            .cart-item:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            }

            .product-info {
                display: flex;
                align-items: center;
                gap: 1rem;
                flex: 3;
            }

            .product-info input[type="checkbox"] {
                transform: scale(1.2);
                accent-color: #198754;
            }

            .product-info img {
                width: 70px;
                height: 70px;
                object-fit: cover;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .product-details strong {
                font-size: 16px;
                color: #212529;
                display: block;
            }

            .product-details small {
                color: #6c757d;
                font-size: 13px;
            }

            .qty-box {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
            }

            .qty-input {
                width: 60px;
                text-align: center;
                border: 1px solid #ced4da;
                border-radius: 6px;
            }

            .btn-minus, .btn-plus {
                width: 36px;
                height: 36px;
                border-radius: 6px;
                border: 1px solid #198754;
                background: transparent;
                color: #198754;
                font-size: 18px;
                font-weight: bold;
                transition: all 0.2s ease;
            }

            .btn-minus:hover, .btn-plus:hover {
                background: #198754;
                color: white;
            }

            .harga, .total {
                flex: 1;
                font-weight: 600;
                color: #198754;
                text-align: center;
            }

            .checkout-box {
                background: linear-gradient(135deg, white 0%, #f8f9fa 100%);
                border-radius: 16px;
                padding: 2rem;
                margin-top: 0; /* Hapus margin top biar nempel */
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
                border: 1px solid #e9ecef;
                position: sticky;
                top: 120px; /* Adjust sesuai navbar */
            }

            .checkout-box h5 {
                font-weight: 700;
                color: #2a522a;
                margin-bottom: 1.5rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .checkout-box h5::before {
                content: "\f291"; /* FA icon tag */
                font-family: "Font Awesome 6 Free";
                font-weight: 900;
                color: #198754;
            }

            .checkout-box .d-flex {
                font-size: 16px;
                margin-bottom: 0.5rem;
                padding: 0.5rem 0;
                border-bottom: 1px solid #e9ecef;
            }

            .btn {
                border-radius: 25px;
                font-weight: 600;
                padding: 12px 24px;
                transition: all 0.3s ease;
            }

            .btn-success {
                background: linear-gradient(135deg, #198754 0%, #157347 100%);
                border: none;
            }

            .btn-success:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 15px rgba(25, 135, 84, 0.4);
            }

            .btn-outline-success {
                border-color: #198754;
                color: #198754;
            }

            .btn-outline-success:hover {
                background: #198754;
                color: white;
            }

            @media (max-width: 768px) {
                .cart-table-header {
                    display: none;
                }

                .cart-item {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1rem;
                    padding: 1.5rem;
                }

                .product-info {
                    width: 100%;
                    justify-content: flex-start;
                }

                .harga, .qty-box, .total {
                    width: 100%;
                    text-align: left;
                    margin-top: 0.5rem;
                }

                .search-form {
                    width: 100%;
                    margin-top: 1rem;
                }

                .cart-header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1rem;
                }

                .header-left {
                    width: 100%;
                    justify-content: space-between;
                }

                .cart-actions {
                    order: 3;
                    width: 100%;
                    justify-content: flex-start;
                }

                .search-wrapper {
                    max-width: none;
                    order: 2;
                }

                .checkout-box {
                    margin-top: 2rem;
                    position: static;
                }
            }
        </style>
    </head>

    <body>
        @extends('components.user')
        @section('content')

        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">

                    <div class="cart-header">
                        <div class="header-left">
                            <h3>Keranjang Saya</h3>
                            <div class="cart-actions">
                                <button id="selectAll" class="btn btn-outline-success">Pilih Semua</button>
                                <button id="deleteAll" class="btn btn-outline-danger">Hapus Semua</button>
                            </div>
                        </div>
                        <form class="d-flex search-form" role="search">
                            <div class="input-group search-wrapper">
                                <input type="text" class="form-control" placeholder="Cari produk..." aria-label="Search">
                                <button class="input-group-text border-start-0" type="submit">
                                <i class="fa fa-search text-muted"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="cart-table-header">
                        <div style="flex: 3">Produk</div>
                        <div style="flex: 1">Harga</div>
                        <div style="flex: 1">Jumlah</div>
                        <div style="flex: 1">Total</div>
                    </div>

                    @if (count($keranjang) == 0)
                        <div class="text-center py-5">
                            <i class="fa fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Keranjang Anda kosong</h5>
                            <p class="text-muted">Tambahkan produk untuk melihat di sini.</p>
                            <a href="/produk" class="btn btn-success">Belanja Sekarang</a>
                        </div>
                    @else
                        @foreach ($keranjang as $item)
                        <div class="cart-item" data-harga="{{ $item['harga'] }}">
                            <div class="product-info">
                                <input type="checkbox" style="accent-color: #198754;" checked />
                                <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama_produk'] }}" />
                                <div class="product-details">
                                    <strong>{{ $item['nama_produk'] }}</strong><br />
                                    <small>{{ $item['satuan_berat'] }}</small>
                                </div>
                            </div>

                            <div class="harga">Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                            <div class="qty-box">
                                <button class="btn-minus">−</button>
                                <input type="number" class="qty-input" value="1" min="1">
                                <button class="btn-plus">+</button>
                            </div>

                            <div class="total">Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    @endif
                </div>

                {{-- Checkout Box --}}
                <div class="col-lg-4">
                    <div class="checkout-box">
                        <h5>Keranjang Belanja</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Produk</span><span id="total-produk">{{ count($keranjang) }} Produk</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span>Subtotal Harga</span><span id="subtotal">Rp 0</span>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="/" class="btn btn-outline-success w-100">Batal</a>
                            <a href="/checkout" class="btn btn-success w-100">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Format angka jadi Rupiah
            function formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }

            // Update total harga dan jumlah produk
            function updateTotal() {
                let subtotal = 0;
                let totalProduk = 0;

                document.querySelectorAll('.cart-item').forEach(item => {
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    const harga = parseInt(item.dataset.harga);
                    const qty = parseInt(item.querySelector('.qty-input').value);
                    const total = harga * qty;

                    item.querySelector('.total').textContent = formatRupiah(total);

                    if (checkbox.checked) {
                        subtotal += total;
                        totalProduk++;
                    }
                });

                document.getElementById('subtotal').textContent = formatRupiah(subtotal);
                document.getElementById('total-produk').textContent = totalProduk + ' Produk';
            }

            // Tombol tambah qty
            document.querySelectorAll('.btn-plus').forEach(btn => {
                btn.addEventListener('click', function () {
                    const input = this.parentElement.querySelector('.qty-input');
                    input.value = parseInt(input.value) + 1;
                    updateTotal();
                });
            });

            // Tombol kurang qty
            document.querySelectorAll('.btn-minus').forEach(btn => {
                btn.addEventListener('click', function () {
                    const input = this.parentElement.querySelector('.qty-input');
                    if (parseInt(input.value) > 1) {
                        input.value = parseInt(input.value) - 1;
                        updateTotal();
                    }
                });
            });

            // Update total saat checkbox dicentang / dihapus
            document.querySelectorAll('input[type="checkbox"]').forEach(chk => {
                chk.addEventListener('change', updateTotal);
            });

            // Update total kalau user ubah angka qty manual
            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('input', updateTotal);
            });

            // Button Pilih Semua
            document.getElementById('selectAll').addEventListener('click', function() {
                document.querySelectorAll('input[type="checkbox"]').forEach(chk => {
                    chk.checked = true;
                });
                updateTotal();
            });

            // Button Hapus Semua (uncheck semua, sehingga tidak terhitung di checkout)
            document.getElementById('deleteAll').addEventListener('click', function() {
                document.querySelectorAll('input[type="checkbox"]').forEach(chk => {
                    chk.checked = false;
                });
                updateTotal();
            });

            // Inisialisasi subtotal awal
            updateTotal();
        </script>

        @endsection

    </body>
</html>
