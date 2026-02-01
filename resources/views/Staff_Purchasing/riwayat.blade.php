<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan - Purchasing</title>
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
        <h3><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Pesanan</h3>
        <div class="orders-tabs">
            <a href="#" class="orders-tab active" data-tab="telah-diambil">Telah Diambil <span class="badge bg-info">{{ count($telah_diambil) }}</span></a>
            <a href="#" class="orders-tab" data-tab="dikirim">Dikirim <span class="badge bg-primary">{{ count($dikirim) }}</span></a>
            <a href="#" class="orders-tab" data-tab="selesai">Selesai <span class="badge bg-success">{{ count($selesai) }}</span></a>
            <a href="#" class="orders-tab" data-tab="dibatalkan">Dibatalkan <span class="badge bg-danger">{{ count($dibatalkan) }}</span></a>
        </div>
    </div>

<div class="select-controls d-flex gap-3 align-items-center mb-3">
        <div class="input-group" style="max-width: 400px; flex-grow: 1;">
             <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
             <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari riwayat...">
        </div>
        <select id="sortSelect" class="form-select" style="width: auto;">
             <option value="newest">Terbaru</option>
             <option value="oldest">Terlama</option>
        </select>
    </div>

<div class="tab-content">

<div class="tab-panel active" id="telah-diambil">
             @forelse($telah_diambil as $order)
                @php
                    $isObj = is_object($order);
                    $id = $isObj ? $order->id : $order['id'];
                    $created_at = $isObj ? $order->created_at : \Carbon\Carbon::parse($order['created_at']);
                    $kode = $isObj ? $order->kode_pesanan : $order['kode_pesanan'];
                    $metode = $isObj ? $order->opsi_pengiriman : $order['opsi_pengiriman'];
                    $kendaraan = $isObj ? $order->kendaraan : ($order['kendaraan'] ?? null);
                    $subtotal = $isObj ? $order->subtotal : $order['subtotal'];
                    $ongkir = $isObj ? $order->ongkir : $order['ongkir'];
                    $total = $isObj ? $order->total : $order['total'];
                    $status = $isObj ? $order->status_pesanan : $order['status_pesanan'];
                    $penerima = $isObj ? $order->nama_penerima : ($order['nama_penerima'] ?? '');
                    $telepon = $isObj ? $order->no_telepon : ($order['no_telepon'] ?? '');
                    $kelurahan = $isObj ? $order->nama_kelurahan : ($order['nama_kelurahan'] ?? '');
                    $alamat = '';
                    if($isObj) $alamat = $order->alamats->alamat_lengkap ?? $order->alamat_lengkap ?? '';
                    else $alamat = $order['alamat_lengkap'] ?? '';

                    $item = null;
                    $otherCount = 0;
                    if($isObj && $order->detailPesanan->isNotEmpty()){
                        $item = $order->detailPesanan->first();
                        $otherCount = $order->detailPesanan->count() - 1;
                    } elseif(!$isObj && !empty($order['detail_pesanan'])) {
                        $item = (object)$order['detail_pesanan'][0];
                        $otherCount = count($order['detail_pesanan']) - 1;
                    }
                    $productName = $item ? ($item->produk->nama_produk ?? $item->nama_produk ?? 'Produk') : 'Produk';
                    $supplierName = $item && $item->produk && $item->produk->supplier ? $item->produk->supplier->nama_supplier : 'Non-Supplier';
                    $qty = $item->quantity ?? 1;
                    $price = $item->harga_satuan ?? 0;
                    $unit = $item->satuan ?? 'Unit';
                    $img = $item->gambar ?? '';
                    $src = asset('images/default-product.png');
                    if($img) {
                         if(str_contains($img, 'http')) $src = $img;
                         elseif(str_starts_with($img, 'storage/')) $src = asset($img);
                         else $src = asset('storage/'.$img);
                    }
                @endphp
                @php
                    $timestamp = $isObj ? $order->updated_at->timestamp : \Carbon\Carbon::parse($order['updated_at'])->timestamp;
                @endphp
                <div class="order-card" data-date="{{ $timestamp }}">
                    <div class="order-header">
                        <div class="d-flex align-items-start gap-3">
                            <div class="order-meta">
                                <div><i class="fa-regular fa-calendar me-2"></i>{{ $created_at->format('d M Y, H:i') }}</div>
                                <div class="text-secondary fw-bold">ID: {{ $kode }}</div>
                                <div>
                                    @if($metode == 'dipick_up')
                                        <span class="badge-metode mb-1"><i class="bi bi-shop"></i> Pick Up</span>
                                    @else
                                        <div class="d-flex flex-wrap gap-1 mb-1">
                                            <span class="badge-metode"><i class="fa-solid fa-truck"></i> Diantar</span>
                                            <span class="badge-alamat"><i class="fa-solid fa-location-dot"></i> {{ $kelurahan }}</span>
                                            @if($kendaraan)
                                                <span class="badge-kendaraan"><i class="fa-solid fa-truck-pickup"></i> {{ $kendaraan }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    @php
                                        $statusClass = 'status-' . $status;
                                        $statusLabel = ucwords(str_replace('_', ' ', $status));

                                        if(in_array($status, ['dibatalkan', 'ditolak_staff', 'ditolak_kurir'])) {
                                            $statusClass = 'status-dibatalkan';
                                            $statusLabel = 'Dibatalkan';
                                            if($status == 'ditolak_kurir') $statusLabel = 'Ditolak Kurir';
                                        }

                                        $icon = 'fa-box';
                                        if($status == 'selesai') $icon = 'fa-check-circle';
                                        elseif($statusClass == 'status-dibatalkan') $icon = 'fa-times-circle';
                                        elseif(in_array($status, ['dikirim', 'sedang_diantar'])) $icon = 'fa-truck';
                                        elseif($status == 'siap_diambil' || $status == 'pesanan_telah_diambil') $icon = 'fas fa-check-double';
                                        elseif($status == 'diproses') $icon = 'fa-hourglass-half';
                                        elseif($status == 'menunggu_pembayaran' || $status == 'menunggu_konfirmasi_pembayaran') $icon = 'fa-wallet';
                                    @endphp
                                    <span class="order-status {{ $statusClass }} py-1 px-2" style="font-size: 12px; margin: 0; display: inline-flex;">
                                        <i class="fas {{ $icon }}"></i> {{ $statusLabel }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($item)
                    <div class="order-product">
                        <div class="img-container">
                            <img src="{{ $src }}" alt="Produk">
                            <span class="badge-supplier">{{ $supplierName }}</span>
                        </div>
                        <div class="order-product-details flex-grow-1">
                            <h6>{{ $productName }}</h6>
                            <p class="mb-1 text-muted small">{{ $qty }} x Rp {{ number_format($price, 0, ',', '.') }} / {{ $unit }}</p>
                            
                            @if($otherCount > 0)
                            <div class="produk-lain mb-2">+ {{ $otherCount }} produk lain</div>
                            @endif

                            <div class="border-top mt-2 pt-2 small text-muted">
                                <div class="d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Ongkir:</span>
                                    <span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between fw-bold text-success mt-1">
                                    <span>Total:</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="order-actions">
                        <a href="{{ route('staff_purchasing.detail_pesanan', $id) }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
                    </div>
                </div>
            @empty
                <div class="text-center py-5"><h5 class="text-muted">Tidak ada pesanan telah diambil.</h5></div>
            @endforelse
        </div>

<div class="tab-panel" id="dikirim">
             @forelse($dikirim as $order)
                @php
                    $isObj = is_object($order);
                    $id = $isObj ? $order->id : $order['id'];
                    $created_at = $isObj ? $order->created_at : \Carbon\Carbon::parse($order['created_at']);
                    $kode = $isObj ? $order->kode_pesanan : $order['kode_pesanan'];
                    $metode = $isObj ? $order->opsi_pengiriman : $order['opsi_pengiriman'];
                    $kendaraan = $isObj ? $order->kendaraan : ($order['kendaraan'] ?? null);
                    $subtotal = $isObj ? $order->subtotal : $order['subtotal'];
                    $ongkir = $isObj ? $order->ongkir : $order['ongkir'];
                    $total = $isObj ? $order->total : $order['total'];
                    $status = $isObj ? $order->status_pesanan : $order['status_pesanan'];
                    $penerima = $isObj ? $order->nama_penerima : ($order['nama_penerima'] ?? '');
                    $telepon = $isObj ? $order->no_telepon : ($order['no_telepon'] ?? '');
                    $kelurahan = $isObj ? $order->nama_kelurahan : ($order['nama_kelurahan'] ?? '');
                    $alamat = '';
                    if($isObj) $alamat = $order->alamats->alamat_lengkap ?? $order->alamat_lengkap ?? '';
                    else $alamat = $order['alamat_lengkap'] ?? '';

                    $item = null;
                    $otherCount = 0;
                    if($isObj && $order->detailPesanan->isNotEmpty()){
                        $item = $order->detailPesanan->first();
                        $otherCount = $order->detailPesanan->count() - 1;
                    } elseif(!$isObj && !empty($order['detail_pesanan'])) {
                        $item = (object)$order['detail_pesanan'][0];
                        $otherCount = count($order['detail_pesanan']) - 1;
                    }
                    $productName = $item ? ($item->produk->nama_produk ?? $item->nama_produk ?? 'Produk') : 'Produk';
                    $supplierName = $item && $item->produk && $item->produk->supplier ? $item->produk->supplier->nama_supplier : 'Non-Supplier';
                    $qty = $item->quantity ?? 1;
                    $price = $item->harga_satuan ?? 0;
                    $unit = $item->satuan ?? 'Unit';
                    $img = $item->gambar ?? '';
                    $src = asset('images/default-product.png');
                    if($img) {
                         if(str_contains($img, 'http')) $src = $img;
                         elseif(str_starts_with($img, 'storage/')) $src = asset($img);
                         else $src = asset('storage/'.$img);
                    }
                @endphp
                @php
                    $timestamp = $isObj ? $order->updated_at->timestamp : \Carbon\Carbon::parse($order['updated_at'])->timestamp;
                @endphp
                <div class="order-card" data-date="{{ $timestamp }}">
                    <div class="order-header">
                        <div class="d-flex align-items-start gap-3">
                            <div class="order-meta">
                                <div><i class="fa-regular fa-calendar me-2"></i>{{ $created_at->format('d M Y, H:i') }}</div>
                                <div class="text-secondary fw-bold">ID: {{ $kode }}</div>
                                <div>
                                    @if($metode == 'dipick_up')
                                        <span class="badge-metode mb-1"><i class="bi bi-shop"></i> Pick Up</span>
                                    @else
                                        <div class="d-flex flex-wrap gap-1 mb-1">
                                            <span class="badge-metode"><i class="fa-solid fa-truck"></i> Diantar</span>
                                            <span class="badge-alamat"><i class="fa-solid fa-location-dot"></i> {{ $kelurahan }}</span>
                                            @if($kendaraan)
                                                <span class="badge-kendaraan"><i class="fa-solid fa-truck-pickup"></i> {{ $kendaraan }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <span class="order-status status-dikirim py-1 px-2" style="font-size: 12px; margin: 0; display: inline-flex;">
                                        <i class="fas fa-truck"></i> Dikirim
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($item)
                    <div class="order-product">
                        <div class="img-container">
                            <img src="{{ $src }}" alt="Produk">
                            <span class="badge-supplier">{{ $supplierName }}</span>
                        </div>
                        <div class="order-product-details flex-grow-1">
                            <h6>{{ $productName }}</h6>
                            <p class="mb-1 text-muted small">{{ $qty }} x Rp {{ number_format($price, 0, ',', '.') }} / {{ $unit }}</p>

                            @if($otherCount > 0)
                            <div class="produk-lain mb-2">+ {{ $otherCount }} produk lain</div>
                            @endif

                            <div class="border-top mt-2 pt-2 small text-muted">
                                <div class="d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Ongkir:</span>
                                    <span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between fw-bold text-success mt-1">
                                    <span>Total:</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="order-actions">
                        <a href="{{ route('staff_purchasing.detail_pesanan', $id) }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
                    </div>
                </div>
            @empty
                <div class="text-center py-5"><h5 class="text-muted">Tidak ada pesanan sedang dikirim.</h5></div>
            @endforelse
        </div>

<div class="tab-panel" id="selesai">
            @forelse($selesai as $order)

                @php

                    $isObj = is_object($order);
                    $id = $isObj ? $order->id : $order['id'];
                    $created_at = $isObj ? $order->created_at : \Carbon\Carbon::parse($order['created_at']);
                    $kode = $isObj ? $order->kode_pesanan : $order['kode_pesanan'];
                    $metode = $isObj ? $order->opsi_pengiriman : $order['opsi_pengiriman'];
                    $kendaraan = $isObj ? $order->kendaraan : ($order['kendaraan'] ?? null);
                    $subtotal = $isObj ? $order->subtotal : $order['subtotal'];
                    $ongkir = $isObj ? $order->ongkir : $order['ongkir'];
                    $total = $isObj ? $order->total : $order['total'];
                    $status = $isObj ? $order->status_pesanan : $order['status_pesanan'];
                    $penerima = $isObj ? $order->nama_penerima : ($order['nama_penerima'] ?? '');
                    $telepon = $isObj ? $order->no_telepon : ($order['no_telepon'] ?? '');
                    $kelurahan = $isObj ? $order->nama_kelurahan : ($order['nama_kelurahan'] ?? '');

                    $alamat = '';
                    if($isObj) $alamat = $order->alamats->alamat_lengkap ?? $order->alamat_lengkap ?? '';
                    else $alamat = $order['alamat_lengkap'] ?? '';

$item = null;
                    $otherCount = 0;
                    if($isObj && $order->detailPesanan->isNotEmpty()){
                        $item = $order->detailPesanan->first();
                        $otherCount = $order->detailPesanan->count() - 1;
                    } elseif(!$isObj && !empty($order['detail_pesanan'])) {
                        $item = (object)$order['detail_pesanan'][0];
                        $otherCount = count($order['detail_pesanan']) - 1;
                    }

                    $productName = $item ? ($item->produk->nama_produk ?? $item->nama_produk ?? 'Produk') : 'Produk';
                    $supplierName = $item && $item->produk && $item->produk->supplier ? $item->produk->supplier->nama_supplier : 'Non-Supplier';
                    $qty = $item->quantity ?? 1;
                    $price = $item->harga_satuan ?? 0;
                    $unit = $item->satuan ?? 'Unit';

$img = $item->gambar ?? '';
                    $src = asset('images/default-product.png');
                    if($img) {
                         if(str_contains($img, 'http')) $src = $img;
                         elseif(str_starts_with($img, 'storage/')) $src = asset($img);
                         else $src = asset('storage/'.$img);
                    }
                @endphp

                @php
                    $timestamp = $isObj ? $order->updated_at->timestamp : \Carbon\Carbon::parse($order['updated_at'])->timestamp;
                @endphp
                <div class="order-card"
                    data-date="{{ $timestamp }}"
                    data-product="{{ strtolower($productName) }}"
                    data-supplier="{{ strtolower($supplierName) }}">

                    <div class="order-header">
                        <div class="d-flex align-items-start gap-3">
                            <div class="order-meta">
                                <div><i class="fa-regular fa-calendar me-2"></i>{{ $created_at->format('d M Y, H:i') }}</div>
                                <div class="text-secondary fw-bold">ID: {{ $kode }}</div>
                                <div>
                                    @if($metode == 'dipick_up')
                                        <span class="badge-metode mb-1"><i class="bi bi-shop"></i> Pick Up</span>
                                    @else
                                        <div class="d-flex flex-wrap gap-1 mb-1">
                                            <span class="badge-metode"><i class="fa-solid fa-truck"></i> Diantar</span>
                                            <span class="badge-alamat"><i class="fa-solid fa-location-dot"></i> {{ $kelurahan }}</span>
                                            @if($kendaraan)
                                                <span class="badge-kendaraan"><i class="fa-solid fa-truck-pickup"></i> {{ $kendaraan }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2">
                                     @php
                                        $statusClass = 'status-' . $status;
                                        $statusLabel = ucwords(str_replace('_', ' ', $status));

                                        if(in_array($status, ['dibatalkan', 'ditolak_staff', 'ditolak_kurir'])) {
                                            $statusClass = 'status-dibatalkan';
                                            $statusLabel = 'Dibatalkan';
                                            if($status == 'ditolak_kurir') $statusLabel = 'Ditolak Kurir';
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
                                        elseif($statusClass == 'status-menunggu_konfirmasi_kurir') $icon = 'fa-hourglass-half';
                                     @endphp
                                     <span class="order-status {{ $statusClass }} py-1 px-2" style="font-size: 12px; margin: 0; display: inline-flex;">
                                        <i class="fas {{ $icon }}"></i> {{ $statusLabel }}
                                     </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($item)
                    <div class="order-product">
                        <div class="img-container">
                            <img src="{{ $src }}" alt="Produk">
                            <span class="badge-supplier">{{ $supplierName }}</span>
                        </div>
                        <div class="order-product-details flex-grow-1">
                            <h6>{{ $productName }}</h6>
                            <p class="mb-1 text-muted small">
                                {{ $qty }} x Rp {{ number_format($price, 0, ',', '.') }}
                                / {{ $unit }}
                            </p>

                            @if($otherCount > 0)
                            <div class="produk-lain mb-2">+ {{ $otherCount }} produk lain</div>
                            @endif

                            <div class="border-top mt-2 pt-2 small text-muted">
                                <div class="d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Ongkir:</span>
                                    <span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between fw-bold text-success mt-1">
                                    <span>Total:</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="order-actions">
                        <a href="{{ route('staff_purchasing.detail_pesanan', $id) }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
                    </div>
                </div>

            @empty
                <div class="text-center py-5"><h5 class="text-muted">Tidak ada riwayat pesanan selesai.</h5></div>
            @endforelse
        </div>

<div class="tab-panel" id="dibatalkan">
            @forelse($dibatalkan as $order)
                @php

                    $isObj = is_object($order);
                    $id = $isObj ? $order->id : $order['id'];
                    $created_at = $isObj ? $order->created_at : \Carbon\Carbon::parse($order['created_at']);
                    $kode = $isObj ? $order->kode_pesanan : $order['kode_pesanan'];
                    $metode = $isObj ? $order->opsi_pengiriman : $order['opsi_pengiriman'];
                    $kendaraan = $isObj ? $order->kendaraan : ($order['kendaraan'] ?? null);
                    $subtotal = $isObj ? $order->subtotal : $order['subtotal'];
                    $ongkir = $isObj ? $order->ongkir : $order['ongkir'];
                    $total = $isObj ? $order->total : $order['total'];
                    $status = $isObj ? $order->status_pesanan : $order['status_pesanan'];
                    $penerima = $isObj ? $order->nama_penerima : ($order['nama_penerima'] ?? '');
                    $telepon = $isObj ? $order->no_telepon : ($order['no_telepon'] ?? '');
                    $kelurahan = $isObj ? $order->nama_kelurahan : ($order['nama_kelurahan'] ?? '');
                    $item = null;
                    $otherCount = 0;
                    if($isObj && $order->detailPesanan->isNotEmpty()){
                        $item = $order->detailPesanan->first();
                        $otherCount = $order->detailPesanan->count() - 1;
                    } elseif(!$isObj && !empty($order['detail_pesanan'])) {
                        $item = (object)$order['detail_pesanan'][0];
                        $otherCount = count($order['detail_pesanan']) - 1;
                    }
                    $productName = $item ? ($item->produk->nama_produk ?? 'Produk') : 'Produk';
                    $supplierName = $item && $item->produk && $item->produk->supplier ? $item->produk->supplier->nama_supplier : 'Non-Supplier';
                    $qty = $item->quantity ?? 1;
                    $price = $item->harga_satuan ?? 0;
                    $unit = $item->satuan ?? 'Unit';

                    $img = $item->gambar ?? '';
                    $src = asset('images/default-product.png');
                    if($img) {
                         if(str_contains($img, 'http')) $src = $img;
                         elseif(str_starts_with($img, 'storage/')) $src = asset($img);
                         else $src = asset('storage/'.$img);
                    }
                @endphp

                @php
                    $timestamp = $isObj ? $order->updated_at->timestamp : \Carbon\Carbon::parse($order['updated_at'])->timestamp;
                @endphp
                <div class="order-card"
                    data-date="{{ $timestamp }}"
                    data-product="{{ strtolower($productName) }}"
                    data-supplier="{{ strtolower($supplierName) }}">

                    <div class="order-header">
                        <div class="d-flex align-items-start gap-3">
                            <div class="order-meta">
                                <div><i class="fa-regular fa-calendar me-2"></i>{{ $created_at->format('d M Y, H:i') }}</div>
                                <div class="text-secondary fw-bold">ID: {{ $kode }}</div>
                                <div>
                                    @if($metode == 'dipick_up')
                                        <span class="badge-metode mb-1"><i class="bi bi-shop"></i> Pick Up</span>
                                    @else
                                        <div class="d-flex flex-wrap gap-1 mb-1">
                                            <span class="badge-metode"><i class="fa-solid fa-truck"></i> Diantar</span>
                                            <span class="badge-alamat"><i class="fa-solid fa-location-dot"></i> {{ $kelurahan }}</span>
                                            @if($kendaraan)
                                                <span class="badge-kendaraan"><i class="fa-solid fa-truck-pickup"></i> {{ $kendaraan }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2 text-danger">
                                      <span class="order-status status-dibatalkan py-1 px-2" style="font-size: 12px; margin: 0; display: inline-flex;">
                                         <i class="fas fa-times-circle"></i>
                                         Dibatalkan
                                      </span>
                                </div>
                            </div>
                        </div>
                    </div>

                     @if($item)
                    <div class="order-product">
                        <div class="img-container">
                            <img src="{{ $src }}" alt="Produk">
                            <span class="badge-supplier">{{ $supplierName }}</span>
                        </div>
                         <div class="order-product-details flex-grow-1">
                            <h6>{{ $productName }}</h6>
                            <p class="mb-1 text-muted small">{{ $qty }} x Rp {{ number_format($price, 0, ',', '.') }} / {{ $unit }}</p>

                            @if($otherCount > 0)
                            <div class="produk-lain mb-2">+ {{ $otherCount }} produk lain</div>
                            @endif

                            <div class="border-top mt-2 pt-2 small text-muted">
                                <div class="d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Ongkir:</span>
                                    <span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between fw-bold text-danger mt-1">
                                    <span>Total:</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="order-actions">
                        <a href="{{ route('staff_purchasing.detail_pesanan', $id) }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
                        @php
                            $bukti = $isObj ? ($order->transaksi->bukti_pembayaran ?? null) : ($order['transaksi']['bukti_pembayaran'] ?? null);
                        @endphp
                        @if($bukti)
                            <button type="button" class="btn btn-outline-info btn-sm btnLihatBukti"
                                data-bukti="{{ asset('storage/' . $bukti) }}">
                                <i class="fa-solid fa-file-invoice-dollar me-1"></i>Lihat Bukti Pembayaran
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5"><h5 class="text-muted">Tidak ada riwayat pesanan dibatalkan.</h5></div>
            @endforelse
        </div>

    </div>
</div>

<div class="modal fade" id="modalBukti" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <img id="imgBukti" src="" alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm" style="max-height: 70vh;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
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
    filterOrders();

const modalBukti = new bootstrap.Modal(document.getElementById('modalBukti'));
    const imgBukti = document.getElementById('imgBukti');

    document.querySelectorAll('.btnLihatBukti').forEach(btn => {
        btn.addEventListener('click', () => {
            imgBukti.src = btn.dataset.bukti;
            modalBukti.show();
        });
    });
});
</script>
@endsection
</body>
</html>
