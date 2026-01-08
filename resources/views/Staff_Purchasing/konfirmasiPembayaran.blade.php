<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembayaran - Purchasing</title>
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

        .order-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef; }
        .order-meta { display: flex; flex-direction: column; font-size: 14px; color: #6c757d; gap: 4px; }
        .order-meta .alamat { background: #e8f5e9; color: #1b5e20; padding: 3px 8px; border-radius: 6px; font-size: 13px; display: inline-block; }
        .order-meta .metode { background: #e3f2fd; color: #0d47a1; padding: 3px 8px; border-radius: 6px; font-size: 13px; display: inline-block; }

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

.status-menunggu_konfirmasi { background: #f1f3f5; color: #495057; }
        .status-menunggu_pembayaran { background: #fff4e6; color: #d9480f; }
        .status-diproses { background: #fef9c3; color: #854d0e; }
        .status-dikirim { background: #e0f2fe; color: #0369a1; }
        .status-selesai { background: #dcfce7; color: #166534; }
        .status-dibatalkan { background: #fee2e2; color: #991b1b; }
        .status-menunggu_konfirmasi_pembayaran { background: #fff7ed; color: #9a3412; }
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
            .order-status { margin: 0 auto 1rem auto; }
        }
    </style>
</head>
<body>

@extends('Components.staff_purchasing')
@section('content')
<div class="container py-5">

<div class="orders-header">
        <h3><i class="fa-solid fa-file-invoice-dollar"></i> Konfirmasi Pembayaran
            <span class="badge bg-warning text-dark ms-2" id="countBadge">{{ count($pesanan) }}</span>
        </h3>
        <small class="text-muted">Daftar pembayaran yang menunggu konfirmasi</small>
    </div>

<div class="select-controls d-flex flex-column gap-3">
         <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
            <div class="input-group" style="max-width: 400px; flex-grow: 1;">
                 <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                 <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari pesanan...">
            </div>
            <select id="sortSelect" class="form-select" style="width: auto;">
                 <option value="newest">Terbaru</option>
                 <option value="oldest">Terlama</option>
            </select>
         </div>
    </div>

<div id="ordersContainer">
        @forelse($pesanan as $order)
        @php
            $firstItem = $order->detailPesanan->first();
            $supplier = $firstItem && $firstItem->produk && $firstItem->produk->supplier
                ? $firstItem->produk->supplier->nama_supplier
                : 'Non-Supplier';
            $metode = $order->opsi_pengiriman;

            $imagePath = $firstItem->gambar ?? '';
            if (str_starts_with($imagePath, 'images/')) {
                $src = asset($imagePath);
            } elseif (str_starts_with($imagePath, 'images/')) {
                $src = asset($imagePath);
            } else {
                $src = $imagePath ? asset($imagePath) : asset('images/default-product.png');
            }

            $buktiSrc = $order->bukti_pembayaran
                ? asset($order->bukti_pembayaran)
                : asset('images/placeholder-bukti.jpg');
        @endphp

        <div class="order-card"
            data-date="{{ $order->updated_at->timestamp }}"
            data-product="{{ strtolower($firstItem->nama_produk ?? '') }}"
            data-supplier="{{ strtolower($supplier) }}">

            <div class="order-header">
                <div class="d-flex align-items-start gap-3">
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
                        <div class="mt-2">
                            <span class="order-status status-menunggu_konfirmasi_pembayaran py-1 px-2" style="font-size: 12px; margin: 0; display: inline-flex;">
                                <i class="fas fa-clock"></i> Menunggu Konfirmasi Pembayaran
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
                <form action="{{ route('staff_purchasing.terima_pembayaran', $order->id) }}" method="POST" class="formTerimaPembayaran" style="flex:1; min-width: 120px;">
                    @csrf
                    <button type="button" class="btn btn-success btn-sm w-100 btnTerimaPembayaran">
                        <i class="fa-solid fa-check me-1"></i>Terima
                    </button>
                </form>

                <form action="{{ route('staff_purchasing.tolak_pembayaran', $order->id) }}" method="POST" class="formTolakPembayaran" style="flex:1; min-width: 120px;">
                    @csrf
                    <button type="button" class="btn btn-danger btn-sm w-100 btnTolakPembayaran">
                        <i class="fa-solid fa-xmark me-1"></i>Tolak
                    </button>
                </form>

                <button type="button" class="btn btn-primary btn-sm w-100" style="flex:1; min-width: 120px;" data-bs-toggle="modal" data-bs-target="#buktiModal{{ $order->id }}">
                    <i class="fa-solid fa-receipt me-1"></i>Lihat Bukti
                </button>

                <a href="{{ route('staff_purchasing.detail_pesanan', $order->id) }}" class="btn btn-outline-primary btn-sm w-100" style="flex:1; min-width: 120px;">
                    <i class="fa-solid fa-eye me-1"></i>Lihat Detail
                </a>
            </div>
        </div>

<div class="modal fade" id="buktiModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Bukti Pembayaran - {{ $order->kode_pesanan }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                @if($order->transaksi && $order->transaksi->bukti_pembayaran)
                    <img src="{{ asset($order->transaksi->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm" style="max-height: 70vh;">
                @else
                    <p class="text-muted">Bukti pembayaran tidak tersedia.</p>
                @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        @empty
        <div class="text-center py-5">
            <img src="{{ asset('images/empty-state.png') }}" alt="Empty" style="width: 150px; opacity: 0.5;">
            <h5 class="text-muted mt-3">Tidak ada pembayaran menunggu konfirmasi.</h5>
        </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

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

const searchInput = document.getElementById('searchInput');
        const sortSelect = document.getElementById('sortSelect');
        const ordersContainer = document.getElementById('ordersContainer');
        const countBadge = document.getElementById('countBadge');

        function filterOrders() {
             const search = searchInput.value.toLowerCase();
             const sort = sortSelect.value;
             const cards = Array.from(document.querySelectorAll('.order-card'));

             cards.sort((a,b) => {
                 const dateA = parseInt(a.dataset.date);
                 const dateB = parseInt(b.dataset.date);
                 return sort === 'newest' ? dateB - dateA : dateA - dateB;
             });

             let visibleCount = 0;
             cards.forEach(card => {
                  ordersContainer.appendChild(card);
                  const text = card.textContent.toLowerCase();
                  if(text.includes(search)) {
                      card.classList.remove('hidden');
                      visibleCount++;
                  } else {
                      card.classList.add('hidden');
                  }
             });
             if(countBadge) countBadge.textContent = visibleCount;
        }

        searchInput.addEventListener('input', filterOrders);
        sortSelect.addEventListener('change', filterOrders);

document.addEventListener('click', function(e) {
            if (e.target.closest('.btnTerimaPembayaran')) {
                const form = e.target.closest('.formTerimaPembayaran');
                window.confirmAction('Apakah Anda yakin ingin menerima pembayaran ini? Pesanan akan segera dilanjutkan ke tahap proses.', () => {
                    form.submit();
                });
            }
            if (e.target.closest('.btnTolakPembayaran')) {
                const form = e.target.closest('.formTolakPembayaran');
                window.confirmAction('Apakah Anda yakin ingin menolak pembayaran ini? Pesanan akan otomatis dibatalkan.', () => {
                    form.submit();
                });
            }
        });
    });
</script>

@endsection
</body>
</html>