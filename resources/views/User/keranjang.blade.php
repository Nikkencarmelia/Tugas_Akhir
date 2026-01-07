<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <title>Keranjang</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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

            .search-wrapper {
                border: 1px solid #ced4da;
                border-radius: 0.375rem;
                transition: all 0.2s ease;
                flex: 1;
                max-width: 300px;
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

            .selected-actions {
                display: none;
                background: #f8f9fa;
                padding: 0.75rem 1.5rem;
                border-radius: 8px;
                margin-bottom: 1rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: 1px solid #e9ecef;
                font-size: 14px;
            }

            .selected-actions.show {
                display: flex;
            }

            .selected-count {
                color: #666;
            }

            .delete-selected {
                border-radius: 6px;
                font-size: 12px;
                padding: 4px 10px;
                font-weight: 500;
                line-height: 1.2;
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
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
            }

            .cart-table-header > div:first-child {
                justify-content: flex-start;
                padding-left: 0.25rem;
            }

            .cart-table-header input[type="checkbox"] {
                accent-color: #198754;
                transform: scale(1.1);
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
                margin-top: 0;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
                border: 1px solid #e9ecef;
                position: sticky;
                top: 120px;
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
                content: "\f291";
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

            .btn-outline-danger {
                border-color: #dc3545;
                color: #dc3545;
            }

            .btn-outline-danger:hover {
                background: #dc3545;
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
                    padding: 1.25rem;
                }

                .product-info {
                    width: 100%;
                    justify-content: flex-start;
                }

                .harga, .total {
                    width: 100%;
                    text-align: left;
                    margin-top: 0.25rem;
                    font-size: 0.9rem;
                }

                .qty-box {
                    width: auto;
                    justify-content: flex-start;
                    margin: 0.5rem 0;
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
                    justify-content: flex-start;
                }

                .search-wrapper {
                    max-width: none;
                    width: 100%;
                }

                .checkout-box {
                    margin-top: 2rem;
                    position: static;
                }
            }

            @media (max-width: 480px) {
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
            .back-btn {
                display:flex;
                align-items:center;
                justify-content:center;
                width:40px;
                height:40px;
                margin-right:.5rem;
                color:#6c757d;
                background:transparent;
                font-size:1.5rem;
                text-decoration:none;
                border:none;
                border-radius:.5rem;
                transition:color .2s ease, transform .2s ease;
            }

        </style>
    </head>

    <body>
        @extends('components.user')
        @section('content')

        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">

                    <div class="cart-header d-flex align-items-center justify-content-between">
                        <div class="header-left d-flex align-items-center">
                            <a href="/" class="back-btn" title="Kembali">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                            <h3 class="mb-0">Keranjang Saya</h3>
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

<div class="selected-actions">
                        <span class="selected-count"></span>
                        <button id="deleteSelected" class="btn btn-outline-danger delete-selected">Hapus Terpilih</button>
                    </div>

                    <div class="cart-table-header">
                        <div style="flex: 3">
                            <input type="checkbox" id="selectAllHeader" checked />
                            <span>Produk</span>
                        </div>
                        <div style="flex: 1">Harga</div>
                        <div style="flex: 1">Jumlah</div>
                        <div style="flex: 1">Total</div>
                    </div>

                    @if (count($keranjang) == 0)
                        <div class="text-center py-5">
                            <i class="fa fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Keranjang Anda kosong</h5>
                            <p class="text-muted">Tambahkan produk untuk melihat di sini.</p>
                            <a href="{{ route('produk') }}" class="btn btn-success">Belanja Sekarang</a>
                        </div>
                    @else
                        @foreach ($keranjang as $cartKey => $item)
                        <div class="cart-item"
                             data-id="{{ $cartKey }}"
                             data-product-id="{{ $item['product_id'] }}"
                             data-batch-id="{{ $item['batch_id'] ?? '' }}"
                             data-harga="{{ $item['harga'] }}">
                            <div class="product-info">
                                <input type="checkbox" style="accent-color: #198754;" checked />
                                <img src="{{ $item['gambar'] }}" alt="{{ $item['nama_produk'] }}" />
                                <div class="product-details">
                                    <strong>{{ $item['nama_produk'] }}</strong><br />
                                    <small>{{ $item['satuan_berat'] }}</small>
                                </div>
                            </div>

                            <div class="harga">Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                            <div class="qty-box">
                                <button class="btn-minus" type="button">−</button>
                                <input type="number" class="qty-input" value="{{ $item['quantity'] }}" min="1">
                                <button class="btn-plus" type="button">+</button>
                            </div>

                            <div class="total">Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    @endif
                </div>

<div class="col-lg-4">
                    <div class="checkout-box">
                        <h5>Keranjang Belanja</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Produk</span><span id="total-produk">{{ count($keranjang) }} Produk</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span>Subtotal Harga</span><span id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('beranda') }}" class="btn btn-outline-success w-100">Batal</a>
                            <button type="button" id="checkoutBtn" class="btn btn-success w-100">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

function formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }

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

