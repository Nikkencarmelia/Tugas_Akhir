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
        /* Status Badges */
        .badge-status-selesai { background-color: var(--bs-success-bg-subtle) !important; color: var(--bs-success-text-emphasis) !important; padding: 0.5em 0.75em; border-radius: 0.375rem; font-size: 0.75em; font-weight: 500; }
        .badge-status-dikirim { background-color: var(--bs-info-bg-subtle) !important; color: var(--bs-info-text-emphasis) !important; padding: 0.5em 0.75em; border-radius: 0.375rem; font-size: 0.75em; font-weight: 500; }
        .badge-status-ditolak { background-color: var(--bs-danger-bg-subtle) !important; color: var(--bs-danger-text-emphasis) !important; padding: 0.5em 0.75em; border-radius: 0.375rem; font-size: 0.75em; font-weight: 500; }
        /* Custom Tab Buttons Style */
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
        .product-cell {
            display: flex;
            align-items: center;
        }
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

    <div class="search-controls">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="searchInput" class="form-control" placeholder="Cari nama produk, nama pembeli, atau batch...">
        </div>
        <select id="sortSelect" class="form-select" style="max-width: 200px; flex-shrink: 0;">
            <option value="newest">Urutkan: Terbaru</option>
            <option value="oldest">Urutkan: Terlama</option>
        </select>
    </div>

    <div class="tab-content">
        <!-- Tab Laporan Penjualan -->
        <div id="penjualan" class="tab-panel active">
            <h5 class="section-title"><i class="bi bi-cart-check"></i>Laporan Penjualan</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tablePenjualan">
                    <thead>
                        <tr>
                            <th>Tanggal Transaksi</th>
                            <th>Batch</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjualan ?? [] as $index => $item)
                        <tr data-date="{{ strtotime($item['tanggal_transaksi'] ?? '') }}" data-produk="{{ strtolower($item['nama_produk'] ?? '') }}" data-batch="{{ strtolower($item['batch'] ?? '') }}">
                            <td>{{ date('d M Y', strtotime($item['tanggal_transaksi'] ?? '')) }}</td>
                            <td>{{ $item['batch'] ?? '' }}</td>
                            <td class="product-cell">
                                @if(isset($item['gambar']) && $item['gambar'])
                                    <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama_produk'] ?? '' }}" class="product-img">
                                @endif
                                {{ $item['nama_produk'] ?? '' }}
                            </td>
                            <td>{{ $item['jumlah'] ?? '' }}</td>
                            <td>Rp {{ number_format($item['harga_satuan'] ?? 0, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item['total_harga'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data penjualan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Laporan Pesanan -->
        <div id="pesanan" class="tab-panel">
            <h5 class="section-title"><i class="bi bi-bag-check"></i>Laporan Pesanan</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tablePesanan">
                    <thead>
                        <tr>
                            <th>Tanggal Pesanan</th>
                            <th>ID Pesanan</th>
                            <th>Nama Pembeli</th>
                            <th>Total Item</th>
                            <th>Total Bayar</th>
                            <th>Status Pesanan</th>
                            <th>Metode Pengiriman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan ?? [] as $index => $item)
                        <tr data-date="{{ strtotime($item['tanggal_pesanan'] ?? '') }}" data-pembeli="{{ strtolower($item['nama_pembeli'] ?? '') }}" data-status="{{ strtolower($item['status_pesanan'] ?? '') }}">
                            <td>{{ date('d M Y', strtotime($item['tanggal_pesanan'] ?? '')) }}</td>
                            <td>#{{ rand(1000000000,9999999999) }}</td>
                            <td>{{ $item['nama_pembeli'] ?? '' }}</td>
                            <td>{{ $item['total_item'] ?? '' }}</td>
                            <td>Rp {{ number_format($item['total_bayar'] ?? 0, 0, ',', '.') }}</td>
                            <td><span class="badge badge-status-{{ strtolower(str_replace(' ', '-', $item['status_pesanan'] ?? 'selesai')) }}">{{ $item['status_pesanan'] ?? 'Selesai' }}</span></td>
                            <td>{{ ucfirst($item['metode_pengiriman'] ?? '') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Laporan Stok -->
        <div id="stok" class="tab-panel">
            <h5 class="section-title"><i class="bi bi-box-seam"></i>Laporan Stok</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tableStok">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Total Batch</th>
                            <th>Batch Aktif</th>
                            <th>Sisa Batch</th>
                            <th>Stok Masuk</th>
                            <th>Stok Keluar</th>
                            <th>Sisa Stok</th>
                            <th>Tanggal Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stok ?? [] as $index => $item)
                        <tr data-produk="{{ strtolower($item['nama_produk'] ?? '') }}" data-date="{{ strtotime($item['tanggal_update'] ?? '') }}">
                            <td class="product-cell">
                                @if(isset($item['gambar']) && $item['gambar'])
                                    <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama_produk'] ?? '' }}" class="product-img">
                                @endif
                                {{ $item['nama_produk'] ?? '' }}
                            </td>
                            <td>{{ $item['total_batch'] ?? '' }}</td>
                            <td>{{ $item['batch_aktif'] ?? '' }}</td>
                            <td>{{ $item['sisa_batch'] ?? '' }}</td>
                            <td>{{ $item['stok_masuk'] ?? '' }}</td>
                            <td>{{ $item['stok_keluar'] ?? '' }}</td>
                            <td>{{ $item['sisa_stok'] ?? '' }}</td>
                            <td>{{ date('d M Y', strtotime($item['tanggal_update'] ?? '')) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data stok.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Produk Terlaris -->
        <div id="terlaris" class="tab-panel">
            <h5 class="section-title"><i class="bi bi-graph-up"></i>Produk Terlaris</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tableTerlaris">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Jumlah Terjual</th>
                            <th>Total Pendapatan</th>
                            <th>Persentase Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($terlaris ?? [] as $index => $item)
                        <tr data-produk="{{ strtolower($item['nama_produk'] ?? '') }}">
                            <td class="product-cell">
                                @if(isset($item['gambar']) && $item['gambar'])
                                    <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama_produk'] ?? '' }}" class="product-img">
                                @endif
                                {{ $item['nama_produk'] ?? '' }}
                            </td>
                            <td>{{ $item['jumlah_terjual'] ?? '' }}</td>
                            <td>Rp {{ number_format($item['total_pendapatan'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $item['persentase_penjualan'] ?? '' }}%</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data produk terlaris.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');

    // Tab Switching
    const tabs = document.querySelectorAll('.orders-tab');
    const panels = document.querySelectorAll('.tab-panel');
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById(this.dataset.tab).classList.add('active');
            applyFilters(); // Apply filters on tab change
            applySort(); // Apply sort on tab change
        });
    });

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const activePanel = document.querySelector('.tab-panel.active');
        if (!activePanel) return;

        const rows = activePanel.querySelectorAll('tbody tr');
        rows.forEach(row => {
            let match = false;
            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                const text = cell.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    match = true;
                }
            });
            // Specific data attributes for better matching
            const produk = (row.dataset.produk || '').toLowerCase();
            const pembeli = (row.dataset.pembeli || '').toLowerCase();
            const batch = (row.dataset.batch || '').toLowerCase();
            const status = (row.dataset.status || '').toLowerCase();
            if (produk.includes(searchTerm) || pembeli.includes(searchTerm) || batch.includes(searchTerm) || status.includes(searchTerm)) {
                match = true;
            }
            row.style.display = match || !searchTerm ? '' : 'none';
        });
        applySort();
    }

    // Search functionality
    searchInput.addEventListener('input', applyFilters);

    // Sort functionality
    sortSelect.addEventListener('change', applySort);

    function applySort() {
        const activePanel = document.querySelector('.tab-panel.active');
        if (!activePanel) return;
        const table = activePanel.querySelector('table');
        if (!table) return;
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.style.display !== 'none');
        const sortOrder = sortSelect.value === 'newest' ? -1 : 1;
        rows.sort((a, b) => {
            const dateA = parseInt(a.dataset.date) || 0;
            const dateB = parseInt(b.dataset.date) || 0;
            return (dateA - dateB) * sortOrder;
        });
        rows.forEach(row => tbody.appendChild(row));
    }

    // Initial setup
    applyFilters();
});
</script>
@endsection
</body>
</html>
