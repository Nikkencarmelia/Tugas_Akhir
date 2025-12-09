<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Checkout</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            /* body {
            background-color: #f8f9fa;
            overflow-x: hidden;
            } */

            /* ====== Layout Utama ====== */
            .checkout-container {
                position: relative;
                min-height: 100vh;
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                gap: 2rem;
                margin-top: 0.5rem;
                padding: 0 2rem 2rem;
                box-sizing: border-box;
            }

            /* ====== Card Style ====== */
            .card {
                border-radius: 1rem;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                overflow: hidden;
            }

            /* ====== Focus Effect ====== */
            .form-control:focus,
            .form-select:focus {
                border-color: #198754 !important;
                box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25) !important;
            }

            /* ====== Kiri (Alamat Pengiriman) ====== */
            .left-card .card-body {
                display: flex;
                flex-direction: column;
                height: calc(100vh - 10rem);
                overflow: hidden;
            }
            .left-card .scrollable-content {
                flex: 1;
                overflow-y: auto;
                padding-right: 0.5rem;
            }

            /* ====== Kanan (Rincian Harga) ====== */
            .right-card .card-body {
                display: flex;
                flex-direction: column;
                height: calc(100vh - 10rem);
                overflow: hidden;
                position: relative;
                padding-bottom: 1.5rem; /* dorong ke bawah dikit */
            }

            /* Scroll di bagian produk */
            .products-section {
                flex: 1;
                overflow-y: auto;
                padding-right: 0.5rem;
                padding-bottom: 1rem;
            }

            /* Bagian total sticky */
            .total-section {
                position: sticky;
                bottom: -20px; /* turunin biar nutup area bawah */
                background: #fff;
                border-top: 1px solid #e5e5e5;
                padding: 1.25rem 1rem 1.5rem;
                box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.08);
                z-index: 20;

            }
            /* Tombol buat pesanan biar lebih standout */
            .total-section .btn {
                background: #198754;
                border: none;
                color: #fff;
                font-weight: 600;
                border-radius: 0.5rem;
                width: 100%;
                padding: 0.75rem;
                transition: all 0.2s ease;
            }

            .total-section .btn:hover {
                background: #157347;
                transform: translateY(-2px);
            }

            /* Tambahan halus untuk tampilan harga total */
            .total-section .fw-bold.text-success {
                font-size: 1.1rem;
            }

            /* Scrollbar style */
            .scrollable-content::-webkit-scrollbar,
            .products-section::-webkit-scrollbar {
                width: 6px;
            }

            .scrollable-content::-webkit-scrollbar-thumb,
            .products-section::-webkit-scrollbar-thumb {
                background-color: #D1E7DD;
                border-radius: 10px;
            }

            #pengirimanSection {
                display: none;
            }

            /* ====== Produk Rincian ====== */
            .product-img {
                width: 40px;
                height: 40px;
                object-fit: cover;
                border-radius: 0.25rem;
                margin-right: 0.5rem;
            }
            .item-name {
                font-size: 0.875rem;
                color: #333;
                margin-bottom: 0.25rem;
            }

            .item-detail {
                font-size: 0.75rem;
                color: #666;
            }

            /* ====== Responsif ====== */
            @media (max-width: 991.98px) {
                .checkout-container {
                    flex-direction: column;
                    min-height: auto;
                    padding: 0.5rem;
                }
                .left-card .card-body,
                .right-card .card-body {
                    height: auto;
                }
            }
        </style>

    </head>

    <body>
        @extends('components.user')
        @section('content')
        @php
            usort($checkout, function($a, $b) {
                return strcmp($a['nama_produk'], $b['nama_produk']);
            });
        @endphp
        <div class="container checkout-container">

            <!-- KIRI -->
            <div class="col-12 col-lg-7 left-card">
                <div class="card p-4">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3">Alamat Pengiriman</h4>
                        <div class="scrollable-content">
                            <div class="alert alert-warning text-justify" role="alert" style="text-align: justify;">
                                <i class="fa-solid fa-triangle-exclamation" style="color: orange;"></i>
                                <strong>Catatan:</strong> Kamu akan <strong>membuat pesanan terlebih dahulu.</strong>
                                Pesanan atau biaya pengiriman akan dikonfirmasi oleh <strong>tim purchasing atau kurir</strong>.
                                Setelah <strong>Pesanan atau ongkir penawaranmu</strong> disetujui, kamu akan dapat melanjutkan
                                ke tahap <strong>pembayaran.</strong>
                            </div>

                            <form id="alamatForm">
                                <!-- Pilih alamat tersimpan -->
                                @if(!empty($alamat))
                                <div class="mb-3">
                                    <label class="form-label">Pilih Alamat Tersimpan</label>
                                    <select class="form-select" id="alamatTersimpan">
                                        <option value="">-- Pilih alamat --</option>
                                        @foreach($alamat as $index => $a)
                                            <option value="{{ $index }}">{{ $a['alamat_lengkap'] }} ({{ $a['kecamatan'] }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" id="namaInput" class="form-control" placeholder="Masukkan nama Anda" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="text" id="teleponInput" class="form-control" placeholder="08xxxxxxxxxx" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kecamatan</label>
                                    <select id="kecamatanInput" class="form-select" required>
                                        <option value="">Pilih kecamatan</option>
                                        <option>Kecamatan A</option>
                                        <option>Kecamatan B</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kelurahan</label>
                                    <select id="kelurahanInput" class="form-select" required>
                                        <option value="">Pilih kelurahan</option>
                                        <option>Kelurahan X</option>
                                        <option>Kelurahan Y</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kode Pos</label>
                                    <select id="kodeposInput" class="form-select" required>
                                        <option value="">Pilih kode pos</option>
                                        <option>12345</option>
                                        <option>67890</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea id="alamatLengkapInput" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Opsi Pengiriman</label>
                                    <select class="form-select" id="opsiPengiriman" required>
                                        <option value="">Pilih Pengiriman</option>
                                        <option value="Diantar">Diantar</option>
                                        <option value="Pick Up">Di Pick Up</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="formOngkir" style="display:none;">
                                    <label class="form-label">Masukkan Penawaran Ongkir</label>
                                    <input type="number" class="form-control" placeholder="Rp 0" step="1000" id="ongkirInput">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <!-- KANAN -->
            <div class="col-12 col-lg-5 right-card">
    <div class="card p-4 bg-light shadow-sm">
        <div class="card-body">
            <h4 class="fw-bold mb-3">Rincian Harga</h4>

            <div class="products-section">
                @foreach ($checkout as $item)
                    @php
                        $harga_satuan = $item['harga_satuan'] ?? $item['harga']; // Asumsi ada harga_satuan, atau gunakan harga jika tidak ada
                        $harga_total_item = $item['harga']; // Ini sudah total per item
                    @endphp
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama_produk'] }}" class="product-img" width="40" height="40">
                        <div class="flex-grow-1 ms-2">
                            <div class="item-name">{{ $item['nama_produk'] }}</div>
                            <div class="item-detail">
                                {{ $item['satuan_berat'] }}
                                @if(isset($item['jumlah']))
                                    ({{ $item['jumlah'] }} produk x Rp {{ number_format($harga_satuan, 0, ',', '.') }})
                                @endif
                            </div>
                        </div>
                        <span class="fw-bold">Rp {{ number_format($harga_total_item, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Bagian total-section -->
            <div class="total-section mt-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal • {{ count($checkout) }} item</span>
                    <span id="subtotal">Rp 329.725,00</span>
                </div>

                <!-- Bagian pengiriman disembunyikan dulu -->
                <div id="pengirimanSection">
                    <div class="d-flex justify-content-between">
                        <span>Pengiriman</span>
                        <span id="biayaPengiriman">Rp 10.000</span>
                    </div>
                    <small class="text-muted">Masukkan alamat pengiriman</small>
                </div>

                <div class="d-flex justify-content-between fw-bold mb-3">
                    <span>Total</span>
                    <span class="text-success" id="totalHarga">IDR Rp 329.725,00</span>
                </div>
                <button id="buatPesananBtn" class="btn btn-success w-100">Buat Pesanan</button>
            </div>

        </div>
    </div>
</div>

        </div>

        @endsection

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // ======= Variabel =======
                const form = document.getElementById('alamatForm');
                const selectPengiriman = document.getElementById('opsiPengiriman');
                const formOngkir = document.getElementById('formOngkir');
                const pengirimanSection = document.getElementById('pengirimanSection');
                const ongkirInput = document.getElementById('ongkirInput');
                const buatPesananBtn = document.getElementById('buatPesananBtn');
                const totalHarga = document.getElementById('totalHarga');
                const subtotal = 329725;
                const ongkir = 10000;

                // Tombol awalnya disabled
                buatPesananBtn.disabled = true;

                // Hide awal
                formOngkir.style.display = 'none';
                pengirimanSection.style.display = 'none';

                // ======= Fungsi Update Total =======
                function updateTotal(includeOngkir){
                    const total = includeOngkir ? subtotal + ongkir : subtotal;
                    totalHarga.textContent = "IDR Rp " + total.toLocaleString('id-ID') + ",00";
                }
                updateTotal(false);

                // ======= Validasi Form =======
                function checkFormValidity(){
                    let valid = true;
                    form.querySelectorAll('input, select, textarea').forEach(input => {
                        if(input.hasAttribute('required') && !input.value) valid = false;
                    });
                    buatPesananBtn.disabled = !valid;
                }

                // Event listener semua input/select/textarea
                form.querySelectorAll('input, select, textarea').forEach(el => {
                    el.addEventListener('input', checkFormValidity);
                    el.addEventListener('change', checkFormValidity);
                });

                // ======= Handle Opsi Pengiriman =======
                selectPengiriman.addEventListener('change', function(){
                    if(this.value === 'Diantar'){
                        formOngkir.style.display = 'block';
                        pengirimanSection.style.display = 'block';
                        ongkirInput.setAttribute('required','required');
                        updateTotal(true);
                    } else {
                        formOngkir.style.display = 'none';
                        pengirimanSection.style.display = 'none';
                        ongkirInput.removeAttribute('required');
                        updateTotal(false);
                    }
                    checkFormValidity();
                });

                // ======= Pilih Alamat Tersimpan =======
                const alamatTersimpanSelect = document.getElementById('alamatTersimpan');
                if(alamatTersimpanSelect){
                    const alamatData = @json($alamat);
                    alamatTersimpanSelect.addEventListener('change', function(){
                        const index = this.value;
                        if(index !== ''){
                            const a = alamatData[index];
                            document.getElementById('namaInput').value = a.nama;
                            document.getElementById('teleponInput').value = a.telepon;
                            document.getElementById('kecamatanInput').value = a.kecamatan;
                            document.getElementById('kelurahanInput').value = a.kelurahan;
                            document.getElementById('kodeposInput').value = a.kodepos;
                            document.getElementById('alamatLengkapInput').value = a.alamat_lengkap;

                            // trigger validasi
                            form.querySelectorAll('input, select, textarea').forEach(el => el.dispatchEvent(new Event('change')));
                        } else {
                            // kosongkan form jika pilih default
                            document.getElementById('namaInput').value = '';
                            document.getElementById('teleponInput').value = '';
                            document.getElementById('kecamatanInput').value = '';
                            document.getElementById('kelurahanInput').value = '';
                            document.getElementById('kodeposInput').value = '';
                            document.getElementById('alamatLengkapInput').value = '';
                            checkFormValidity();
                        }
                    });
                }

                // ======= Event Klik Buat Pesanan =======
                buatPesananBtn.addEventListener('click', function(){
                    if(!buatPesananBtn.disabled){
                        localStorage.setItem('showSuccessToast','true');
                        window.location.href = "/riwayat";
                    }
                });

                // ======= Validasi awal =======
                checkFormValidity();
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
