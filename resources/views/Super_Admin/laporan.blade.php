<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { background: #f5f7fa; }
        .orders-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;background:white;padding:1.5rem 2rem;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.08);}
        .orders-header h3{color:#2a522a;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;}
        .orders-header h3 i { color: #198754; }
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
        .search-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1rem;
        }
        .search-controls .input-group {
            flex-grow: 1;
        }

        .order-status {
            display: inline-flex !important;
            align-items: center !important;
            gap: .5rem !important;
            padding: 6px 12px !important;
            border-radius: 20px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            width: fit-content !important;
            white-space: nowrap !important;
        }

        .order-status i {
            font-size: 13px !important;
            margin-right: 4px !important;
        }

        .status-menunggu_konfirmasi { background: #f1f3f5 !important; color: #495057 !important; }
        .status-menunggu_pembayaran { background: #fff4e6 !important; color: #d9480f !important; }
        .status-diproses { background: #fef9c3 !important; color: #854d0e !important; }
        .status-dikirim { background: #e0f2fe !important; color: #0369a1 !important; }
        .status-selesai { background: #dcfce7 !important; color: #166534 !important; }
        .status-dibatalkan { background: #fee2e2 !important; color: #991b1b !important; }
        .status-verif { background: #fff7ed !important; color: #9a3412 !important; }
        .status-menunggu_konfirmasi_kurir { background: #fef9c3 !important; color: #854d0e !important; }
        .status-siap_diambil { background: #d4edda !important; color: #155724 !important; border: 1px solid #c3e6cb !important; }
        .status-pesanan_telah_diambil { background: #e0f2fe !important; color: #0369a1 !important; border: 1px solid #bae6fd !important; }
        .extra-small { font-size: 0.75rem !important; }

        .orders-tabs{display:flex;gap:1rem;align-items:center;flex-wrap:wrap;}
        .orders-tab{padding:8px 16px;border-radius:20px;background:#ffffff;text-decoration:none;color:#6c757d;font-weight:500;border:1px solid #e9ecef;transition:all .3s ease;}
        .orders-tab.active{background:#198754;color:white;border-color:#198754;}
        .orders-tab:hover{background:#e9ecef;color:#495057;}
        .tab-panel{display:none;}
        .tab-panel.active{display:block;}
        .section-title {
            color: #2a522a;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .product-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 0.75rem;
        }
        .badge-supplier { font-size: .7rem; font-weight: 600; padding: .3rem .55rem; border-radius: .4rem; line-height: 1; display: inline-block; }
        .badge-kategori { font-size: .7rem; font-weight: 600; padding: .3rem .55rem; border-radius: .4rem; line-height: 1; display: inline-block; }
        @media(max-width:768px){.orders-header{flex-direction:column;gap:1rem;text-align:center}.search-controls{flex-wrap:wrap;gap:0.5rem;justify-content:flex-start;}.search-controls .input-group{max-width:200px !important;}.product-img { width: 30px; height: 30px; }}
    </style>
</head>
<body>
@extends('components.super_admin')
@section('content')
<div class="container py-5">
    <div class="orders-header">
        <h3><i class="bi bi-file-earmark-bar-graph"></i>Laporan</h3>
        <div class="orders-tabs">
            <a href="#" class="orders-tab active" data-tab="penjualan">Penjualan</a>
            <a href="#" class="orders-tab" data-tab="pesanan">Pesanan</a>
            <a href="#" class="orders-tab" data-tab="stok">Stok</a>
            <a href="#" class="orders-tab" data-tab="terlaris">Produk Terlaris</a>
        </div>
    </div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('super_admin.laporan') }}" method="GET" class="row g-3 align-items-end" id="filterForm">
                <input type="hidden" name="tab" id="activeTabInput" value="penjualan">
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-success"><i class="bi bi-calendar3 me-1"></i>Pilih Bulan</label>
                    <select name="month" class="form-select border-success-subtle" onchange="this.form.submit()">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-success"><i class="bi bi-calendar-event me-1"></i>Pilih Tahun</label>
                    <select name="year" class="form-select border-success-subtle" onchange="this.form.submit()">
                        @foreach(range(date('Y')-2, date('Y')) as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-success-subtle"><i class="fas fa-search text-success"></i></span>
                        <input type="text" id="searchInput" class="form-control border-success-subtle" placeholder="Cari nama produk, Kode Batch, atau pembeli...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-success"><i class="bi bi-sort-down me-1"></i>Urutan</label>
                    <select name="sort" class="form-select border-success-subtle" onchange="this.form.submit()">
                        <option value="desc" {{ $sort == 'desc' ? 'selected' : '' }}>Terbaru &rarr; Terlama</option>
                        <option value="asc" {{ $sort == 'asc' ? 'selected' : '' }}>Terlama &rarr; Terbaru</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="tab-content">

        <div id="penjualan" class="tab-panel active">
            <h5 class="section-title"><i class="bi bi-cart-check"></i>Laporan Penjualan</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tablePenjualan">
                    <thead>
                        <tr>
                            <th>Tanggal Transaksi</th>
                            <th>Kode Batch</th>
                            <th>Kode Pesanan</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Jumlah Dibeli</th>
                            <th>Harga Normal</th>
                            <th>Harga Sekarang</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjualan ?? [] as $index => $item)
                        <tr data-date="{{ strtotime($item['tanggal_transaksi'] ?? '') }}" data-produk="{{ strtolower($item['nama_produk'] ?? '') }}" data-batch="{{ $item['batch_id'] }}">
                            <td>{{ date('d M Y, H:i', strtotime($item['tanggal_transaksi'] ?? '')) }}</td>
                            <td>{{ $item['kode_batch'] ?? '' }}</td>
                            <td>{{ $item['kode_pesanan'] }}</td>
                            <td class="product-cell">
                                <div class="d-flex align-items-center">
                                    @php
                                        $imagePath = $item['gambar'] ?? '';
                                        if (str_starts_with($imagePath, 'images/')) {
                                            $src = asset($imagePath);
                                        } elseif (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/') && $imagePath) {
                                            $src = asset('storage/' . $imagePath);
                                        } else {
                                            $src = $imagePath ? asset($imagePath) : asset('images/default-produk.png');
                                        }
                                    @endphp
                                    @if($imagePath)
                                        <div class="position-relative me-3">
                                            <img src="{{ $src }}" alt="{{ $item['nama_produk'] ?? '' }}" class="product-img">
                                            @if($item['nama_supplier'])
                                            <span class="position-absolute top-0 start-100 translate-middle badge-supplier" style="font-size: 0.6rem;">
                                                {{ $item['nama_supplier'] }}
                                            </span>
                                            @endif
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $item['nama_produk'] ?? '' }}</div>
                                        <small class="text-muted">{{ $item['jumlah_satuan'] }} {{ $item['satuan'] }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-kategori">{{ $item['nama_kategori'] ?? '-' }}</span></td>
                            <td>{{ $item['jumlah_dibeli'] ?? '' }}</td>
                            <td>
                                <span class="{{ ((($item['harga_normal'] ?? 0) > ($item['harga_saat_ini'] ?? 0))) ? 'text-decoration-line-through text-muted' : '' }}">
                                    Rp {{ number_format($item['harga_normal'] ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="fw-bold">Rp {{ number_format($item['harga_saat_ini'] ?? 0, 0, ',', '.') }}</td>
                            <td class="fw-bold text-success">Rp {{ number_format($item['total_harga'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data penjualan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $penjualan->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>

<div id="pesanan" class="tab-panel">
            <h5 class="section-title"><i class="bi bi-bag-check"></i>Laporan Pesanan</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tablePesanan">
                    <thead>
                        <tr>
                            <th>Tanggal Pesanan</th>
                            <th>Kode Pesanan</th>
                            <th>Nama Pembeli</th>
                            <th>Jumlah</th>
                            <th class="small">Total Harga Pesanan</th>
                            <th class="small">Ongkir</th>
                            <th class="small">Total Bayar</th>
                            <th>Status Pesanan</th>
                            <th>Metode Pengiriman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan as $item)
                        <tr data-date="{{ strtotime($item['tanggal_pesanan'] ?? '') }}" data-pembeli="{{ strtolower($item['nama_pembeli'] ?? '') }}" data-status="{{ strtolower($item['status_pesanan'] ?? '') }}">
                            <td>{{ date('d M Y, H:i', strtotime($item['tanggal_pesanan'] ?? '')) }}</td>
                            <td>{{ $item['kode_pesanan'] ?? '' }}</td>
                            <td>{{ $item['nama_pembeli'] ?? '' }}</td>
                            <td>{{ $item['jumlah_dibeli'] ?? '' }}</td>
                            <td class="small">Rp {{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}</td>
                            <td class="small text-secondary">Rp {{ number_format($item['ongkir'] ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @if(isset($item['total_normal_bayar']) && $item['total_normal_bayar'] > $item['total_bayar'])
                                    <div class="text-decoration-line-through text-muted extra-small">
                                        Rp {{ number_format($item['total_normal_bayar'], 0, ',', '.') }}
                                    </div>
                                @endif
                                <div class="fw-bold text-primary small">
                                    Rp {{ number_format($item['total_bayar'] ?? 0, 0, ',', '.') }}
                                </div>
                            </td>
                            <td>
                                @php
                                    $status = $item['status_pesanan'] ?? 'selesai';
                                    $statusClass = 'status-' . $status;
                                    $statusLabel = ucwords(str_replace('_', ' ', $status));

                                    if(in_array($status, ['dibatalkan', 'ditolak_staff', 'ditolak_kurir', 'ditolak_staff_diambil'])) {
                                        $statusClass = 'status-dibatalkan';
                                        $statusLabel = 'Dibatalkan';
                                        if($status == 'ditolak_kurir') $statusLabel = 'Ditolak Kurir';
                                        elseif($status == 'ditolak_staff') $statusLabel = 'Ditolak Staff';
                                    }
                                    elseif(in_array($status, ['menunggu_konfirmasi_pembayaran', 'menunggu_verifikasi_pembayaran', 'menunggu_pembayaran_diverifikasi'])) {
                                        $statusClass = 'status-verif';
                                        $statusLabel = 'Menunggu Verifikasi';
                                    }
                                    elseif($status == 'menunggu_konfirmasi_kurir') {
                                        $statusClass = 'status-menunggu_konfirmasi_kurir';
                                        $statusLabel = 'Menunggu Konfirmasi Kurir';
                                    }
                                    elseif(in_array($status, ['menunggu_cari_kurir', 'menunggu_konfirmasi'])) {
                                        $statusClass = 'status-menunggu_konfirmasi';
                                        $statusLabel = ($status == 'menunggu_cari_kurir') ? 'Menunggu Cari Kurir' : 'Menunggu Konfirmasi';
                                    }
                                    elseif(in_array($status, ['dikirim', 'sedang_diantar'])) {
                                        $statusClass = 'status-dikirim';
                                        $statusLabel = 'Dikirim';
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
                                <span class="order-status {{ $statusClass }} d-inline-flex">
                                    <i class="fas {{ $icon }}"></i>
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td>{{ ucfirst($item['metode_pengiriman'] ?? '') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $pesanan->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>

<div id="stok" class="tab-panel">
            <h5 class="section-title"><i class="bi bi-box-seam"></i>Laporan Stok</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tableStok">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Total Batch</th>
                            <th>Sisa Batch</th>
                            <th>Kode Batch Aktif</th>
                            <th>Stok Masuk</th>
                            <th>Stok Keluar</th>
                            <th>Sisa Stok</th>
                            <th>Tanggal Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stok as $item)
                        <tr data-produk="{{ strtolower($item['nama_produk'] ?? '') }}" data-date="{{ strtotime($item['tanggal_update'] ?? '') }}">
                            <td class="product-cell">
                                <div class="d-flex align-items-center">
                                    @php
                                        $imagePath = $item['gambar'] ?? '';
                                        if (str_starts_with($imagePath, 'images/')) {
                                            $src = asset($imagePath);
                                        } elseif (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/') && $imagePath) {
                                            $src = asset('storage/' . $imagePath);
                                        } else {
                                            $src = $imagePath ? asset($imagePath) : asset('images/default-produk.png');
                                        }
                                    @endphp
                                    @if($imagePath)
                                        <div class="position-relative me-3">
                                            <img src="{{ $src }}" alt="{{ $item['nama_produk'] ?? '' }}" class="product-img">
                                            @if($item['nama_supplier'])
                                            <span class="position-absolute top-0 start-100 translate-middle badge-supplier" style="font-size: 0.6rem;">
                                                {{ $item['nama_supplier'] }}
                                            </span>
                                            @endif
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $item['nama_produk'] ?? '' }}</div>
                                        <small class="text-muted">{{ $item['jumlah_satuan'] ?? 1 }} {{ $item['satuan'] ?? 'Pcs' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-kategori">{{ $item['nama_kategori'] ?? '-' }}</span></td>
                            <td>{{ $item['total_batch'] ?? 0 }}</td>
                            <td>{{ $item['sisa_batch'] ?? 0 }}</td>
                            <td>
                                @if($item['is_batch_habis'])
                                    <span class="badge bg-danger">Batch Habis</span>
                                @else
                                    <span class="badge bg-success">{{ $item['kode_batch_aktif'] }}</span>
                                @endif
                            </td>
                            <td class="text-primary fw-bold">+{{ $item['stok_masuk'] ?? 0 }}</td>
                            <td>
                                <div class="small">
                                    <div>Dibeli: <span class="fw-bold">{{ $item['stok_keluar_dibeli'] ?? 0 }}</span></div>
                                    <div>Rusak: <span class="fw-bold text-danger">{{ $item['stok_keluar_rusak'] ?? 0 }}</span></div>
                                </div>
                            </td>
                            <td class="fw-bold">{{ $item['sisa_stok'] ?? 0 }}</td>
                            <td>{{ date('d M Y, H:i', strtotime($item['tanggal_update'] ?? '')) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data stok.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $stok->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>

<div id="terlaris" class="tab-panel">
            <h5 class="section-title"><i class="bi bi-graph-up"></i>Produk Terlaris</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tableTerlaris">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah Terjual</th>
                            <th>Total Pendapatan</th>
                            <th>Persentase Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($terlaris as $index => $item)
                        @php
                            $rank = ($terlaris->currentPage() - 1) * $terlaris->perPage() + $index + 1;
                        @endphp
                        <tr data-produk="{{ strtolower($item['nama_produk'] ?? '') }}">
                            <td>
                                @if($rank <= 3)
                                    <span class="badge bg-warning text-dark rounded-circle p-2" style="width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">{{ $rank }}</span>
                                @else
                                    <span class="text-muted">{{ $rank }}</span>
                                @endif
                            </td>
                            <td class="product-cell">
                                <div class="d-flex align-items-center">
                                    @php
                                        $imagePath = $item['gambar'] ?? '';
                                        if (str_starts_with($imagePath, 'images/')) {
                                            $src = asset($imagePath);
                                        } elseif (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/') && $imagePath) {
                                            $src = asset('storage/' . $imagePath);
                                        } else {
                                            $src = $imagePath ? asset($imagePath) : asset('images/default-produk.png');
                                        }
                                    @endphp
                                    @if($imagePath)
                                        <div class="position-relative me-3">
                                            <img src="{{ $src }}" alt="{{ $item['nama_produk'] ?? '' }}" class="product-img">
                                            @if($item['nama_supplier'])
                                            <span class="position-absolute top-0 start-100 translate-middle badge-supplier" style="font-size: 0.6rem;">
                                                {{ $item['nama_supplier'] }}
                                            </span>
                                            @endif
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $item['nama_produk'] ?? '' }}</div>
                                        <small class="text-muted">{{ $item['jumlah_satuan'] ?? 1 }} {{ $item['satuan'] ?? 'Pcs' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-bold text-success">{{ $item['jumlah_terjual'] ?? '' }} Item</td>
                            <td class="fw-bold">Rp {{ number_format($item['total_pendapatan'] ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $item['persentase_penjualan'] ?? 0 }}%"></div>
                                    </div>
                                    <span class="small fw-bold">{{ $item['persentase_penjualan'] ?? '' }}%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data produk terlaris.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $terlaris->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tabs = document.querySelectorAll('.orders-tab');
    const panels = document.querySelectorAll('.tab-panel');
    const activeTabInput = document.getElementById('activeTabInput');

    const urlParams = new URLSearchParams(window.location.search);
    let activeTab = urlParams.get('tab') || 'penjualan';

if (!urlParams.get('tab')) {
        if (urlParams.has('pesanan_page')) activeTab = 'pesanan';
        else if (urlParams.has('stok_page')) activeTab = 'stok';
        else if (urlParams.has('terlaris_page')) activeTab = 'terlaris';
    }

    function activateTab(tabId) {
        const tabLink = document.querySelector(`.orders-tab[data-tab="${tabId}"]`);
        if (tabLink) {
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            tabLink.classList.add('active');
            document.getElementById(tabId).classList.add('active');
            if (activeTabInput) activeTabInput.value = tabId;

const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.replaceState({}, '', url);
        }
    }

    function applyFilters() {
        if (!searchInput) return;
        const searchTerm = searchInput.value.toLowerCase().trim();
        const activePanel = document.querySelector('.tab-panel.active');
        if (!activePanel) return;

        const rows = activePanel.querySelectorAll('tbody tr');
        rows.forEach(row => {
            if (row.cells.length === 1 && row.cells[0].getAttribute('colspan')) return;

            let match = false;
            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                const text = cell.textContent.toLowerCase();
                if (text.includes(searchTerm)) match = true;
            });

            const produk = (row.dataset.produk || '').toLowerCase();
            const pembeli = (row.dataset.pembeli || '').toLowerCase();
            const batch = (row.dataset.batch || '').toLowerCase();
            const status = (row.dataset.status || '').toLowerCase();

            if (produk.includes(searchTerm) || pembeli.includes(searchTerm) || batch.includes(searchTerm) || status.includes(searchTerm)) {
                match = true;
            }
            row.style.display = match || !searchTerm ? '' : 'none';
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            activateTab(this.dataset.tab);
            applyFilters();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    activateTab(activeTab);
    applyFilters();
});

function colorizeSingle(badgeEl, text) {
    if (!badgeEl || !text) return;
    const colors = [
        { bg: "#BAE6FD", text: "#0369A1" }, { bg: "#FEF9C3", text: "#A16207" },
        { bg: "#FBCFE8", text: "#9D174D" }, { bg: "#A7F3D0", text: "#065F46" },
        { bg: "#DDD6FE", text: "#5B21B6" }, { bg: "#FECACA", text: "#991B1B" },
        { bg: "#FDE68A", text: "#B45309" }, { bg: "#F5D0FE", text: "#86198F" }
    ];
    let hash = 0;
    for (let i = 0; i < text.length; i++) hash = text.charCodeAt(i) + ((hash << 5) - hash);
    const color = colors[Math.abs(hash) % colors.length];
    badgeEl.style.backgroundColor = color.bg;
    badgeEl.style.color = color.text;
}

function colorizeBadges() {
    document.querySelectorAll('.badge-supplier, .badge-kategori').forEach(badge => {
        const text = badge.textContent.trim().toLowerCase();
        if (text !== '-') {
            colorizeSingle(badge, text);
        } else {
            badge.style.backgroundColor = '#f1f3f4';
            badge.style.color = '#6c757d';
        }
    });
}

document.addEventListener('DOMContentLoaded', colorizeBadges);
</script>
@endsection
</body>
</html>
