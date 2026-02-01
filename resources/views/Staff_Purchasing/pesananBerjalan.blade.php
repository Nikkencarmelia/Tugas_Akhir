<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Berjalan - Purchasing</title>
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

        .orders-tabs{display:flex;gap:1rem;align-items:center;flex-wrap:wrap;}
        .orders-tab{padding:8px 16px;border-radius:20px;background:#ffffff;text-decoration:none;color:#6c757d;font-weight:500;border:1px solid #e9ecef;transition:all .3s ease;}
        .orders-tab.active{background:#198754;color:white;border-color:#198754;}
        .orders-tab.active .badge { color: white !important; }
        .orders-tab:hover{background:#e9ecef;color:#495057;}
        .tab-panel{display:none;}
        .tab-panel.active{display:block;}

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
            .order-status { margin: 0 auto 1rem auto; }
        }
    </style>
</head>
<body>

@extends('components.staff_purchasing')
@section('content')
<div class="container py-5">

<div class="orders-header">
        <h3><i class="fa-solid fa-person-running"></i> Pesanan Berjalan</h3>
        <div class="orders-tabs">
            <a href="#" class="orders-tab active" data-tab="menunggu-pembayaran">Menunggu Pembayaran <span class="badge bg-warning">{{ $menunggu_pembayaran->count() }}</span></a>
            <a href="#" class="orders-tab" data-tab="siapkan-pesanan">Siapkan Pesanan <span class="badge bg-info">{{ $siapkan_pesanan->count() }}</span></a>
            <a href="#" class="orders-tab" data-tab="siap-diambil">Siap Diambil <span class="badge bg-success">{{ $siap_diambil->count() }}</span></a>
        </div>
    </div>

<div class="select-controls d-flex gap-3 align-items-center mb-3">
        <div class="input-group" style="max-width: 400px; flex-grow: 1;">
             <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
             <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari pesanan...">
        </div>
        <select id="sortSelect" class="form-select" style="width: auto;">
             <option value="newest">Terbaru</option>
             <option value="oldest">Terlama</option>
        </select>
    </div>

<div class="tab-content">

<div class="tab-panel active" id="menunggu-pembayaran">
            @forelse($menunggu_pembayaran as $order)
                @php
                    $firstItem = $order->detailPesanan->first();
                    $supplier = $firstItem && $firstItem->produk && $firstItem->produk->supplier ? $firstItem->produk->supplier->nama_supplier : 'Non-Supplier';
                    $metode = $order->opsi_pengiriman;
                    $imagePath = $firstItem->gambar ?? '';
                    if (str_starts_with($imagePath, 'images/')) {
                        $src = asset($imagePath);
                    } elseif (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/') && $imagePath) {
                        $src = asset('storage/' . $imagePath);
                    } else {
                        $src = $imagePath ? asset($imagePath) : asset('images/default-product.png');
                    }
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
                                            <span class="badge-alamat"><i class="fa-solid fa-location-dot"></i> {{ $order->nama_kelurahan ?? $order->alamats->kelurahan->nama_kelurahan ?? '' }}</span>
                                            @if($order->kendaraan)
                                                <span class="badge-kendaraan"><i class="fa-solid fa-truck-pickup"></i> {{ $order->kendaraan }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    @php
                                        $status = $order->status_pesanan;
                                        $statusClass = 'status-' . $status;
                                        $statusLabel = ucwords(str_replace('_', ' ', $status));

                                        if(in_array($status, ['dibatalkan', 'ditolak_staff', 'ditolak_kurir'])) {
                                            $statusClass = 'status-dibatalkan';
                                            $statusLabel = 'Dibatalkan';
                                            if($status == 'ditolak_kurir') $statusLabel = 'Ditolak Kurir';
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
                                        elseif($status == 'siap_diambil') $icon = 'fa-check-double';
                                        elseif($status == 'pesanan_telah_diambil') $icon = 'fa-check-double';
                                    @endphp
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
                        <a href="{{ route('staff_purchasing.detail_pesanan', $order->id) }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>

                        @if($order->status_pesanan == 'siap_diambil')
                            <form action="{{ route('staff_purchasing.to_dikirim', $order->id) }}" method="POST" class="formSudahDiambil d-inline">
                                @csrf
                                <button type="button" class="btn btn-success btn-sm btnSudahDiambil">
                                    <i class="fa-solid fa-check-circle me-1"></i>Sudah Diambil
                                </button>
                            </form>
                        @elseif($order->status_pesanan == 'diproses')
                           <form action="{{ route('staff_purchasing.to_siap_diambil', $order->id) }}" method="POST" class="formSiapDiambil d-inline">
                                @csrf
                                <button type="button" class="btn btn-primary btn-sm btnSiapDiambil">
                                    <i class="fa-solid fa-box-open me-1"></i>Siap Diambil/Dikirim
                                </button>
                           </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5"><h5 class="text-muted">Tidak ada pesanan menunggu pembayaran.</h5></div>
            @endforelse
        </div>

<div class="tab-panel" id="siapkan-pesanan">
            @forelse($siapkan_pesanan as $order)
                @php
                    $firstItem = $order->detailPesanan->first();
                    $supplier = $firstItem && $firstItem->produk && $firstItem->produk->supplier ? $firstItem->produk->supplier->nama_supplier : 'Non-Supplier';
                    $metode = $order->opsi_pengiriman;
                    $imagePath = $firstItem->gambar ?? '';
                    if (str_starts_with($imagePath, 'images/')) {
                        $src = asset($imagePath);
                    } elseif (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/') && $imagePath) {
                        $src = asset('storage/' . $imagePath);
                    } else {
                        $src = $imagePath ? asset($imagePath) : asset('images/default-product.png');
                    }
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
                                            <span class="badge-alamat"><i class="fa-solid fa-location-dot"></i> {{ $order->nama_kelurahan ?? $order->alamats->kelurahan->nama_kelurahan ?? '' }}</span>
                                            @if($order->kendaraan)
                                                <span class="badge-kendaraan"><i class="fa-solid fa-truck-pickup"></i> {{ $order->kendaraan }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    @php
                                        $status = $order->status_pesanan;
                                        $statusClass = 'status-' . $status;
                                        $statusLabel = ucwords(str_replace('_', ' ', $status));

                                        if(in_array($status, ['dibatalkan', 'ditolak_staff', 'ditolak_kurir'])) {
                                            $statusClass = 'status-dibatalkan';
                                            $statusLabel = 'Dibatalkan';
                                            if($status == 'ditolak_kurir') $statusLabel = 'Ditolak Kurir';
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
                                        elseif($status == 'siap_diambil') $icon = 'fa-check-double';
                                        elseif($status == 'pesanan_telah_diambil') $icon = 'fa-check-double';
                                    @endphp
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
                        <a href="{{ route('staff_purchasing.detail_pesanan', $order->id) }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>

                        @if($order->status_pesanan == 'siap_diambil')
                            <form action="{{ route('staff_purchasing.to_dikirim', $order->id) }}" method="POST" class="formSudahDiambil d-inline">
                                @csrf
                                <button type="button" class="btn btn-success btn-sm btnSudahDiambil">
                                    <i class="fa-solid fa-check-circle me-1"></i>Sudah Diambil
                                </button>
                            </form>
                        @elseif($order->status_pesanan == 'diproses')
                           <form action="{{ route('staff_purchasing.to_siap_diambil', $order->id) }}" method="POST" class="formSiapDiambil d-inline">
                                @csrf
                                <button type="button" class="btn btn-primary btn-sm btnSiapDiambil">
                                    <i class="fa-solid fa-box-open me-1"></i>Siap Diambil/Dikirim
                                </button>
                           </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5"><h5 class="text-muted">Tidak ada pesanan perlu disiapkan.</h5></div>
            @endforelse
        </div>

<div class="tab-panel" id="siap-diambil">
            @forelse($siap_diambil as $order)
                @php
                    $firstItem = $order->detailPesanan->first();
                    $supplier = $firstItem && $firstItem->produk && $firstItem->produk->supplier ? $firstItem->produk->supplier->nama_supplier : 'Non-Supplier';
                    $metode = $order->opsi_pengiriman;
                    $imagePath = $firstItem->gambar ?? '';
                    if (str_starts_with($imagePath, 'images/')) {
                        $src = asset($imagePath);
                    } elseif (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/') && $imagePath) {
                        $src = asset('storage/' . $imagePath);
                    } else {
                        $src = $imagePath ? asset($imagePath) : asset('images/default-product.png');
                    }
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
                                            <span class="badge-alamat"><i class="fa-solid fa-location-dot"></i> {{ $order->nama_kelurahan ?? $order->alamats->kelurahan->nama_kelurahan ?? '' }}</span>
                                            @if($order->kendaraan)
                                                <span class="badge-kendaraan"><i class="fa-solid fa-truck-pickup"></i> {{ $order->kendaraan }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    @php
                                        $status = $order->status_pesanan;
                                        $statusClass = 'status-' . $status;
                                        $statusLabel = ucwords(str_replace('_', ' ', $status));

                                        if(in_array($status, ['dibatalkan', 'ditolak_staff', 'ditolak_kurir'])) {
                                            $statusClass = 'status-dibatalkan';
                                            $statusLabel = 'Dibatalkan';
                                            if($status == 'ditolak_kurir') $statusLabel = 'Ditolak Kurir';
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
                                        elseif($status == 'siap_diambil') $icon = 'fa-check-double';
                                        elseif($status == 'pesanan_telah_diambil') $icon = 'fa-check-double';
                                    @endphp
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
                        <a href="{{ route('staff_purchasing.detail_pesanan', $order->id) }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>

                        @if($order->status_pesanan == 'siap_diambil')
                            <form action="{{ route('staff_purchasing.to_dikirim', $order->id) }}" method="POST" class="formSudahDiambil d-inline">
                                @csrf
                                <button type="button" class="btn btn-success btn-sm btnSudahDiambil">
                                    <i class="fa-solid fa-check-circle me-1"></i>Sudah Diambil
                                </button>
                            </form>
                        @elseif($order->status_pesanan == 'diproses')
                           <form action="{{ route('staff_purchasing.to_siap_diambil', $order->id) }}" method="POST" class="formSiapDiambil d-inline">
                                @csrf
                                <button type="button" class="btn btn-primary btn-sm btnSiapDiambil">
                                    <i class="fa-solid fa-box-open me-1"></i>Siap Diambil/Dikirim
                                </button>
                           </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5"><h5 class="text-muted">Tidak ada pesanan siap diambil.</h5></div>
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.orders-tab').forEach(tab => {
        tab.addEventListener('click', e => {
            e.preventDefault();
            const tabId = tab.dataset.tab;

            document.querySelectorAll('.orders-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            document.getElementById(tabId).classList.add('active');

            filterOrders();

const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.pushState({}, '', url);
        });
    });

const urlParams = new URLSearchParams(window.location.search);
    const initialTab = urlParams.get('tab');
    if (initialTab) {
        const targetTab = document.querySelector(`.orders-tab[data-tab="${initialTab}"]`);
        if (targetTab) {
            targetTab.click();
        }
    }

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

const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');

    function filterOrders() {
        const activePanel = document.querySelector('.tab-panel.active');
        if(!activePanel) return;

        const search = searchInput.value.toLowerCase();
        const sort = sortSelect.value;
        const cards = Array.from(activePanel.querySelectorAll('.order-card'));

        cards.sort((a,b) => {
            const dateA = parseInt(a.dataset.date);
            const dateB = parseInt(b.dataset.date);
            return sort === 'newest' ? dateB - dateA : dateA - dateB;
        });
        cards.forEach(c => activePanel.appendChild(c));

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            if(text.includes(search)) card.classList.remove('hidden');
            else card.classList.add('hidden');
        });
    }

    searchInput.addEventListener('input', filterOrders);
    sortSelect.addEventListener('change', filterOrders);

document.addEventListener('click', function(e) {

        if (e.target.closest('.btnSiapDiambil')) {
            const form = e.target.closest('.formSiapDiambil');
            window.confirmAction('Apakah pesanan ini sudah selesai disiapkan dan siap untuk diambil atau diantar?', () => {
                form.submit();
            });
        }

        if (e.target.closest('.btnSudahDiambil')) {
            const form = e.target.closest('.formSudahDiambil');
            window.confirmAction('Konfirmasi bahwa pesanan ini telah diambil oleh kurir atau pelanggan.', () => {
                form.submit();
            });
        }

        if (e.target.closest('.btnTerimaPembayaran')) {
            const form = e.target.closest('.formTerimaPembayaran');
            window.confirmAction('Apakah Anda yakin ingin menerima pembayaran ini?', () => {
                form.submit();
            });
        }
        if (e.target.closest('.btnTolakPembayaran')) {
            const form = e.target.closest('.formTolakPembayaran');
            window.confirmAction('Apakah Anda yakin ingin menolak pembayaran ini?', () => {
                form.submit();
            });
        }
    });

    filterOrders();
});
</script>
@endsection
</body>
</html>
