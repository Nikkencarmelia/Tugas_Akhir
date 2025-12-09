<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Pesanan Anda</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            .orders-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2rem;
                background: white;
                padding: 1.5rem 2rem;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            }

            .orders-header h3 {
                color: #2a522a;
                font-weight: 700;
                margin: 0;
                display: flex;
                align-items: center;
                gap: .5rem;
            }

            .orders-header h3::before {
                content: "\f0b2";
                font-family: "Font Awesome 6 Free";
                font-weight: 900;
                color: #198754;
            }

            .orders-tabs {
                display: flex;
                gap: 1rem;
                align-items: center;
            }

            .orders-tab {
                padding: 8px 16px;
                border-radius: 20px;
                background: #f8f9fa;
                text-decoration: none;
                color: #6c757d;
                font-weight: 500;
                transition: all .3s ease;
                border: 1px solid #e9ecef;
            }

            .orders-tab.active {
                background: #198754;
                color: white;
                border-color: #198754;
            }

            .orders-tab:hover {
                background: #e9ecef;
                color: #495057;
            }

            .order-card {
                background: white;
                border-radius: 16px;
                padding: 1.5rem;
                margin-bottom: 1.5rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
                transition: all .3s ease;
                border: 1px solid #f1f3f4;
            }

            .order-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            }

            .order-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #e9ecef;
            }

            .order-meta {
                display: flex;
                gap: 2rem;
                font-size: 14px;
                color: #6c757d;
            }

            .order-number {
                font-weight: 600;
                color: #495057;
            }

            .order-status {
                display: flex;
                align-items: center;
                gap: .5rem;
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 13px;
                font-weight: 500;
            }

            .status-menunggu {
                background: #e2e3e5;
                color: #6c757d;
                border: 1px solid #dee2e6;
            }

            .status-verif {
                background: #ffcc80; /* orange-100 */
                color: #7a4e00;
                border: 1px solid #ffdda1;
            }

            .status-proses {
                background: #fff3cd;
                color: #856404;
                border: 1px solid #ffeaa7;
            }

            .status-kirim {
                background: #cce5ff;
                color: #004085;
                border: 1px solid #b3d7ff;
            }

            .status-selesai {
                background: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }

            .status-batal {
                background: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }

            .order-product {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1rem;
                padding: 1rem;
                background: #f8f9fa;
                border-radius: 12px;
            }

            .order-product img {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .order-product-details {
                flex-grow: 1;
            }

            .produk-lain {
                font-size: 12px;
                color: #6c757d;
                font-style: italic;
            }

            .order-actions {
                display: flex;
                gap: .5rem;
                margin-top: 1rem;
            }

            .btn-order {
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 14px;
                font-weight: 500;
                transition: all .3s ease;
                border: 1px solid #dee2e6;
            }

            .btn-primary-order {
                background: #007bff;
                color: white;
                border-color: #007bff;
            }

            .btn-primary-order:hover {
                background: #0056b3;
                border-color: #0056b3;
            }

            .btn-secondary-order {
                background: #f8f9fa;
                color: #6c757d;
                border-color: #dee2e6;
            }

            .btn-secondary-order:hover {
                background: #e9ecef;
                color: #495057;
            }

            .btn-outline-success-order {
                color: #198754;
                border-color: #198754;
            }

            .btn-outline-success-order:hover {
                background: #198754;
                color: white;
                border-color: #198754;
            }

            .btn-danger-order {
                background: #dc3545;
                color: white;
                border-color: #dc3545;
            }

            .btn-danger-order:hover {
                background: #c82333;
                border-color: #bd2130;
            }

            .no-orders {
                text-align: center;
                padding: 4rem 2rem;
                color: #6c757d;
            }

            .no-orders i {
                font-size: 4rem;
                color: #dee2e6;
                margin-bottom: 1rem;
            }

            .tab-panel {
                display: none;
            }

            .tab-panel.active {
                display: block;
            }

            @media (max-width: 768px) {
                .orders-header {
                    flex-direction: column;
                    gap: 1rem;
                    text-align: center;
                }

                .orders-tabs {
                    justify-content: center;
                    flex-wrap: wrap;
                }

                .order-header {
                    flex-direction: column;
                    gap: .5rem;
                    align-items: flex-start;
                }

                .order-product {
                    flex-direction: column;
                    text-align: center;
                }

                .order-actions {
                    justify-content: center;
                    flex-wrap: wrap;
                }
            }
        </style>
    </head>

    <body>
        @extends('components.user')
        @section('content')
            <div class="container py-5">

            <!-- Toast -->
                <div class="toast-container position-fixed top-0 end-0 p-4" style="z-index: 9999;">
                    <div id="liveToast" class="toast align-items-center text-bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true"
                        style="min-width: 420px; font-size: 1.1rem; border-radius: 0.75rem;">
                        <div class="d-flex">
                            <div class="toast-body fw-semibold">
                                <i class="fa-solid fa-circle-check me-2"></i>
                                Pesanan berhasil dibuat! Tim purchasing atau kurir akan mengonfirmasi pesanan kamu.
                            </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>

                <div class="orders-header">
                    <h3>Pesanan Anda</h3>
                    <div class="orders-tabs">
                        <a href="#" class="orders-tab active" data-tab="konfirmasi">Menunggu Konfirmasi</a>
                        <a href="#" class="orders-tab" data-tab="menunggu">Menunggu Pembayaran</a>
                        <a href="#" class="orders-tab" data-tab="proses">Diproses</a>
                        <a href="#" class="orders-tab" data-tab="dikirim">Dikirim</a>
                        <a href="#" class="orders-tab" data-tab="selesai">Selesai / Dibatalkan</a>
                    </div>
                </div>

                <div class="tab-content">
                    <!-- Menunggu Konfirmasi -->
                    <div id="konfirmasi" class="tab-panel active">
                        @foreach($konfirmasi_pesanan as $order)
                            <div class="order-card">
                                <div class="order-header">
                                    <div class="order-meta">
                                        <div>Tanggal: {{ date('d M Y', strtotime($order['tanggal'])) }}</div>
                                        <div>Total: {{ $order['total'] }}</div>
                                    </div>
                                    <div class="order-number">#{{ rand(1000000000,9999999999) }}</div>
                                </div>
                                <div class="order-status status-menunggu">
                                    <i class="fas fa-hourglass-half"></i> Menunggu Konfirmasi
                                </div>
                                <div class="order-product">
                                    <img src="{{ asset($order['gambar']) }}" alt="{{ $order['produk'] }}">
                                    <div class="order-product-details">
                                        <h6>{{ $order['produk'] }}</h6>
                                        <small>Jumlah: {{ $order['jumlah'] }}</small>
                                        @if(isset($order['total_produk']) && $order['total_produk'] > 1)
                                            <div class="produk-lain">+ {{ $order['total_produk'] - 1 }} produk lain</div>
                                        @endif
                                        <small>Pesanan sedang dikonfirmasi oleh staf & kurir</small>
                                    </div>
                                </div>
                                <div class="order-actions">
                                    <button class="btn btn-danger-order btn-sm"><i class="fa-solid fa-xmark me-1"></i>Batalkan</button>
                                    <a href="/detail_pesanan" class="btn btn-outline-success-order btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Menunggu Pembayaran -->
                    <div id="menunggu" class="tab-panel">
                        @foreach($menunggu_pembayaran as $order)
                            <div class="order-card">
                                <div class="order-header">
                                    <div class="order-meta">
                                        <div>Tanggal: {{ date('d M Y', strtotime($order['tanggal'])) }}</div>
                                        <div>Total: {{ $order['total'] }}</div>
                                    </div>
                                    <div class="order-number">#{{ rand(1000000000,9999999999) }}</div>
                                </div>
                                <div class="order-status status-menunggu">
                                    <i class="fas fa-money-bill"></i> Menunggu Pembayaran
                                </div>
                                <div class="order-product">
                                    <img src="{{ asset($order['gambar']) }}" alt="{{ $order['produk'] }}">
                                    <div class="order-product-details">
                                        <h6>{{ $order['produk'] }}</h6>
                                        <small>Jumlah: {{ $order['jumlah'] }}</small>
                                        @if(isset($order['total_produk']) && $order['total_produk'] > 1)
                                            <div class="produk-lain">+ {{ $order['total_produk'] - 1 }} produk lain</div>
                                        @endif
                                        <small>Segera lakukan pembayaran untuk memproses pesanan</small>
                                    </div>
                                </div>
                                <div class="order-actions">
                                    <a href="/pembayaran" class="btn btn-primary-order">Bayar Sekarang</a>
                                    <a href="/detail_pesanan" class="btn btn-outline-success-order btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Diproses -->
                    <div id="proses" class="tab-panel">
                        @foreach($diproses as $order)
                            <div class="order-card">
                                <div class="order-header">
                                    <div class="order-meta">
                                        <div>Tanggal: {{ date('d M Y', strtotime($order['tanggal'])) }}</div>
                                        <div>Total: {{ $order['total'] }}</div>
                                    </div>
                                    <div class="order-number">#{{ rand(1000000000,9999999999) }}</div>
                                </div>

                                @if($order['status']=='Menunggu Verifikasi Pembayaran')
                                    <div class="order-status status-verif">
                                        <i class="fas fa-receipt"></i> Menunggu Verifikasi Pembayaran
                                    </div>
                                    <div class="order-product">
                                        <img src="{{ asset($order['gambar']) }}" alt="{{ $order['produk'] }}">
                                        <div class="order-product-details">
                                            <h6>{{ $order['produk'] }}</h6>
                                            <small>Jumlah: {{ $order['jumlah'] }}</small>
                                            @if(isset($order['total_produk']) && $order['total_produk'] > 1)
                                                <div class="produk-lain">+ {{ $order['total_produk'] - 1 }} produk lain</div>
                                            @endif
                                            <small>Pembayaran kamu sedang diverifikasi oleh staf</small>
                                        </div>
                                    </div>
                                @elseif($order['status']=='Menyiapkan Pesanan')
                                    <div class="order-status status-proses">
                                        <i class="fas fa-box"></i> Menyiapkan Pesanan
                                    </div>
                                    <div class="order-product">
                                        <img src="{{ asset($order['gambar']) }}" alt="{{ $order['produk'] }}">
                                        <div class="order-product-details">
                                            <h6>{{ $order['produk'] }}</h6>
                                            <small>Jumlah: {{ $order['jumlah'] }}</small>
                                            @if(isset($order['total_produk']) && $order['total_produk'] > 1)
                                                <div class="produk-lain">+ {{ $order['total_produk'] - 1 }} produk lain</div>
                                            @endif
                                            <small>Pesanan sedang disiapkan oleh tim gudang</small>
                                        </div>
                                    </div>
                                @endif
                                <div class="order-actions">
                                    <a href="/detail_pesanan" class="btn btn-outline-success-order btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Dikirim -->
                    <div id="dikirim" class="tab-panel">
                        @foreach($dikirim as $order)
                            <div class="order-card">
                                <div class="order-header">
                                    <div class="order-meta">
                                        <div>Tanggal: {{ date('d M Y', strtotime($order['tanggal'])) }}</div>
                                        <div>Total: {{ $order['total'] }}</div>
                                    </div>
                                    <div class="order-number">#{{ rand(1000000000,9999999999) }}</div>
                                </div>
                                <div class="order-status status-kirim">
                                    <i class="fas fa-truck"></i> Dikirim
                                </div>
                                <div class="order-product">
                                    <img src="{{ asset($order['gambar']) }}" alt="{{ $order['produk'] }}">
                                    <div class="order-product-details">
                                        <h6>{{ $order['produk'] }}</h6>
                                        <small>Jumlah: {{ $order['jumlah'] }}</small>
                                        @if(isset($order['total_produk']) && $order['total_produk'] > 1)
                                            <div class="produk-lain">+ {{ $order['total_produk'] - 1 }} produk lain</div>
                                        @endif
                                        <small>Pesanan sedang dalam perjalanan</small>
                                    </div>
                                </div>
                                <div class="order-actions">
                                    <button class="btn btn-success btn-sm">Konfirmasi Terima Barang</button>
                                    <a href="/detail_pesanan" class="btn btn-outline-success-order btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Selesai / Dibatalkan -->
                    <div id="selesai" class="tab-panel">
                        @php $combined = array_merge($selesai,$dibatalkan); @endphp
                        @foreach($combined as $order)
                            <div class="order-card">
                                <div class="order-header">
                                    <div class="order-meta">
                                        <div>Tanggal: {{ date('d M Y', strtotime($order['tanggal'])) }}</div>
                                        <div>Total: {{ $order['total'] }}</div>
                                    </div>
                                    <div class="order-number">#{{ rand(1000000000,9999999999) }}</div>
                                </div>
                                @if($order['status']=='Selesai')
                                    <div class="order-status status-selesai">
                                        <i class="fas fa-check-circle"></i> Selesai
                                    </div>
                                @else
                                    <div class="order-status status-batal">
                                        <i class="fas fa-times-circle"></i> Dibatalkan
                                    </div>
                                @endif
                                <div class="order-product">
                                    <img src="{{ asset($order['gambar']) }}" alt="{{ $order['produk'] }}">
                                    <div class="order-product-details">
                                        <h6>{{ $order['produk'] }}</h6>
                                        <small>Jumlah: {{ $order['jumlah'] }}</small>
                                        @if(isset($order['total_produk']) && $order['total_produk'] > 1)
                                            <div class="produk-lain">+ {{ $order['total_produk'] - 1 }} produk lain</div>
                                        @endif
                                        <small>{{ $order['status']=='Selesai'?'Pesanan sudah diterima':'Pesanan dibatalkan oleh sistem' }}</small>
                                    </div>
                                </div>
                                <div class="order-actions">
                                    <a href="/detail_pesanan" class="btn btn-outline-success-order btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    // ================= TAB SWITCHING =================
                    const tabs = document.querySelectorAll('.orders-tab');
                    const panels = document.querySelectorAll('.tab-panel');

                    function activateTab(tabName) {
                        tabs.forEach(t => t.classList.remove('active'));
                        panels.forEach(p => p.classList.remove('active'));

                        const tab = document.querySelector(`.orders-tab[data-tab="${tabName}"]`);
                        const panel = document.getElementById(tabName);
                        if(tab && panel){
                            tab.classList.add('active');
                            panel.classList.add('active');
                        }
                    }

                    tabs.forEach(tab => {
                        tab.addEventListener('click', e => {
                            e.preventDefault();
                            activateTab(tab.dataset.tab);
                            localStorage.setItem('activeTab', tab.dataset.tab);
                        });
                    });

                    // ================= TOAST CHECKOUT =================
                    if(localStorage.getItem('showSuccessToast') === 'true'){
                        const toastEl = document.getElementById('liveToast');
                        const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
                        toast.show();

                        // langsung ke tab menunggu konfirmasi
                        activateTab('konfirmasi');
                        localStorage.setItem('activeTab', 'konfirmasi');

                        localStorage.removeItem('showSuccessToast');
                    }

                    // ================= TOAST PEMBAYARAN =================
                    if(localStorage.getItem('showPaymentToast') === 'true'){
                        const toastDiv = document.createElement('div');
                        toastDiv.className = 'toast align-items-center text-bg-success border-0 shadow-lg show';
                        toastDiv.role = 'alert';
                        toastDiv.setAttribute('aria-live', 'assertive');
                        toastDiv.setAttribute('aria-atomic', 'true');
                        toastDiv.style.cssText = 'min-width:420px;font-size:1.1rem;border-radius:0.75rem;';
                        toastDiv.innerHTML = `
                            <div class="d-flex">
                                <div class="toast-body fw-semibold">
                                    <i class="fa-solid fa-circle-check me-2"></i>
                                    Pembayaran berhasil dikirim! Tim purchasing akan memverifikasi pembayaran kamu, setelah itu akan diproses pesananmu.
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>`;
                        document.querySelector('.toast-container').appendChild(toastDiv);
                        const toast = new bootstrap.Toast(toastDiv, { delay: 5000 });
                        toast.show();

                        // langsung ke tab menunggu pembayaran
                        activateTab('menunggu');
                        localStorage.setItem('activeTab', 'menunggu');

                        localStorage.removeItem('showPaymentToast');
                    }

                    // ================= TAB OTOMATIS SAAT RELOAD =================
                    const activeTab = localStorage.getItem('activeTab');
                    if(activeTab){
                        activateTab(activeTab);
                    }
                });
            </script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @endsection
    </body>
</html>
