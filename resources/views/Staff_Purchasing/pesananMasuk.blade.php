<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Masuk - purchasing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f5f7fa; }
        .orders-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;background:white;padding:1.5rem 2rem;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.08);}
        .orders-header h3{color:#2a522a;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;}
        .orders-header h3 i{color:#198754;}
        .order-card{background:white;border-radius:16px;padding:1.5rem;margin-bottom:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.06);transition:.3s;border:1px solid #f1f3f4;}
        .order-card:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(0,0,0,0.1);}
        .order-card.hidden{display:none!important;}
        .order-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid #e9ecef;}
        .order-meta{display:flex;flex-direction:column;font-size:14px;color:#6c757d;}
        .order-meta .alamat{background:#e8f5e9;color:#1b5e20;padding:3px 8px;border-radius:6px;margin-top:4px;font-size:13px;}
        .order-meta .metode{background:#e3f2fd;color:#0d47a1;padding:3px 8px;border-radius:6px;margin-top:4px;font-size:13px;}
        .order-number{font-weight:600;color:#495057;}
        .order-product{display:flex;align-items:center;gap:1rem;margin-bottom:1rem;padding:1rem;background:#f8f9fa;border-radius:12px;}
        .order-product img{width:80px;height:80px;object-fit:cover;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
        .produk-lain{font-size:12px;color:#6c757d;font-style:italic;}
        .img-container{position:relative;width:80px;height:80px;}
        .img-container img{width:80px;height:80px;object-fit:cover;border-radius:12px;border:1px solid #f1f3f4;}
        .badge-supplier{position:absolute;top:5px;right:5px;font-size:.7rem;font-weight:600;padding:.3rem .55rem;border-radius:.4rem;}
        .order-actions{display:flex;gap:.5rem;margin-top:1rem;flex-wrap:wrap;}
        .select-controls{margin-bottom:1rem;}
        @media(max-width:768px){
            .orders-header{flex-direction:column;gap:1rem;text-align:center}
            .order-header{flex-direction:column;gap:.5rem;align-items:flex-start}
            .order-product{flex-direction:column;text-align:center}
            .order-actions{justify-content:center}
        }
    </style>
</head>
<body>

@extends('components.staff_purchasing')
@section('content')
<div class="container py-5">

<!-- Toast -->
<div class="toast-container position-fixed top-0 end-0 p-4" style="z-index:9999;">
    <div id="toastSuccess" class="toast text-bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" style="min-width:380px;border-radius:0.75rem;">
        <div class="d-flex">
            <div class="toast-body fw-semibold"><i class="fa-solid fa-circle-check me-2"></i>Pesanan telah diterima!</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<!-- Header -->
<div class="orders-header">
    <h3><i class="bi bi-bag-check"></i>Pesanan Masuk <span class="badge bg-success ms-2">{{ count($pengiriman_masuk) }}</span></h3>
    <small class="text-muted">Daftar pesanan yang menunggu konfirmasi</small>
</div>

<!-- FILTER + SELECT ALL -->
<div class="select-controls d-flex flex-column gap-2 mb-3">

    <!-- Row 1: Search + Urut + Metode Pengiriman -->
    <div class="d-flex flex-wrap align-items-center gap-2">
        <div class="input-group" style="max-width:500px;">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="searchInput" class="form-control" placeholder="Cari produk, supplier, atau alamat...">
        </div>

        <select id="sortSelect" class="form-select" style="max-width:340px;">
            <option value="newest">Urutkan: Terbaru</option>
            <option value="oldest">Urutkan: Terlama</option>
        </select>

        <select id="metodeSelect" class="form-select" style="max-width:340px;">
            <option value="">Semua Metode Pengiriman</option>
            <option value="pick-up">Pick-up</option>
            <option value="diantar">Diantar</option>
        </select>
    </div>

    <!-- Row 2: Pilih semua + Terima semua -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <div class="form-check m-0">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label fw-semibold" for="selectAll">Pilih Semua</label>
            </div>
        </div>

        <button class="btn btn-success" id="btnTerimaSemua">
            <i class="fa-solid fa-check me-1"></i>Terima Semua
        </button>
    </div>
</div>

<!-- ORDER LIST -->
<div id="ordersContainer">
@foreach($pengiriman_masuk as $order)
@php
    $subtotal = $order['total_produk_harga'];
    $ongkir_clean = str_replace(['Rp ', '.'], ['', ''], $order['ongkir']);
    $ongkir_num = (int) $ongkir_clean;
    $total = $subtotal + $ongkir_num;
    $metode_pengiriman = isset($order['metode_pengiriman']) ? $order['metode_pengiriman'] : 'pick-up'; // Default jika belum ada di data
@endphp

<div class="order-card"
    data-date="{{ strtotime($order['tanggal']) }}"
    data-product="{{ strtolower($order['produk']) }}"
    data-supplier="{{ strtolower($order['supplier']) }}"
    data-address="{{ strtolower($order['alamat']) }}"
    data-metode="{{ strtolower($metode_pengiriman) }}">

    <div class="order-header">
        <div class="d-flex align-items-start gap-2">
            <div class="form-check">
                <input class="form-check-input orderCheckbox" type="checkbox">
            </div>

            <div class="order-meta">
                <div><i class="fa-regular fa-calendar me-1"></i>{{ date('d M Y', strtotime($order['tanggal'])) }}</div>
                <div class="fw-semibold"><i class="fa-solid fa-tag me-1"></i> Sub Total: Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                <div class="text-success fw-semibold"><i class="fa-solid fa-truck me-1"></i> Ongkir: {{ $order['ongkir'] }}</div>
                <div class="fw-bold"><i class="fa-solid fa-calculator me-1"></i> Total: Rp {{ number_format($total, 0, ',', '.') }}</div>
                <div class="alamat"><i class="fa-solid fa-location-dot me-1"></i>{{ $order['alamat'] }}</div>
                <div class="metode">
                    @if($metode_pengiriman == 'pick-up')
                        <i class="bi bi-shop me-1"></i>
                    @else
                        <i class="fa-solid fa-truck"></i>
                    @endif
                    Metode: {{ ucfirst($metode_pengiriman) }}
                </div>
            </div>
        </div>

        <div class="order-number">#{{ rand(1000000000,9999999999) }}</div>
    </div>

    <div class="order-product">
        <div class="img-container">
            <img src="{{ asset($order['gambar']) }}" alt="{{ $order['produk'] }}">
            <span class="badge-supplier">{{ $order['supplier'] }}</span>
        </div>

        <div class="order-product-details">
            <h6>{{ $order['produk'] }}</h6>
            <small>Jumlah: {{ $order['jumlah'] }}</small>
            @if(isset($order['total_produk']) && $order['total_produk'] > 1)
            <div class="produk-lain">+ {{ $order['total_produk'] - 1 }} produk lain</div>
            @endif
        </div>
    </div>

    <div class="order-actions">
        <button class="btn btn-success btnTerima"><i class="fa-solid fa-check me-1"></i>Terima</button>
        <a href="/purchasing/detail_pesanan" class="btn btn-outline-success"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
    </div>

</div>
@endforeach
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    const toastSuccess = new bootstrap.Toast(document.getElementById('toastSuccess'), { delay: 3000 });

    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.orderCheckbox');
    const btnTerimaSemua = document.getElementById('btnTerimaSemua');

    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const metodeSelect = document.getElementById('metodeSelect');
    const ordersContainer = document.getElementById('ordersContainer');
    const orderCards = document.querySelectorAll('.order-card');

    document.querySelectorAll('.btnTerima').forEach(btn =>
        btn.addEventListener('click', () => toastSuccess.show())
    );

    selectAll.addEventListener('change', () =>
        checkboxes.forEach(cb => cb.checked = selectAll.checked)
    );

    btnTerimaSemua.addEventListener('click', () => {
        if ([...checkboxes].filter(cb => cb.checked).length > 0) toastSuccess.show();
    });

    function colorizeBadges() {
        const badges = document.querySelectorAll('.badge-supplier');
        const colorPairs = [
            { bg: "#BAE6FD", text: "#0369A1" },
            { bg: "#FEF9C3", text: "#A16207" },
            { bg: "#FBCFE8", text: "#9D174D" },
            { bg: "#A7F3D0", text: "#065F46" },
            { bg: "#DDD6FE", text: "#5B21B6" },
            { bg: "#FECACA", text: "#991B1B" },
            { bg: "#FDE68A", text: "#B45309" },
            { bg: "#F5D0FE", text: "#86198F" }
        ];

        badges.forEach(badge => {
            const text = badge.textContent.trim().toLowerCase();
            let hash = 0;
            for (let i = 0; i < text.length; i++) hash = text.charCodeAt(i) + ((hash << 5) - hash);
            const color = colorPairs[Math.abs(hash) % colorPairs.length];
            badge.style.backgroundColor = color.bg;
            badge.style.color = color.text;
        });
    }
    colorizeBadges();

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const metodeTerm = metodeSelect.value.toLowerCase();

        orderCards.forEach(card => {
            const product = (card.dataset.product || '').toLowerCase();
            const supplier = (card.dataset.supplier || '').toLowerCase();
            const address = (card.dataset.address || '').toLowerCase();
            const metode = (card.dataset.metode || '').toLowerCase();

            const searchMatch = !searchTerm || product.includes(searchTerm) || supplier.includes(searchTerm) || address.includes(searchTerm);
            const metodeMatch = !metodeTerm || metode.includes(metodeTerm);

            const matches = searchMatch && metodeMatch;
            card.classList.toggle('hidden', !matches);
        });
        updateSelectAll();
        applySort();
    }

    searchInput.addEventListener('input', applyFilters);

    metodeSelect.addEventListener('change', applyFilters);

    sortSelect.addEventListener('change', () => applySort());

    function applySort() {
        const visibleCards = [...orderCards].filter(card => !card.classList.contains('hidden'));
        const sortOrder = sortSelect.value === 'newest' ? -1 : 1;

        visibleCards.sort((a, b) =>
            (parseInt(a.dataset.date) - parseInt(b.dataset.date)) * sortOrder
        );

        visibleCards.forEach(card => ordersContainer.appendChild(card));
    }

    function updateSelectAll() {
        const visibleCheckboxes = [...checkboxes].filter(cb =>
            !cb.closest('.order-card').classList.contains('hidden')
        );

        const allVisibleChecked =
            visibleCheckboxes.length > 0 && visibleCheckboxes.every(cb => cb.checked);

        selectAll.checked = allVisibleChecked;
        selectAll.indeterminate =
            visibleCheckboxes.some(cb => cb.checked) && !allVisibleChecked;
    }

    applyFilters();
});
</script>

@endsection
</body>
</html>
