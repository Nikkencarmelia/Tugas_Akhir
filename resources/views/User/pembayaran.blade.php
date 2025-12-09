<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Produk</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .checkout-container {
                background-color: #f8f9fa;
            }
            .card {
                border-radius: 12px;
                background: white;
            }
            .form-check-label {
                cursor: pointer;
                padding: 8px 12px;
                border-radius: 8px;
                transition: background-color 0.2s ease;
            }
            .form-check-input:checked + .form-check-label {
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
            }
            .form-control, .form-select {
                border: 1px solid #dee2e6;
                border-radius: 8px;
                padding: 10px 12px;
                transition: border-color 0.2s ease;
            }
            .form-control:focus, .form-select:focus {
                border-color: #198754;
                box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.1);
            }
            .btn-success {
                background-color: #198754;
                border-color: #198754;
                padding: 10px;
            }
            .btn-success:hover {
                background-color: #157347;
                border-color: #157347;
            }
            .product-img {
                object-fit: cover;
                border: 1px solid #dee2e6;
            }
            @media (max-width: 768px) {
                .checkout-container {
                    padding: 1rem;
                }
                .card-body {
                    padding: 1.5rem;
                }
            }

        </style>
    </head>

    <body>
        @extends('components.user')
        @section('content')

        <div class="container checkout-container py-4">
            <div class="row g-4">

                <!-- KIRI: Upload Bukti Pembayaran & Metode -->
                <div class="col-12 col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-semibold mb-3 text-dark">Metode Pembayaran & Upload Bukti</h4>
                            <div class="alert alert-info border-0 bg-light" role="alert">
                                <i class="fa-solid fa-info-circle text-info me-2"></i>
                                <strong>Catatan:</strong> Pilih metode pembayaran, unggah bukti transfer, dan konfirmasi. Pembayaran akan diverifikasi oleh tim dalam 1x24 jam.
                            </div>

                            <form id="pembayaranForm">
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Pilih Metode Pembayaran</label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="metode" id="ewallet" value="ewallet" required>
                                            <label class="form-check-label" for="ewallet">
                                                <i class="fa-solid fa-wallet me-2 text-muted"></i>E-Wallet (GoPay / OVO / Dana)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="metode" id="tfbank" value="tfbank" required>
                                            <label class="form-check-label" for="tfbank">
                                                <i class="fa-solid fa-building-columns me-2 text-muted"></i>Transfer Bank
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail E-Wallet -->
                                <div id="ewalletSection" class="mb-3" style="display: none;">
                                    <label class="form-label fw-medium">Pilih E-Wallet</label>
                                    <select class="form-select border-1 rounded-3" id="ewalletType">
                                        <option value="">Pilih E-Wallet</option>
                                        <option value="gopay">GoPay</option>
                                        <option value="ovo">OVO</option>
                                        <option value="dana">Dana</option>
                                    </select>
                                    <small class="text-muted d-block mt-1">QR Code akan muncul setelah konfirmasi.</small>
                                </div>

                                <!-- Detail Transfer Bank -->
                                <div id="tfSection" class="mb-3" style="display: none;">
                                    <div class="alert alert-light border">
                                        <h6 class="fw-medium mb-2">Detail Rekening Tujuan:</h6>
                                        <p class="mb-1"><strong>Bank: </strong>BRI</p>
                                        <p class="mb-1"><strong>No. Rekening: </strong>1234-5678-9012-3456</p>
                                        <p class="mb-2"><strong>Atas Nama: </strong>Dinas Ketahanan Pangan Kutai Barat</p>
                                        <small class="text-danger">Pastikan transfer sesuai nominal total!</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-medium">Upload Bukti Pembayaran</label>
                                    <input type="file" class="form-control border-1 rounded-3" id="buktiFile" accept="image/*" required>
                                    <small class="text-muted">Upload foto/gambar bukti transfer (max 5MB).</small>
                                    <div id="preview" class="mt-2" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail rounded" style="max-width: 200px; border: 1px solid #dee2e6;">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-medium">Catatan Tambahan (Opsional)</label>
                                    <textarea class="form-control border-1 rounded-3" rows="2" placeholder="Misal: Sudah transfer via ATM pukul 14:30"></textarea>
                                </div>

                                <button type="submit" id="konfirmasiBtn" class="btn btn-success w-100 rounded-3 fw-medium" disabled>Konfirmasi Pembayaran</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- KANAN: Rincian Pesanan -->
                <div class="col-12 col-lg-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-semibold mb-3 text-dark">Rincian Harga Pesanan</h4>
                            <div class="alert alert-warning border-0 bg-warning-subtle">
                                    <small><i class="fa-solid fa-info-circle me-1 text-warning"></i>Total harus dibayar sesuai nominal di atas. Pembayaran akan diverifikasi manual.</small>
                                </div>

                            <div class="products-section mb-4">
                                @php
                                    usort($pembayaran, function($a, $b) {
                                        return strcmp($a['nama_produk'], $b['nama_produk']);
                                    });
                                @endphp
                                @foreach ($pembayaran as $item)
                                    @php
                                        $harga_satuan = $item['harga_satuan'] ?? $item['harga']; // Asumsi ada harga_satuan, atau gunakan harga jika tidak ada
                                        $harga_total_item = $item['harga']; // Ini sudah total per item
                                    @endphp
                                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                        <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama_produk'] }}" class="rounded" width="40" height="40" style="object-fit: cover;">
                                        <div class="flex-grow-1 ms-2">
                                            <div class="fw-medium">{{ $item['nama_produk'] }}</div>
                                            <div class="small text-muted">
                                                {{ $item['satuan_berat'] }}
                                                @if(isset($item['jumlah']))
                                                    ({{ $item['jumlah'] }} produk x Rp {{ number_format($harga_satuan, 0, ',', '.') }})
                                                @endif
                                            </div>
                                        </div>
                                        <span class="fw-bold text-success">Rp {{ number_format($harga_total_item, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Total Section -->
                            <div class="total-section pt-3 border-top">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-medium">Subtotal • {{ count($pembayaran) }} item</span>
                                    <span id="subtotal" class="fw-medium">Rp 329.725</span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fw-medium">Pengiriman</span>
                                    <span id="biayaPengiriman" class="fw-medium">Rp 10.000</span>
                                </div>

                                <div class="d-flex justify-content-between fw-bold fs-5 mb-3 pb-3 border-bottom">
                                    <span>Total</span>
                                    <span class="text-success" id="totalHarga">Rp 339.725</span>
                                </div>



                                <div class="text-center mt-3">
                                    <small class="text-muted">Tanggal: {{ date('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @endsection

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('pembayaranForm');
                const metodeRadios = document.querySelectorAll('input[name="metode"]');
                const ewalletSection = document.getElementById('ewalletSection');
                const tfSection = document.getElementById('tfSection');
                const buktiFile = document.getElementById('buktiFile');
                const preview = document.getElementById('preview');
                const previewImg = document.getElementById('previewImg');
                const konfirmasiBtn = document.getElementById('konfirmasiBtn');
                const subtotal = 329725;
                const ongkir = 10000;
                const total = subtotal + ongkir;

                document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                document.getElementById('biayaPengiriman').textContent = 'Rp ' + ongkir.toLocaleString('id-ID');
                document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');

                konfirmasiBtn.disabled = true;

                metodeRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        ewalletSection.style.display = this.value === 'ewallet' ? 'block' : 'none';
                        tfSection.style.display = this.value === 'tfbank' ? 'block' : 'none';
                        checkFormValidity();
                    });
                });

                buktiFile.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        if (file.size > 5 * 1024 * 1024) {
                            alert('File terlalu besar! Maksimal 5MB.');
                            this.value = '';
                            return;
                        }
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                        checkFormValidity();
                    }
                });

                function checkFormValidity() {
                    const metodeSelected = document.querySelector('input[name="metode"]:checked');
                    const ewalletSelected = document.getElementById('ewalletType').value;
                    const buktiSelected = buktiFile.files.length > 0;
                    let valid = metodeSelected && buktiSelected;

                    if (metodeSelected && metodeSelected.value === 'ewallet') {
                        valid = valid && ewalletSelected;
                    }

                    konfirmasiBtn.disabled = !valid;
                    konfirmasiBtn.textContent = valid ? 'Konfirmasi Pembayaran' : 'Lengkapi Form';
                }

                document.getElementById('ewalletType').addEventListener('change', checkFormValidity);

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (!konfirmasiBtn.disabled) {
                        // Simpan info toast & tab yang harus dibuka
                        localStorage.setItem('showPaymentToast', 'true');
                        localStorage.setItem('activeTab', 'proses');
                        window.location.href = "/riwayat";
                    }
                });

                checkFormValidity();
            });
        </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
