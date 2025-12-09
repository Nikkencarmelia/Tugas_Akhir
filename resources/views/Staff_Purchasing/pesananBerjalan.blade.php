<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan yang Berjalan - purchasing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f5f7fa; }
        .orders-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;background:white;padding:1.5rem 2rem;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.08);}
        .orders-header h3{color:#2a522a;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;}
        .orders-header h3 i { color: #198754; }
        .order-card{background:white;border-radius:16px;padding:1.5rem;margin-bottom:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.06);transition:all .3s ease;border:1px solid #f1f3f4;}
        .order-card:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(0,0,0,0.1);}
        .order-card.hidden { display: none !important; }
        .order-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid #e9ecef;}
        .order-meta{display:flex;flex-direction:column;font-size:14px;color:#6c757d;}
        .order-meta .alamat{background:#e8f5e9;color:#1b5e20;padding:3px 8px;border-radius:6px;display:inline-block;margin-top:4px;font-size:13px;}
        .order-meta .metode{background:#e3f2fd;color:#0d47a1;padding:3px 8px;border-radius:6px;margin-top:4px;font-size:13px;}
        .order-number{font-weight:600;color:#495057;}
        .order-product{display:flex;align-items:center;gap:1rem;margin-bottom:1rem;padding:1rem;background:#f8f9fa;border-radius:12px;}
        .order-product img{width:80px;height:80px;object-fit:cover;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
        .order-product-details { flex-grow: 1; }
        .produk-lain { font-size: 12px; color: #6c757d; font-style: italic; }

        /* Badge Supplier Styles */
        .img-container { position: relative; width: 80px; height: 80px; }
        .img-container img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #f1f3f4; }
        .badge-supplier {
        position: absolute; top: 5px; right: 5px;
        font-size: .7rem; font-weight: 600;
        padding: .3rem .55rem; border-radius: .4rem; line-height: 1;
        }

        .order-actions{display:flex;gap:.5rem;margin-top:1rem;flex-wrap:wrap;}
        .btn-order{padding:6px 14px;border-radius:20px;font-size:13px;font-weight:500;transition:all .3s ease;}
        .btn-primary-order{background:#198754;color:white;border:1px solid #198754;}
        .btn-primary-order:hover{background:#146c43;border-color:#146c43;}
        .btn-secondary-order{background:#f8f9fa;color:#495057;border:1px solid #dee2e6;}
        .btn-secondary-order:hover{background:#e9ecef;color:#212529;}
        .select-controls{display:flex;justify-content:flex-start;align-items:center;margin-bottom:1rem;gap:1rem;flex-wrap:nowrap;overflow:hidden;}
        .order-status{display:flex;align-items:center;gap:.5rem;padding:6px 12px;border-radius:20px;font-size:13px;font-weight:500;margin-bottom:1rem;}
        .status-menyiapkan-pesanan{background:#fff3cd;color:#856404;border:1px solid #ffeaa7;}
        .status-siap-diambil-dikirim{background:#cce5ff;color:#004085;border:1px solid #b3d7ff;}
        .status-menunggu-pembayaran{background:#fff3cd;color:#856404;border:1px solid #ffeaa7;}
        @media(max-width:768px){.orders-header{flex-direction:column;gap:1rem;text-align:center}.order-header{flex-direction:column;gap:.5rem;align-items:flex-start}.order-product{flex-direction:column;text-align:center}.order-actions{justify-content:center}.select-controls{flex-wrap:wrap;gap:0.5rem;justify-content:flex-start;}.select-controls .input-group{max-width:200px !important;}.select-controls .form-select{max-width:140px !important;}}

        /* Modern Modal Styles */
        .modal-content {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: none;
            overflow: hidden;
        }
        .modal-header {
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
            border-bottom: none;
            padding: 1.5rem 2rem;
            border-radius: 20px 20px 0 0 !important;
        }
        .modal-header .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }
        .modal-header .btn-close:hover {
            opacity: 1;
        }
        .modal-title {
            font-weight: 600;
            font-size: 1.25rem;
        }
        .modal-body {
            padding: 2rem;
            background: #fafbfc;
        }
        .modal-body .form-label {
            font-weight: 500;
            color: #495057;
            font-size: 0.875rem;
        }
        .modal-body .form-control, .modal-body .form-select {
            border-radius: 10px;
            border: 1px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }
        .modal-body .form-control:focus, .modal-body .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.1);
        }
        .table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .table thead th {
            background: #f8f9fa;
            border: none;
            font-weight: 600;
            color: #495057;
            padding: 1rem;
            border-bottom: 2px solid #e9ecef;
        }
        .table tbody tr {
            transition: background-color 0.2s ease;
        }
        .table tbody tr:hover {
            background: #f8f9fa;
        }
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #f1f3f4;
        }
        .btn-primary {
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
        }
        .modal-footer {
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            padding: 1.5rem 2rem;
            border-radius: 0 0 20px 20px;
        }

        /* Custom Tab Buttons Style */
        .orders-tabs{display:flex;gap:1rem;align-items:center;flex-wrap:wrap;}
        .orders-tab{padding:8px 16px;border-radius:20px;background:#ffffff;text-decoration:none;color:#6c757d;font-weight:500;border:1px solid #e9ecef;transition:all .3s ease;}
        .orders-tab.active{background:#198754;color:white;border-color:#198754;}
        .orders-tab.active .badge { color: white !important; }
        .orders-tab:hover{background:#e9ecef;color:#495057;}
        .tab-panel{display:none;}
        .tab-panel.active{display:block;}
    </style>
</head>

<body>
@extends('components.staff_purchasing')
@section('content')
<div class="container py-5">

<div class="toast-container position-fixed top-0 end-0 p-4" style="z-index:9999;">
    <div id="toastSiapDiambil" class="toast align-items-center text-bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" style="min-width:380px;font-size:1rem;border-radius:0.75rem;">
    <div class="d-flex"><div class="toast-body fw-semibold"><i class="fa-solid fa-circle-check me-2"></i>Pesanan siap diambil!</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
    </div>
    <div id="toastSudahDiambil" class="toast align-items-center text-bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" style="min-width:380px;font-size:1rem;border-radius:0.75rem;">
    <div class="d-flex"><div class="toast-body fw-semibold"><i class="fa-solid fa-truck me-2"></i>Pesanan sudah diambil dan dikirim!</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
    </div>
</div>

<div class="orders-header">
    <h3><i class="fa fa-truck"></i>Pesanan yang Berjalan</h3>
    <div class="orders-tabs">
        <a href="#" class="orders-tab active" data-tab="pesanan-berjalan">Pesanan Sedang Berjalan <span class="badge bg-success">{{ count($pesananBerjalan ?? []) }}</span></a>
        <a href="#" class="orders-tab" data-tab="siap-diambil">Siap Diambil <span class="badge bg-success">{{ count($siapDiambil ?? []) }}</span></a>
        <a href="#" class="orders-tab" data-tab="menunggu-pembayaran">Menunggu Pembayaran <span class="badge bg-success">{{ count($menungguPembayaran ?? []) }}</span></a>
    </div>
</div>

<div class="select-controls mb-3 d-flex align-items-center gap-2">

    <!-- Search -->
    <div class="input-group" style="max-width: 500px; flex-shrink: 0;">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" id="searchInput" class="form-control" placeholder="Cari produk, supplier, atau alamat...">
    </div>

    <!-- Sort -->
    <select id="sortSelect" class="form-select" style="max-width: 340px; flex-shrink: 0;">
        <option value="newest">Urutkan: Terbaru</option>
        <option value="oldest">Urutkan: Terlama</option>
    </select>

    <!-- Metode Pengiriman Filter -->
    <select id="metodeSelect" class="form-select" style="max-width: 340px; flex-shrink: 0;">
        <option value="">Semua Metode Pengiriman</option>
        <option value="pick-up">Pick-up</option>
        <option value="diantar">Diantar</option>
    </select>

</div>

<div class="tab-content">
    <!-- Tab Pesanan Sedang Berjalan -->
    <div class="tab-panel active orders-container" id="pesanan-berjalan">
        @forelse($pesananBerjalan ?? [] as $order)
        @php
            $subtotal = $order['total_produk_harga'];
            $ongkir_clean = str_replace(['Rp ', '.'], ['', ''], $order['ongkir']);
            $ongkir_num = (int) $ongkir_clean;
            $total = $subtotal + $ongkir_num;
            $metode_pengiriman = $order['metode_pengiriman'];
        @endphp
        <div class="order-card" data-date="{{ strtotime($order['tanggal']) }}" data-product="{{ strtolower($order['produk']) }}" data-supplier="{{ strtolower($order['supplier']) }}" data-address="{{ strtolower($order['alamat']) }}" data-metode="{{ strtolower($metode_pengiriman) }}">
        <div class="order-header">
            <div class="d-flex align-items-start gap-2">
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

        <div class="order-status status-menyiapkan-pesanan"><i class="fa-solid fa-clock"></i> Menyiapkan Pesanan</div>

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
        <button class="btn btn-success btnSiapDiambil btn-sm"><i class="fa-solid fa-check me-1"></i>Siap Diambil</button>
        <a href="/purchasing/detail_pesanan" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
        </div>

        </div>
        @empty
        <p class="text-center text-muted">Belum ada pesanan sedang berjalan.</p>
        @endforelse
    </div>

    <!-- Tab Siap Diambil -->
    <div class="tab-panel orders-container" id="siap-diambil">
        @forelse($siapDiambil ?? [] as $order)
        @php
            $subtotal = $order['total_produk_harga'];
            $ongkir_clean = str_replace(['Rp ', '.'], ['', ''], $order['ongkir']);
            $ongkir_num = (int) $ongkir_clean;
            $total = $subtotal + $ongkir_num;
            $metode_pengiriman = $order['metode_pengiriman'];
        @endphp
        <div class="order-card" data-date="{{ strtotime($order['tanggal']) }}" data-product="{{ strtolower($order['produk']) }}" data-supplier="{{ strtolower($order['supplier']) }}" data-address="{{ strtolower($order['alamat']) }}" data-metode="{{ strtolower($metode_pengiriman) }}">
        <div class="order-header">
            <div class="d-flex align-items-start gap-2">
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
                        <i class="fa-solid fa-shipping-fast me-1"></i>
                    @endif
                    Metode: {{ ucfirst($metode_pengiriman) }}
                </div>
            </div>
            </div>
            <div class="order-number">#{{ rand(1000000000,9999999999) }}</div>
        </div>

        <div class="order-status status-siap-diambil-dikirim"><i class="fa-solid fa-truck"></i> Siap Diambil & Dikirim</div>

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
        <button class="btn btn-success btnSudahDiambil btn-sm"><i class="fa-solid fa-truck me-1"></i>Sudah Diambil/Dikirim</button>
        <a href="/purchasing/detail_pesanan" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
        </div>

        </div>
        @empty
        <p class="text-center text-muted">Belum ada pesanan siap diambil.</p>
        @endforelse
    </div>

    <!-- Tab Menunggu Pembayaran -->
    <div class="tab-panel orders-container" id="menunggu-pembayaran">
        @forelse($menungguPembayaran ?? [] as $order)
        @php
            $subtotal = $order['total_produk_harga'];
            $ongkir_clean = str_replace(['Rp ', '.'], ['', ''], $order['ongkir']);
            $ongkir_num = (int) $ongkir_clean;
            $total = $subtotal + $ongkir_num;
            $metode_pengiriman = $order['metode_pengiriman'];
        @endphp
        <div class="order-card" data-date="{{ strtotime($order['tanggal']) }}" data-product="{{ strtolower($order['produk']) }}" data-supplier="{{ strtolower($order['supplier']) }}" data-address="{{ strtolower($order['alamat']) }}" data-metode="{{ strtolower($metode_pengiriman) }}">
        <div class="order-header">
            <div class="d-flex align-items-start gap-2">
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
                        <i class="fa-solid fa-shipping-fast me-1"></i>
                    @endif
                    Metode: {{ ucfirst($metode_pengiriman) }}
                </div>
            </div>
            </div>
            <div class="order-number">#{{ rand(1000000000,9999999999) }}</div>
        </div>

        <div class="order-status status-menunggu-pembayaran"><i class="fa-solid fa-clock"></i> Menunggu Pembayaran</div>

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
        <a href="/purchasing/detail_pesanan" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
        </div>

        </div>
        @empty
        <p class="text-center text-muted">Belum ada pesanan menunggu pembayaran.</p>
        @endforelse
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded',()=>{
const toastSiapDiambil=new bootstrap.Toast(document.getElementById('toastSiapDiambil'),{delay:3000});
const toastSudahDiambil=new bootstrap.Toast(document.getElementById('toastSudahDiambil'),{delay:3000});

document.querySelectorAll('.btnSiapDiambil').forEach(btn=>btn.addEventListener('click',()=>toastSiapDiambil.show()));

document.querySelectorAll('.btnSudahDiambil').forEach(btn=>btn.addEventListener('click',()=>toastSudahDiambil.show()));

const searchInput = document.getElementById('searchInput');
const sortSelect = document.getElementById('sortSelect');
const metodeSelect = document.getElementById('metodeSelect');

// Custom Tab Switching
const tabs=document.querySelectorAll('.orders-tab');
const panels=document.querySelectorAll('.tab-panel');
tabs.forEach(tab=>{
  tab.addEventListener('click',e=>{
    e.preventDefault();
    tabs.forEach(t=>t.classList.remove('active'));
    panels.forEach(p=>p.classList.remove('active'));
    tab.classList.add('active');
    document.getElementById(tab.dataset.tab).classList.add('active');
    applySort();  // Trigger sort on tab change
  });
});

// Colorize supplier badges
function colorizeBadges() {
    const badges = document.querySelectorAll('.badge-supplier');
    const colorPairs = [
    { bg: "#BAE6FD", text: "#0369A1" }, { bg: "#FEF9C3", text: "#A16207" },
    { bg: "#FBCFE8", text: "#9D174D" }, { bg: "#A7F3D0", text: "#065F46" },
    { bg: "#DDD6FE", text: "#5B21B6" }, { bg: "#FECACA", text: "#991B1B" },
    { bg: "#FDE68A", text: "#B45309" }, { bg: "#F5D0FE", text: "#86198F" }
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

    const activePane = document.querySelector('.tab-panel.active');
    if (activePane) {
        const activeCards = activePane.querySelectorAll('.order-card');
        activeCards.forEach(card => {
            const product = (card.dataset.product || '').toLowerCase();
            const supplier = (card.dataset.supplier || '').toLowerCase();
            const address = (card.dataset.address || '').toLowerCase();
            const metode = (card.dataset.metode || '').toLowerCase();

            const searchMatch = !searchTerm || product.includes(searchTerm) || supplier.includes(searchTerm) || address.includes(searchTerm);
            const metodeMatch = !metodeTerm || metode.includes(metodeTerm);

            const matches = searchMatch && metodeMatch;
            card.classList.toggle('hidden', !matches);
        });
        applySort();
    }
}

// Search functionality - scoped to active tab
searchInput.addEventListener('input', applyFilters);

// Metode filter
metodeSelect.addEventListener('change', applyFilters);

// Sort functionality - scoped to active tab
sortSelect.addEventListener('change', () => applySort());

function applySort() {
    const activePane = document.querySelector('.tab-panel.active');
    if (!activePane) return;
    const activeContainer = activePane;
    const visibleCards = Array.from(activeContainer.querySelectorAll('.order-card')).filter(card => !card.classList.contains('hidden'));
    const sortOrder = sortSelect.value === 'newest' ? -1 : 1;
    visibleCards.sort((a, b) => {
        const dateA = parseInt(a.dataset.date) || 0;
        const dateB = parseInt(b.dataset.date) || 0;
        return (dateA - dateB) * sortOrder;
    });
    visibleCards.forEach(card => activeContainer.appendChild(card));
}

// Initial setup
applyFilters();
});
</script>
@endsection
</body>
</html>
