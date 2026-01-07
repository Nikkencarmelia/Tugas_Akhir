<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pesanan #{{ $pemesanan->kode_pesanan }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { background: #f5f7fa; }
        .detail-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .detail-header h3 { color: #2a522a; font-weight: 700; margin: 0; display: flex; align-items: center; gap: .5rem; }
        .detail-header h3 i { color: #198754; }
        .detail-card { background: white; border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #f1f3f4; }
        .detail-header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef; }
        .detail-meta { display: flex; gap: 2rem; font-size: 14px; color: #6c757d; }
        .product-item { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 12px; transition: all 0.2s; }
        .product-item.hidden { display: none !important; }
        .img-container { position: relative; width: 80px; height: 80px; }
        .img-container img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #f1f3f4; }
        .badge-supplier { position: absolute; top: 5px; right: 5px; font-size: .7rem; font-weight: 600; padding: .3rem .55rem; border-radius: .4rem; line-height: 1; z-index: 2; }
        .product-details { flex-grow: 1; }
        .total-section { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e9ecef; }

        .status-badge { padding: 0.5rem 1rem; border-radius: 50px; font-weight: 600; font-size: 0.9rem; }

        .order-status {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            width: fit-content;
        }

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

.badge-metode { background: #e3f2fd; color: #0d47a1; padding: 4px 10px; border-radius: 8px; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; }
        .badge-alamat { background: #e8f5e9; color: #1b5e20; padding: 4px 10px; border-radius: 8px; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; }
        .badge-kendaraan { background: #fef9c3; color: #854d0e; padding: 4px 10px; border-radius: 8px; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #fde68a; }

        @media (max-width: 768px) {
            .detail-header { flex-direction: column; gap: 1rem; text-align: center; }
            .detail-header-section { flex-direction: column; gap: .5rem; align-items: flex-start; }
            .product-item { flex-direction: column; text-align: center; }
            .detail-meta { flex-direction: column; gap: .5rem; }
        }
    </style>
</head>
<body>
    @extends('components.staff_purchasing')

    @section('content')
    <div class="container py-5">

<div class="detail-header">
            <div class="d-flex align-items-center">
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('staff_purchasing.pesanan_masuk') }}"
                   class="text-secondary me-3" style="text-decoration: none; font-size: 1.5rem; line-height: 1;">
                    <i class="bi bi-chevron-left"></i>
                </a>
                <h3 class="mb-0"><i class="bi bi-box-seam me-2"></i>Detail Pesanan</h3>
            </div>
            <div class="d-flex gap-2">
                @if($pemesanan->status_pesanan == 'menunggu_konfirmasi')
                <form action="{{ route('staff_purchasing.terima_pesanan', $pemesanan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menerima pesanan ini?');">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg me-1"></i> Terima Pesanan
                    </button>
                </form>
                @endif
            </div>
        </div>

<div class="detail-card">
                @php
                    $status = $pemesanan->status_pesanan;
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
                <span class="order-status {{ $statusClass }}">
                    <i class="fas {{ $icon }} me-1"></i> {{ $statusLabel }}
                </span>

            <div class="row mt-3">
                <div class="col-md-12">
                    @if(strtolower($pemesanan->opsi_pengiriman) == 'diantar')
                        <h5 class="fw-bold mb-3">Informasi Pengiriman</h5>
                        <div class="d-flex flex-column gap-1">
                            <h6 class="mb-1 fw-bold">{{ $pemesanan->nama_penerima }}</h6>
                            <p class="mb-1 text-muted">{{ $pemesanan->alamat_lengkap }}, {{ $pemesanan->nama_kelurahan }}, {{ $pemesanan->nama_kecamatan }} - {{ $pemesanan->kode_pos }}</p>
                            <div class="d-flex align-items-center gap-2">
                                <small class="text-secondary">Telp: {{ $pemesanan->no_telepon }}</small>
                                <span class="badge-metode ms-auto"><i class="fa-solid fa-truck"></i> Diantar</span>
                                @if($pemesanan->kendaraan)
                                    <span class="badge-kendaraan"><i class="fa-solid fa-truck-pickup"></i> {{ $pemesanan->kendaraan }}</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <h5 class="fw-bold mb-3">Informasi Pembeli</h5>
                        <div class="d-flex flex-column gap-1">
                            <h6 class="mb-1 fw-bold">{{ $pemesanan->nama_penerima }}</h6>
                            <small class="text-secondary mb-2">Telp: {{ $pemesanan->no_telepon }}</small>
                            <div class="d-flex">
                                <span class="badge-metode"><i class="bi bi-shop"></i> Pick Up (Ambil di Toko)</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

<div class="detail-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Produk yang Dipesan ({{ $pemesanan->detailPesanan->count() }} item)</h5>

            </div>

            <div id="productList">
            @foreach($pemesanan->detailPesanan as $item)
                @php
                    $supplierName = $item->produk && $item->produk->supplier ? $item->produk->supplier->nama_supplier : 'Non-Supplier';

$imagePath = $item->gambar;
                    if (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/')) {
                         $imagePath = 'storage/' . $imagePath;
                    }
                    $src = asset($imagePath);
                @endphp
                <div class="product-item">
                    <div class="img-container">
                        <img src="{{ $src }}" alt="{{ $item->nama_produk }}">
                        <span class="badge-supplier">{{ $supplierName }}</span>
                    </div>

                    <div class="product-details">
                        <h6 class="fw-semibold mb-1">{{ $item->nama_produk }}</h6>

                        <p class="small text-muted mb-1">
                            Jumlah: {{ $item->quantity }} x {{ number_format($item->harga_satuan, 0, ',', '.') }}/{{ $item->jumlah_satuan }} {{ $item->satuan }}
                        </p>
                        <p class="small text-success fw-semibold mb-0">
                            Subtotal: Rp {{ number_format($item->harga_total, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach
            </div>

            <div class="total-section">
                <p class="mb-0 fw-semibold">Subtotal Produk</p>
                <p class="mb-0 fw-bold">Rp {{ number_format($pemesanan->subtotal, 0, ',', '.') }}</p>
            </div>

            <div class="total-section">
                <p class="mb-0 fw-semibold">Ongkos Kirim</p>
                <p class="mb-0 fw-bold text-success">Rp {{ number_format($pemesanan->ongkir, 0, ',', '.') }}</p>
            </div>

            <div class="total-section">
                <p class="mb-0 fw-bold fs-5">Total Pembayaran</p>
                <p class="mb-0 fw-bold text-primary fs-4">Rp {{ number_format($pemesanan->total, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            function colorizeBadges() {
                const badges = document.querySelectorAll('.badge-supplier');
                const colors = [
                    { bg: "BAE6FD", text: "0369A1" }, { bg: "FEF9C3", text: "A16207" },
                    { bg: "FBCFE8", text: "9D174D" }, { bg: "A7F3D0", text: "065F46" },
                    { bg: "DDD6FE", text: "5B21B6" }, { bg: "FECACA", text: "991B1B" },
                    { bg: "FDE68A", text: "B45309" }, { bg: "F5D0FE", text: "86198F" }
                ];

                badges.forEach(badge => {
                    const text = badge.textContent.trim().toLowerCase();
                    let hash = 0;
                    for (let i = 0; i < text.length; i++) hash = text.charCodeAt(i) + ((hash << 5) - hash);
                    const color = colors[Math.abs(hash) % colors.length];
                    badge.style.setProperty('background-color', "#" + color.bg, 'important');
                    badge.style.setProperty('color', "#" + color.text, 'important');
                });
            }
            colorizeBadges();
        });
    </script>
    @endsection
</body>
</html>
