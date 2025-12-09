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
      --success: #198754;
      --warning: #f59e0b;
      --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
      --shadow-md: 0 4px 6px rgba(0,0,0,0.05);
      --shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
      --border-radius: 16px;
      --bg-light: #f8f9fa;
      --text-muted: #6b7280;
    }
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e8 100%);
      font-family: 'Inter', sans-serif;
    }
    .dashboard-header {
      background: white; padding: 1.5rem 2rem; box-shadow: var(--shadow-md); margin-bottom: 2rem;
      border-radius: 0 0 var(--border-radius) var(--border-radius);
    }
    .dashboard-title {
      font-size: 1.75rem; font-weight: 700; color: var(--primary-green); margin: 0;
      display: flex; align-items: center; gap: 0.5rem;
    }
    .dashboard-subtitle {
      color: var(--text-muted); font-size: 0.875rem; margin: 0;
    }
    .search-bar {
      max-width: 300px; border-radius: 50px; border: 1px solid #e9ecef;
    }
    .user-profile {
      display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted);
    }
    .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--primary-green); color: white; display: flex; align-items: center; justify-content: center; }
    .stat-card {
      transition: all 0.3s ease; border: none; border-radius: var(--border-radius);
      box-shadow: var(--shadow-sm); background: white; overflow: hidden;
    }
    .stat-card:hover {
      transform: translateY(-4px); box-shadow: var(--shadow-lg);
    }
    .stat-icon {
      width: 3rem; height: 3rem; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;
      font-size: 1.25rem; color: white; margin-bottom: 0.75rem;
    }
    .stat-card .stat-icon { background: var(--primary-green); }
    .stat-card.completed .stat-icon { background: var(--success); }
    .stat-card.active .stat-icon { background: var(--warning); }
    .stat-label { font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem; }
    .stat-value { font-size: 2rem; font-weight: 700; color: #1f2937; margin: 0; }
    .stat-change { font-size: 0.75rem; font-weight: 500; margin-top: 0.25rem; }
    .stat-change.positive { color: var(--success); }
    .stat-change.negative { color: #dc3545; }

    .chart-card { border-radius: var(--border-radius); box-shadow: var(--shadow-sm); overflow: hidden; }
    .chart-header { padding: 1.5rem; border-bottom: 1px solid #e9ecef; background: white; }
    .chart-title { font-size: 1rem; font-weight: 600; color: #374151; margin: 0; }
    .chart-body { padding: 1.5rem; background: white; }
    .top-products-table { font-size: 0.875rem; }
    .top-products-table th { font-weight: 600; color: #374151; border-bottom: 2px solid #e9ecef; }
    .top-products-table td { border-bottom: 1px solid #f1f3f4; }
    .top-products-table .progress { height: 0.5rem; border-radius: 0.25rem; }
    .top-products-table .progress-bar { background: var(--primary-green); }

    .revenue-breakdown {
      display: flex; gap: 1rem; margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 0.5rem;
    }
    .breakdown-item { text-align: center; flex: 1; }
    .breakdown-label { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem; }
    .breakdown-value { font-size: 1.25rem; font-weight: 600; color: #1f2937; }

    @media (max-width: 768px) {
      .dashboard-container { padding: 1rem; }
      .stat-value { font-size: 1.5rem; }
      .chart-body { padding: 1rem; }
      .revenue-breakdown { flex-direction: column; gap: 0.5rem; }
      .search-bar { max-width: 100%; margin-bottom: 1rem; }
      .user-profile { justify-content: center; }
    }
  </style>
</head>

<body>
@extends('components.super_admin')
@section('content')

<div class="container dashboard-container">
  <!-- Header -->
  <div class="dashboard-header">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h1 class="dashboard-title">
          <i class="bi bi-speedometer2"></i> Dashboard Super Admin
        </h1>
        <p class="dashboard-subtitle">Selamat datang! Kelola Food Center dengan mudah.</p>
      </div>
      <div class="col-md-6 text-end">
        <div class="d-flex justify-content-end align-items-center gap-3">
          <div class="search-bar">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control border-0" placeholder="Cari user, produk, atau pesanan...">
            </div>
          </div>
          <div class="user-profile">
            <div class="user-avatar">
              <i class="bi bi-person-circle"></i>
            </div>
            <div>
              <small class="d-block text-muted">Admin</small>
              <small>Super Admin</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Grid - 3 Atas, 3 Bawah -->
  <div class="row g-4 mb-4">
    <!-- Baris 1: 3 Card -->
    <div class="col-lg-4 col-md-6">
      <div class="card stat-card">
        <div class="card-body text-center">
          <div class="stat-icon">
            <i class="bi bi-person-fill"></i>
          </div>
          <p class="stat-label">Total User</p>
          <h4 class="stat-value">1,247</h4>
          <small class="stat-change positive"><i class="bi bi-arrow-up"></i> +12% bulan ini</small>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card stat-card">
        <div class="card-body text-center">
          <div class="stat-icon">
            <i class="bi bi-truck"></i>
          </div>
          <p class="stat-label">Total Kurir</p>
          <h4 class="stat-value">45</h4>
          <small class="stat-change positive"><i class="bi bi-arrow-up"></i> +5 baru</small>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card stat-card">
        <div class="card-body text-center">
          <div class="stat-icon">
            <i class="bi bi-bag-check"></i>
          </div>
          <p class="stat-label">Total Produk</p>
          <h4 class="stat-value">320</h4>
          <small class="stat-change positive"><i class="bi bi-arrow-up"></i> +18 item</small>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-5">
    <!-- Baris 2: 3 Card -->
    <div class="col-lg-4 col-md-6">
      <div class="card stat-card">
        <div class="card-body text-center">
          <div class="stat-icon">
            <i class="bi bi-cart4"></i>
          </div>
          <p class="stat-label">Total Pesanan</p>
          <h4 class="stat-value">856</h4>
          <small class="stat-change negative"><i class="bi bi-arrow-down"></i> -3% minggu ini</small>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card stat-card completed">
        <div class="card-body text-center">
          <div class="stat-icon">
            <i class="bi bi-check-circle-fill"></i>
          </div>
          <p class="stat-label">Pesanan Selesai</p>
          <h4 class="stat-value">715</h4>
          <small class="stat-change positive"><i class="bi bi-arrow-up"></i> +45 hari ini</small>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card stat-card active">
        <div class="card-body text-center">
          <div class="stat-icon">
            <i class="bi bi-hourglass-split"></i>
          </div>
          <p class="stat-label">Pesanan Berjalan</p>
          <h4 class="stat-value">141</h4>
          <small class="stat-change negative"><i class="bi bi-arrow-down"></i> -12 pending</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Row - Grafik Rata -->
  <div class="row g-4 mb-5">
    <div class="col-lg-6">
      <div class="card chart-card" style="height: 100%;">
        <div class="chart-header">
          <h6 class="chart-title">
            <i class="bi bi-graph-up"></i> Grafik Penjualan Bulanan
          </h6>
        </div>
        <div class="chart-body">
          <canvas id="salesChart" height="200"></canvas>
        </div>
        <!-- Breakdown Pendapiran -->
        <div class="revenue-breakdown">
          <div class="breakdown-item">
            <div class="breakdown-label">Total Pendapatan</div>
            <div class="breakdown-value">Rp 1.2 M</div>
          </div>
          <div class="breakdown-item">
            <div class="breakdown-label">Harga Produk</div>
            <div class="breakdown-value">Rp 1.05 M</div>
          </div>
          <div class="breakdown-item">
            <div class="breakdown-label">Ongkir</div>
            <div class="breakdown-value">Rp 150 K</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card chart-card" style="height: 100%;">
        <div class="chart-header">
          <h6 class="chart-title">
            <i class="bi bi-bar-chart"></i> Produk Paling Banyak Dibeli
          </h6>
        </div>
        <div class="chart-body">
          <table class="table table-hover top-products-table mb-0">
            <thead>
              <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Popularitas</th>
                <th>Jumlah Terjual</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Beras Kutiran Premium</td>
                <td>
                  <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: 80%"></div>
                  </div>
                </td>
                <td><span class="badge bg-success">120 unit</span></td>
              </tr>
              <tr>
                <td>2</td>
                <td>Sayur Pokcoy Segar</td>
                <td>
                  <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: 65%"></div>
                  </div>
                </td>
                <td><span class="badge bg-success">95 unit</span></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Ikan Patin Segar</td>
                <td>
                  <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: 55%"></div>
                  </div>
                </td>
                <td><span class="badge bg-success">82 unit</span></td>
              </tr>
              <tr>
                <td>4</td>
                <td>Telur Ayam Kampung</td>
                <td>
                  <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: 45%"></div>
                  </div>
                </td>
                <td><span class="badge bg-success">74 unit</span></td>
              </tr>
              <tr>
                <td>5</td>
                <td>Cabe Rawit Merah</td>
                <td>
                  <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: 35%"></div>
                  </div>
                </td>
                <td><span class="badge bg-success">68 unit</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Sales Chart - Total Pendapiran (line chart)
  new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
      datasets: [{
        label: 'Pendapiran (Rp)',
        data: [12000000, 19000000, 30000000, 50000000, 75000000, 120000000],
        borderColor: '#198754',
        backgroundColor: 'rgba(25, 135, 84, 0.1)',
        borderWidth: 3,
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) { return 'Rp ' + (value / 1000000).toFixed(0) + 'jt'; }
          }
        }
      }
    }
  });
</script>

@endsection
</body>
</html>
