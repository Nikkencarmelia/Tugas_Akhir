<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pesanan & Pengiriman</title>
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
        --warning-yellow: #f59e0b;
        --archived-gray: #6b7280;
        --display-blue: #3b82f6;
        --danger-red: #ef4444;
        --soft-green: #e9f7ef;
        --soft-gray: #f3f4f6;
        --soft-yellow: #fef3c7;
        --soft-blue: #dbeafe;
    }

    .dashboard-header {
        background: white;
        padding: 1.5rem 2rem;
        box-shadow: var(--shadow-md);
        border-bottom: 1px solid var(--border-light);
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
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--soft-green);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .stat-card.pesanan-masuk::before {
        background: var(--soft-blue);
    }

    .stat-card.konfirmasi-pembayaran::before {
        background: var(--soft-yellow);
    }

    .stat-card.belum-kurir::before {
        background: var(--soft-yellow);
    }

    .stat-card.di-proses::before {
        background: var(--soft-green);
    }

    .stat-card.kecamatan::before {
        background: var(--soft-green);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #374151;
        background-color: var(--soft-gray);
    }

    .pesanan-masuk-icon {
        background-color: var(--soft-blue);
        color: #1e40af;
    }

    .konfirmasi-pembayaran-icon {
        background-color: var(--soft-yellow);
        color: #92400e;
    }

    .belum-kurir-icon {
        background-color: var(--soft-yellow);
        color: #92400e;
    }

    .di-proses-icon {
        background-color: var(--soft-green);
        color: #166534;
    }

    .kecamatan-icon {
        background-color: var(--soft-green);
        color: #166534;
    }

    .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 700;
        color: #111827;
        margin: 0.25rem 0;
    }

    .orders-section {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-light);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-subtitle {
        color: var(--text-muted);
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }

    .view-all-btn { background: var(--primary-green); color: white; border: none; border-radius: .5rem; padding: .75rem 1.5rem; font-weight: 500; font-size: .9rem; box-shadow: 0 3px 6px rgba(0,0,0,0.05); transition: all .3s ease; text-decoration: none; display: inline-block; margin-top: 1rem; }
    .view-all-btn:hover { background: #15803D; color: white; transform: translateY(-1px); }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stat-value {
            font-size: 1.875rem;
        }

        .dashboard-header {
            padding: 1rem;
        }

        .dashboard-title {
            font-size: 1.5rem;
        }
    }
</style>
</head>

<body>
    @extends('Components.staff_purchasing')

@section('content')
<div class="dashboard-container">
    <div class="stats-grid">
        <div class="stat-card pesanan-masuk pesanan-masuk-icon">
            <div class="stat-header">
                <div class="stat-label">Pesanan Masuk</div>
                <div class="stat-icon"><i class="bi bi-cart-plus"></i></div>
            </div>
            <div class="stat-value">{{ count(array_filter($pesanan, fn($p) => $p['status'] === 'Masuk')) }}</div>
        </div>

        <div class="stat-card konfirmasi-pembayaran konfirmasi-pembayaran-icon">
            <div class="stat-header">
                <div class="stat-label">Konfirmasi Pembayaran</div>
                <div class="stat-icon"><i class="bi bi-credit-card"></i></div>
            </div>
            <div class="stat-value">{{ count(array_filter($pesanan, fn($p) => $p['status'] === 'Konfirmasi Pembayaran')) }}</div>
        </div>

        <div class="stat-card belum-kurir belum-kurir-icon">
            <div class="stat-header">
                <div class="stat-label">Pesanan Belum Dapat Kurir</div>
                <div class="stat-icon"><i class="bi bi-truck"></i></div>
            </div>
            <div class="stat-value">{{ count(array_filter($pesanan, fn($p) => $p['status'] === 'Belum Dapat Kurir')) }}</div>
        </div>

        <div class="stat-card kecamatan kecamatan-icon">
            <div class="stat-header">
                <div class="stat-label">Jumlah Kecamatan</div>
                <div class="stat-icon"><i class="bi bi-geo-alt"></i></div>
            </div>
            <div class="stat-value">{{ count($kecamatans) }}</div>
        </div>
    </div>
</div>

@endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
