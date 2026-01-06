<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Masuk - Purchasing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f5f7fa; color: #333; }
        .orders-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .orders-header h3 { color: #2a522a; font-weight: 700; margin: 0; display: flex; align-items: center; gap: .5rem; }
        .orders-header h3 i { color: #198754; }
        
        .order-card { background: white; border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.06); transition: .3s; border: 1px solid #f1f3f4; position: relative;}
        .order-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .order-card.hidden { display: none !important; }
        .order-card.selected { border: 2px solid #198754; background-color: #f0fdf4; }

        .order-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef; }
        .order-meta { display: flex; flex-direction: column; font-size: 14px; color: #6c757d; gap: 4px; }
        .order-meta .alamat { background: #e8f5e9; color: #1b5e20; padding: 3px 8px; border-radius: 6px; font-size: 13px; display: inline-block; }
        .order-meta .metode { background: #e3f2fd; color: #0d47a1; padding: 3px 8px; border-radius: 6px; font-size: 13px; display: inline-block; }
        
        /* Unified Delivery & Method Badges */
        .badge-metode { background: #e3f2fd; color: #0d47a1; padding: 4px 10px; border-radius: 8px; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; }
        .badge-alamat { background: #e8f5e9; color: #1b5e20; padding: 4px 10px; border-radius: 8px; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; }
        .badge-kendaraan { background: #fef9c3; color: #854d0e; padding: 4px 10px; border-radius: 8px; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #fde68a; }
        .order-number { font-weight: 600; color: #495057; }

        .order-product { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 12px; }
        .img-container { position: relative; width: 80px; height: 80px; flex-shrink: 0; }
        .img-container img { width: 100%; height: 100%; object-fit: cover; border-radius: 12px; border: 1px solid #dee2e6; }
        .badge-supplier { position: absolute; top: 5px; right: 5px; font-size: .7rem; font-weight: 600; padding: .3rem .55rem; border-radius: .4rem; line-height: 1; z-index: 2; }
        
        .order-product-details h6 { margin-bottom: 0.25rem; font-weight: 600; color: #212529; }
        .produk-lain { font-size: 12px; color: #6c757d; font-style: italic; margin-top: 0.5rem; }

        .order-actions { display: flex; gap: 0.5rem; margin-top: 1rem; flex-wrap: wrap; }
        .select-controls { margin-bottom: 1.5rem; background: #fff; padding: 1rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); }

        .order-status { 
            display: flex; 
            align-items: center; 
            gap: .5rem; 
            padding: 6px 12px; 
            border-radius: 20px; 
            font-size: 13px; 
            font-weight: 500; 
            width: fit-content; 
            margin-bottom: 1rem; 
        }

        /* Status Colors - Synchronized with User History */
        .status-menunggu_konfirmasi { background: #f1f3f5; color: #495057; }
        .status-menunggu_pembayaran { background: #fff4e6; color: #d9480f; }
        .status-diproses { background: #fef9c3; color: #854d0e; }
        .status-dikirim { background: #e0f2fe; color: #0369a1; }
        .status-selesai { background: #dcfce7; color: #166534; }
        .status-dibatalkan { background: #fee2e2; color: #991b1b; }
        .status-verif { background: #fff7ed; color: #9a3412; }
        .status-siap_diambil { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .status-pesanan_telah_diambil { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .status-menunggu_konfirmasi_kurir { background: #fef9c3; color: #854d0e; }

        @media(max-width: 768px) {
            .orders-header, .order-header { flex-direction: column; gap: 1rem; text-align: center; }
            .order-header { align-items: center; }
            .order-product { flex-direction: column; text-align: center; align-items: center; }
            .order-actions { justify-content: center; }
            .select-controls { flex-direction: column; }
            .select-controls .d-flex { flex-direction: column; width: 100%; }
            .select-controls select, .select-controls .input-group { max-width: 100% !important; }
            .order-status { margin: 0 auto 1rem auto; }
        }
    </style>
</head>
<body>

@extends('components.staff_purchasing')
@section('content')
<div class="container py-5">

    <!-- Toast Notification -->
    <div class="toast-container position-fixed top-0 end-0 p-4" style="z-index: 9999;">
        @if(session('success'))
        <div id="toastSuccess" class="toast show text-bg-success border-0 shadow-lg" role="alert" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-semibold"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @endif
        @if(session('error'))
        <div id="toastError" class="toast show text-bg-danger border-0 shadow-lg" role="alert" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-semibold"><i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @endif
    </div>

    <!-- Header -->
    <div class="orders-header">
        <h3><i class="bi bi-bag-check"></i>Pesanan Masuk <span class="badge bg-success ms-2" id="countBadge">{{ count($pengiriman_masuk) }}</span></h3>
        <small class="text-muted">Daftar pesanan yang menunggu konfirmasi</small>
    </div>

    <!-- Controls & Form -->
    <form action="{{ route('staff_purchasing.terima_dipilih') }}" method="POST" id="bulkForm">
        @csrf
        
        <div class="select-controls d-flex flex-column gap-3">
            <!-- Filter Tools -->
            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                <div class="input-group" style="max-width: 400px; flex-grow: 1;">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari pesanan, produk, atau supplier...">
                </div>

                <div class="d-flex gap-2 flex-wrap flex-grow-1 justify-content-end">
                    <select id="sortSelect" class="form-select" style="width: auto;">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                    </select>
                    <select id="metodeSelect" class="form-select" style="width: auto;">
                        <option value="">Semua Pengiriman</option>
                        <option value="pick-up">Pick Up</option>
                        <option value="diantar">Diantar</option>
                    </select>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                    <label class="form-check-label fw-bold" for="selectAll" style="cursor: pointer;">Pilih Semua</label>
                </div>
                
                <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary d-flex align-items-center gap-2" id="btnTerimaDipilih" disabled>
                    <i class="fas fa-check-circle"></i> Terima Dipilih
                </button>
                <button type="button" class="btn btn-outline-danger d-flex align-items-center gap-2" id="btnTolakDipilih" disabled>
                    <i class="fas fa-times-circle"></i> Tolak Dipilih
                </button>
            </div>
        </div>

        <!-- Orders List -->
        <div id="ordersContainer">
            @forelse($pengiriman_masuk as $order)
            @php
                $firstItem = $order->detailPesanan->first();
                $supplier = $firstItem && $firstItem->produk && $firstItem->produk->supplier ? $firstItem->produk->supplier->nama_supplier : 'Non-Supplier';
                $metode = $order->opsi_pengiriman;
                
                $imagePath = $firstItem->gambar ?? '';
                if (str_starts_with($imagePath, 'images/')) {
                    $src = asset($imagePath); // Public images
                } elseif (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/') && $imagePath) {
                    $src = asset('storage/' . $imagePath); // Encoded/Storage images
                } else {
                    $src = $imagePath ? asset($imagePath) : asset('images/default-product.png');
                }
            @endphp

            <div class="order-card"
                data-id="{{ $order->id }}"
                data-date="{{ $order->updated_at->timestamp }}"
                data-product="{{ strtolower($firstItem->nama_produk ?? '') }}"
                data-supplier="{{ strtolower($supplier) }}"
                data-metode="{{ strtolower($metode) }}">
                
                <div class="order-header">
                    <div class="d-flex align-items-start gap-3">
                        <div class="form-check">
                            <input class="form-check-input orderCheckbox" type="checkbox" name="order_ids[]" value="{{ $order->id }}">
                        </div>
                        <div class="order-meta">
                            <div><i class="fa-regular fa-calendar me-2"></i>{{ $order->created_at->format('d M Y, H:i') }}</div>
                            <div class="text-secondary fw-bold">ID: {{ $order->kode_pesanan }}</div>
                            <div>
                                @if($metode == 'dipick_up')
                                    <span class="badge-metode"><i class="bi bi-shop"></i> Pick Up</span>
                                @else
                                    <div class="d-flex flex-wrap gap-1 mb-1">
                                        <span class="badge-metode"><i class="fa-solid fa-truck"></i> Diantar</span>
                                        <span class="badge-alamat"><i class="fa-solid fa-location-dot"></i> {{ $order->nama_kelurahan }}</span>
                                        @if($order->kendaraan)
                                            <span class="badge-kendaraan"><i class="fa-solid fa-truck-pickup"></i> {{ $order->kendaraan }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                                @php
                                    $status = $order->status_pesanan;
                                    $statusClass = 'status-' . $status;
                                    $statusLabel = ucwords(str_replace('_', ' ', $status));
                                    
                                    if(in_array($status, ['dibatalkan', 'ditolak_staff', 'ditolak_kurir'])) {
                                        $statusClass = 'status-dibatalkan';
                                        if($status == 'ditolak_staff') $statusLabel = 'Ditolak Staff';
                                        elseif($status == 'ditolak_kurir') $statusLabel = 'Ditolak Kurir';
                                    }
                                    elseif(in_array($status, ['menunggu_konfirmasi_pembayaran', 'menunggu_verifikasi_pembayaran', 'menunggu_pembayaran_diverifikasi'])) {
                                        $statusClass = 'status-verif';
                                        $statusLabel = 'Menunggu Verifikasi';
                                    }
                                    elseif($status == 'menunggu_konfirmasi_kurir') {
                                        $statusClass = 'status-menunggu_konfirmasi_kurir';
                                        $statusLabel = 'Menunggu Konfirmasi Kurir';
                                    }
                                    elseif($status == 'menunggu_cari_kurir') {
                                        $statusClass = 'status-menunggu_konfirmasi';
                                        $statusLabel = 'Menunggu Cari Kurir';
                                    }
                                    elseif($status == 'menunggu_konfirmasi') {
                                        $statusClass = 'status-menunggu_konfirmasi';
                                        $statusLabel = 'Menunggu Konfirmasi';
                                    }

                                    $icon = 'fa-box';
                                    if($status == 'selesai') $icon = 'fa-check-circle';
                                    elseif($statusClass == 'status-dibatalkan') $icon = 'fa-times-circle';
                                    elseif(in_array($status, ['dikirim', 'sedang_diantar'])) $icon = 'fa-truck';
                                    elseif($statusClass == 'status-menunggu_konfirmasi' || $statusClass == 'status-menunggu_konfirmasi_kurir') $icon = 'fa-hourglass-half';
                                    elseif($statusClass == 'status-verif') $icon = 'fa-clock';
                                    elseif($status == 'menunggu_pembayaran') $icon = 'fa-wallet';
                                    elseif($status == 'siap_diambil') $icon = 'fa-box-open';
                                    elseif($status == 'pesanan_telah_diambil') $icon = 'fa-check-double';
                                @endphp
                                <div class="mt-2">
                                    <span class="order-status {{ $statusClass }} py-1 px-2" style="font-size: 12px; margin: 0; display: inline-flex;">
                                        <i class="fas {{ $icon }}"></i> {{ $statusLabel }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                @if($firstItem)
                <div class="order-product">
                    <div class="img-container">
                        <img src="{{ $src }}" alt="Produk">
                        <span class="badge-supplier">{{ $supplier }}</span>
                    </div>
                    <div class="order-product-details flex-grow-1">
                        <h6>{{ $firstItem->nama_produk }}</h6>
                        <p class="mb-1 text-muted small">
                            {{ $firstItem->quantity }} x Rp {{ number_format($firstItem->harga_satuan, 0, ',', '.') }} 
                            / {{ $firstItem->jumlah_satuan }} {{ $firstItem->satuan }}
                        </p>
                        
                        @if($order->detailPesanan->count() > 1)
                        <div class="produk-lain mb-2">+ {{ $order->detailPesanan->count() - 1 }} produk lain</div>
                        @endif

                        <div class="border-top mt-2 pt-2 small text-muted">
                            <div class="d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Ongkir:</span>
                                <span>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold text-success mt-1">
                                <span>Total:</span>
                                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="order-actions">
                    <button type="button" class="btn btn-success btn-sm btnTerimaSingle" 
                        data-action="{{ route('staff_purchasing.terima_pesanan', $order->id) }}">
                        <i class="fa-solid fa-check me-1"></i>Terima
                    </button>

                     <form action="{{ route('staff_purchasing.tolak_pesanan', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tolak pesanan ini? Stok akan dikembalikan.')">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-xmark me-1"></i>Tolak
                        </button>
                    </form>

                    <a href="{{ route('staff_purchasing.detail_pesanan', $order->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fa-solid fa-eye me-1"></i>Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <img src="{{ asset('images/empty-state.png') }}" alt="Empty" style="width: 150px; opacity: 0.5;">
                <h5 class="text-muted mt-3">Tidak ada pesanan masuk.</h5>
            </div>
            @endforelse
        </div>
    </form>
    
    <!-- Hidden Form for Single Actions -->
    <form id="singleActionForm" method="POST" style="display:none;">
        @csrf
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const sortSelect = document.getElementById('sortSelect');
        const metodeSelect = document.getElementById('metodeSelect');
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.orderCheckbox');
        const cards = document.querySelectorAll('.order-card');
        const ordersContainer = document.getElementById('ordersContainer');
        const countBadge = document.getElementById('countBadge');
        const bulkForm = document.getElementById('bulkForm');
        const btnTerimaDipilih = document.getElementById('btnTerimaDipilih');
        const btnTolakDipilih = document.getElementById('btnTolakDipilih');

        // Colorize Badges
        function colorizeBadges() {
            const badges = document.querySelectorAll('.badge-supplier');
            const colors = [
                { bg: "#BAE6FD", text: "#0369A1" }, { bg: "#FEF9C3", text: "#A16207" },
                { bg: "#FBCFE8", text: "#9D174D" }, { bg: "#A7F3D0", text: "#065F46" },
                { bg: "#DDD6FE", text: "#5B21B6" }, { bg: "#FECACA", text: "#991B1B" },
                { bg: "#FDE68A", text: "#B45309" }, { bg: "#F5D0FE", text: "#86198F" }
            ];

            badges.forEach(badge => {
                const text = badge.textContent.trim().toLowerCase();
                let hash = 0;
                for (let i = 0; i < text.length; i++) hash = text.charCodeAt(i) + ((hash << 5) - hash);
                const color = colors[Math.abs(hash) % colors.length];
                badge.style.setProperty('background-color', color.bg, 'important');
                badge.style.setProperty('color', color.text, 'important');
            });
        }
        colorizeBadges();

        function updateActionButtons() {
            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked && !cb.closest('.order-card').classList.contains('hidden')).length;
            btnTerimaDipilih.disabled = checkedCount === 0;
            btnTolakDipilih.disabled = checkedCount === 0;
        }

        function updateSelectAllState() {
            const visibleCheckboxes = Array.from(checkboxes).filter(cb => !cb.closest('.order-card').classList.contains('hidden'));
            const checkedCount = visibleCheckboxes.filter(cb => cb.checked).length;
            
            selectAll.checked = visibleCheckboxes.length > 0 && checkedCount === visibleCheckboxes.length;
            selectAll.indeterminate = checkedCount > 0 && checkedCount < visibleCheckboxes.length;
            updateActionButtons();
        }

        // Filter & Search Logic
        function filterOrders() {
            const search = searchInput.value.toLowerCase();
            const sort = sortSelect.value;
            const metodeFilter = metodeSelect.value;

            let visibleCount = 0;
            const cardsArray = Array.from(cards);
            
            // Sort
            cardsArray.sort((a, b) => {
                const dateA = parseInt(a.dataset.date);
                const dateB = parseInt(b.dataset.date);
                return sort === 'newest' ? dateB - dateA : dateA - dateB;
            });

            cardsArray.forEach(card => ordersContainer.appendChild(card));

            // Filter
            cardsArray.forEach(card => {
                const text = card.textContent.toLowerCase();
                const metode = card.dataset.metode;
                
                let metodeMatch = true;
                if(metodeFilter === 'pick-up') metodeMatch = (metode === 'dipick_up');
                else if(metodeFilter === 'diantar') metodeMatch = (metode === 'diantar');

                const searchMatch = text.includes(search);

                if (metodeMatch && searchMatch) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                    const cb = card.querySelector('.orderCheckbox');
                    if(cb) cb.checked = false;
                }
            });

            if(countBadge) countBadge.textContent = visibleCount;
            updateSelectAllState();
        }

        // Single Accept Login
        document.querySelectorAll('.btnTerimaSingle').forEach(btn => {
            btn.addEventListener('click', function() {
                window.confirmAction('Apakah Anda yakin ingin menerima pesanan ini?', () => {
                    const form = document.getElementById('singleActionForm');
                    form.action = this.dataset.action;
                    form.submit();
                });
            });
        });

        // Bulk Action Handlers
        btnTerimaDipilih.addEventListener('click', () => {
            window.confirmAction('Apakah Anda yakin ingin menerima pesanan yang dipilih?', () => {
                bulkForm.action = "{{ route('staff_purchasing.terima_dipilih') }}";
                bulkForm.submit();
            });
        });

        btnTolakDipilih.addEventListener('click', () => {
            window.confirmAction('Apakah Anda yakin ingin menolak pesanan yang dipilih?', () => {
                bulkForm.action = "{{ route('staff_purchasing.tolak_dipilih_staff') }}";
                bulkForm.submit();
            });
        });

        // Events
        searchInput.addEventListener('input', filterOrders);
        sortSelect.addEventListener('change', filterOrders);
        metodeSelect.addEventListener('change', filterOrders);

        selectAll.addEventListener('change', function() {
            const visibleCheckboxes = Array.from(checkboxes).filter(cb => !cb.closest('.order-card').classList.contains('hidden'));
            visibleCheckboxes.forEach(cb => {
                cb.checked = this.checked;
                const card = cb.closest('.order-card');
                if(this.checked) card.classList.add('selected');
                else card.classList.remove('selected');
            });
            updateActionButtons();
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const card = this.closest('.order-card');
                if(this.checked) card.classList.add('selected');
                else card.classList.remove('selected');
                updateSelectAllState();
            });
        });
        
        filterOrders();
    });
</script>
@endsection
</body>
</html>
