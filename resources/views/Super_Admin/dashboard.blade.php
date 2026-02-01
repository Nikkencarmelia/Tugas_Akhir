<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Super Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
        --primary-green: #16a34a;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --border-light: #e5e7eb;
        --text-muted: #6b7280;
        --soft-green: #e9f7ef;
        --soft-gray: #f3f4f6;
        --soft-blue: #dbeafe;
    }

    body {
        background: #f5f7fa;
        font-family: 'Inter', sans-serif;
    }

    .dashboard-header {
        background: white;
        padding: 1.5rem 2rem;
        box-shadow: var(--shadow-md);
        border-bottom: 1px solid var(--border-light);
        margin-bottom: 2rem;
    }

    .dashboard-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-green);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .dashboard-container {
        padding: 0 2rem 2rem 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        border: 1px solid var(--border-light);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 4px;
        background: var(--soft-green);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .stat-icon {
        width: 3rem; height: 3rem; border-radius: 0.75rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.25rem;
        background-color: var(--soft-gray);
        color: #374151;
    }

.stat-card.user .stat-icon { background-color: #dbeafe; color: #1e40af; }
    .stat-card.user::before { background: #dbeafe; }

    .stat-card.kurir .stat-icon { background-color: #fef3c7; color: #92400e; }
    .stat-card.kurir::before { background: #fef3c7; }

    .stat-card.pengurus .stat-icon { background-color: #d1fae5; color: #065f46; }
    .stat-card.pengurus::before { background: #d1fae5; }

    .stat-card.produk .stat-icon { background-color: #e0e7ff; color: #3730a3; }
    .stat-card.produk::before { background: #e0e7ff; }

.stat-label {
        font-size: 0.875rem; font-weight: 600; color: var(--text-muted);
        text-transform: uppercase; letter-spacing: 0.025em;
    }

    .stat-value {
        font-size: 2.25rem; font-weight: 700; color: #111827; margin: 0.25rem 0;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }

    .content-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-light);
    }

    .card-title {
        font-size: 1.1rem; font-weight: 600; color: #374151; margin-bottom: 1rem; border-bottom: 1px solid #f3f4f6; padding-bottom: 0.75rem;
    }

    .simple-table {
        width: 100%; border-collapse: collapse; font-size: 0.9rem;
    }
    .simple-table th { text-align: left; padding: 0.75rem; color: var(--text-muted); border-bottom: 1px solid #e5e7eb; font-weight: 600; }
    .simple-table td { padding: 0.75rem; border-bottom: 1px solid #f3f4f6; color: #1f2937; }
    .simple-table tr:last-child td { border-bottom: none; }

    @media (max-width: 768px) {
        .content-grid { grid-template-columns: 1fr; }
        .dashboard-container { padding: 1rem; }
    }
  </style>
</head>

<body>
@extends('components.super_admin')
@section('content')

<div class="dashboard-header">
        <h1 class="dashboard-title">
          <i class="bi bi-speedometer2"></i> Dashboard Super Admin
        </h1>
    </div>

    <div class="dashboard-container">

        <div class="stats-grid">
            <div class="stat-card user">
                <div class="stat-header">
                    <div class="stat-label">Total Pengguna</div>
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                </div>
                <div class="stat-value">{{ $total_user }}</div>
            </div>

            <div class="stat-card kurir">
                <div class="stat-header">
                    <div class="stat-label">Total Kurir</div>
                    <div class="stat-icon"><i class="bi bi-truck"></i></div>
                </div>
                <div class="stat-value">{{ $total_kurir }}</div>
            </div>

            <div class="stat-card pengurus">
                <div class="stat-header">
                    <div class="stat-label">Total Pengurus</div>
                    <div class="stat-icon"><i class="bi bi-person-badge"></i></div>
                </div>
                <div class="stat-value">{{ $total_pengurus }}</div>
            </div>

            <div class="stat-card produk">
                <div class="stat-header">
                    <div class="stat-label">Total Produk</div>
                    <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
                </div>
                <div class="stat-value">{{ $total_produk }}</div>
            </div>
        </div>

<div class="content-grid">

            <div class="content-card">
                <h3 class="card-title"><i class="bi bi-trophy text-warning me-2"></i>Produk Terlaris (Berdasarkan Quantity)</h3>
                <div class="table-responsive">
                    <table class="simple-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th class="text-end">Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($top_products as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 30px; height: 30px; background: #f3f4f6; border-radius: 4px; overflow: hidden;">
                                            @php
                                                $img = $item->produk->gambar ?? '';
                                                $src = asset('images/default-product.png');
                                                if(str_starts_with($img, 'images/')) $src = asset($img);
                                                elseif($img) $src = asset('storage/' . $img);
                                            @endphp
                                            <img src="{{ $src }}" style="width:100%; height:100%; object-fit:cover;">
                                        </div>
                                        {{ $item->produk->nama_produk ?? 'Unknown' }}
                                    </div>
                                </td>
                                <td>{{ $item->produk->kategori->nama_kategori ?? '-' }}</td>
                                <td class="text-end fw-bold text-success">{{ $item->total_sold }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted">Belum ada data penjualan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

<div class="content-card">
                <h3 class="card-title"><i class="bi bi-graph-up-arrow text-success me-2"></i>Penjualan Bulanan</h3>
                <div class="table-responsive">
                    <table class="simple-table">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th class="text-center">Pesanan</th>
                                <th class="text-end">Total Penjualan</th>
                                <th class="text-end">Penjualan Bersih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthly_sales as $sale)
                            <tr>
                                <td class="fw-medium">{{ $sale['month'] }}</td>
                                <td class="text-center"><span class="badge bg-light text-dark border">{{ $sale['orders'] }}</span></td>
                                <td class="text-end fw-bold text-primary">Rp {{ number_format($sale['total'], 0, ',', '.') }}</td>
                                <td class="text-end fw-bold text-success">Rp {{ number_format($sale['net'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