function updateSelectedActions() {
                const checkboxes = document.querySelectorAll('.cart-item input[type="checkbox"]:checked');
                const count = checkboxes.length;
                const selectedActions = document.querySelector('.selected-actions');
                const selectedCount = document.querySelector('.selected-count');

                if (count > 0) {
                    selectedCount.textContent = `${count} produk dipilih`;
                    selectedActions.classList.add('show');
                } else {
                    selectedActions.classList.remove('show');
                }
            }

function updateQuantity(productId, batchId, quantity) {
                const payload = {
                    product_id: parseInt(productId),
                    quantity: parseInt(quantity)
                };

if (batchId && batchId !== '') {
                    payload.batch_id = parseInt(batchId);
                }

                fetch(`{{ route('keranjang.update') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(payload)
                })
                .then(async response => {
                    const isJson = response.headers.get('content-type')?.includes('application/json');
                    const text = await response.text();

                    try {
                        const data = JSON.parse(text);
                        if (!response.ok || !data.success) {
                            throw new Error(data.message || 'Gagal update quantity');
                        }
                        return data;
                    } catch (e) {

                        console.error('Server Error:', text);
                        throw new Error('Terjadi kesalahan di server (Cek Console).');
                    }
                })
                .then(data => {

                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message);
                    location.reload();
                });
            }

document.querySelectorAll('.btn-plus').forEach(btn => {
                btn.addEventListener('click', function () {
                    const input = this.parentElement.querySelector('.qty-input');
                    const cartItem = this.closest('.cart-item');
                    const productId = cartItem.dataset.productId;
                    const batchId = cartItem.dataset.batchId || null;
                    let newQty = parseInt(input.value) + 1;
                    input.value = newQty;
                    updateQuantity(productId, batchId, newQty);
                    updateTotal();
                });
            });

document.querySelectorAll('.btn-minus').forEach(btn => {
                btn.addEventListener('click', function () {
                    const input = this.parentElement.querySelector('.qty-input');
                    const cartItem = this.closest('.cart-item');
                    const productId = cartItem.dataset.productId;
                    const batchId = cartItem.dataset.batchId || null;
                    if (parseInt(input.value) > 1) {
                        let newQty = parseInt(input.value) - 1;
                        input.value = newQty;
                        updateQuantity(productId, batchId, newQty);
                        updateTotal();
                    }
                });
            });

document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', function() {
                    const cartItem = this.closest('.cart-item');
                    const productId = cartItem.dataset.productId;
                    const batchId = cartItem.dataset.batchId || null;
                    updateQuantity(productId, batchId, parseInt(this.value));
                    updateTotal();
                });
            });

const selectAllHeader = document.getElementById('selectAllHeader');
            selectAllHeader.addEventListener('change', function() {
                const isChecked = this.checked;
                document.querySelectorAll('.cart-item input[type="checkbox"]').forEach(chk => {
                    chk.checked = isChecked;
                });
                updateTotal();
                updateSelectedActions();
            });

document.querySelectorAll('input[type="checkbox"]').forEach(chk => {
                chk.addEventListener('change', function() {
                    updateTotal();

const allCheckboxes = document.querySelectorAll('.cart-item input[type="checkbox"]');
                    const checkedCount = document.querySelectorAll('.cart-item input[type="checkbox"]:checked').length;
                    selectAllHeader.checked = checkedCount === allCheckboxes.length;
                    selectAllHeader.indeterminate = checkedCount > 0 && checkedCount < allCheckboxes.length;

                    updateSelectedActions();
                });
            });

document.getElementById('deleteSelected').addEventListener('click', function() {
                const selectedItems = document.querySelectorAll('.cart-item input[type="checkbox"]:checked');
                if (selectedItems.length === 0) {
                    alert('Pilih item untuk dihapus');
                    return;
                }

                const ids = Array.from(selectedItems).map(chk => chk.closest('.cart-item').dataset.id);

                fetch(`{{ route('keranjang.delete-multiple') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ ids: ids })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        ids.forEach(id => {
                            const item = document.querySelector(`.cart-item[data-id="${id}"]`);
                            if (item) item.remove();
                        });

                        selectAllHeader.checked = false;
                        selectAllHeader.indeterminate = false;
                        updateSelectedActions();
                        updateTotal();
                    } else {
                        alert(data.message || 'Gagal hapus item');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat hapus item');
                });
            });

updateTotal();
            updateSelectedActions();

document.getElementById('checkoutBtn').addEventListener('click', function() {
                const selectedCheckboxes = document.querySelectorAll('.cart-item input[type="checkbox"]:checked');
                if (selectedCheckboxes.length === 0) {
                    alert('Pilih setidaknya satu produk untuk checkout.');
                    return;
                }

                const ids = Array.from(selectedCheckboxes).map(chk => chk.closest('.cart-item').dataset.id);

                const checkoutUrl = new URL('{{ route("pemesanan.checkout") }}', window.location.origin);
                ids.forEach(id => checkoutUrl.searchParams.append('selected_items[]', id));

                window.location.href = checkoutUrl.toString();
            });
        </script>

        @endsection

    </body>
</html>
