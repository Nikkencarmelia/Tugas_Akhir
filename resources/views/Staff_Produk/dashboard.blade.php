<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard Produk</title>
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
            .stat-card.warning::before {
                background: var(--soft-gray);
            }
            .stat-card.archived::before {
                background: var(--soft-gray);
            }
            .stat-card.displayed::before {
                background: var(--soft-green);
            }
            .stat-card.danger::before {
                background: var(--soft-gray);
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
            .total-icon {
                background-color: var(--soft-green);
            }
            .warning-icon {
                background-color: var(--soft-gray);
            }
            .archived-icon {
                background-color: var(--soft-gray);
            }
            .displayed-icon {
                background-color: var(--soft-green);
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
            .stat-card.warning .stat-value {
                color: #374151;
            }
            .stat-card.archived .stat-value {
                color: #4b5563;
            }
            .stat-card.displayed .stat-value {
                color: #374151;
            }
            .products-section {
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
            .table-card {
                background: white;
                border-radius: .8rem;
                border: 1px solid var(--border-light);
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                overflow: hidden;
            }
            .table th {
                background: #E9F7EF;
                color: #15803D;
                font-weight: 600;
                font-size: .85rem;
                text-transform: uppercase;
                border-bottom: 2px solid var(--border-light);
            }
            .table td {
                vertical-align: middle;
                font-size: .9rem;
                border-top: 1px solid var(--border-light);
                color: #1F2937;
            }
            .table tbody tr:hover {
                background-color: #F3F4F6;
            }
            /* Product Info */
            .img-container {
                position: relative;
                width: 75px;
                height: 75px;
            }
            .img-container img {
                width: 75px;
                height: 75px;
                border-radius: .5rem;
                object-fit: cover;
                border: 1px solid var(--border-light);
            }
            .badge-supplier {
                position: absolute;
                top: 5px;
                right: 5px;
                font-size: .7rem;
                font-weight: 600;
                padding: .3rem .55rem;
                border-radius: .4rem;
                line-height: 1;
            }
            .product-info {
                margin-left: .75rem;
            }
            .product-info span {
                font-weight: 600;
                font-size: .95rem;
                color: #1F2937;
            }
            .product-info small {
                color: var(--text-muted);
                display: block;
                font-size: .8rem;
            }
            /* Status Badges */
            .badge-status {
                padding: .3rem .9rem;
                border-radius: 1rem;
                font-size: .75rem;
                font-weight: 600;
                display: inline-block;
                margin-right: .25rem;
                line-height: 1.5;
            }
            .badge-ditampilkan {
                background: #DCFCE7;
                color: #166534;
            }
            .badge-diarsipkan {
                background: #E5E7EB;
                color: #374151;
            }
            .badge-draft {
                background: #F3E8FF;
                color: #7E22CE;
            }
            .badge-menipis {
                background: #FEF3C7;
                color: #92400E;
            }
            .badge-habis {
                background: #FEE2E2;
                color: #991B1B;
            }
            .badge-tersedia {
                background: #DBEAFE;
                color: #1E40AF;
            }
            .view-all-btn {
                background: var(--primary-green);
                color: white;
                border: none;
                border-radius: .5rem;
                padding: .75rem 1.5rem;
                font-weight: 500;
                font-size: .9rem;
                box-shadow: 0 3px 6px rgba(0,0,0,0.05);
                transition: all .3s ease;
                text-decoration: none;
                display: inline-block;
                margin-top: 1rem;
            }
            .view-all-btn:hover {
                background: #15803D;
                color: white;
                transform: translateY(-1px);
            }
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
        @extends('Components.staff_produk')
        @section('content')

        <div class="dashboard-container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h1 class="dashboard-title"><i class="bi bi-speedometer2"></i> Dashboard Produk</h1>
            </div>

            {{-- STATISTIK PRODUK --}}
            <div class="stats-grid">
                <div class="stat-card total-icon">
                    <div class="stat-header">
                        <div class="stat-label">Total Produk</div>
                        <div class="stat-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                    </div>
                    {{-- Menggunakan variabel totalProduk dari Controller --}}
                    <div class="stat-value">{{ $totalProduk ?? 0 }}</div>
                </div>

                <div class="stat-card displayed displayed-icon">
                    <div class="stat-header">
                        <div class="stat-label">Produk Ditampilkan</div>
                        <div class="stat-icon"><i class="bi bi-eye"></i></div>
                    </div>
                    {{-- Menggunakan variabel totalTampil dari Controller --}}
                    <div class="stat-value">{{ $totalTampil ?? 0 }}</div>
                </div>

                <div class="stat-card archived archived-icon">
                    <div class="stat-header">
                        <div class="stat-label">Produk Diarsipkan</div>
                        <div class="stat-icon"><i class="bi bi-archive"></i></div>
                    </div>
                    {{-- Menggunakan variabel totalArsip dari Controller --}}
                    <div class="stat-value">{{ $totalArsip ?? 0 }}</div>
                </div>

                {{-- Menipis dan Habis (Diberi nilai 0 di Controller) --}}
                <div class="stat-card warning warning-icon">
                    <div class="stat-header">
                        <div class="stat-label">Produk Menipis (0)</div>
                        <div class="stat-icon"><i class="bi bi-exclamation-triangle"></i></div>
                    </div>
                    <div class="stat-value">0</div>
                </div>

                <div class="stat-card danger danger-icon">
                    <div class="stat-header">
                        <div class="stat-label">Produk Habis (0)</div>
                        <div class="stat-icon"><i class="bi bi-x-circle "></i></div>
                    </div>
                    <div class="stat-value">0</div>
                </div>
            </div>

            {{-- PRODUK BARU --}}
            <div class="products-section mt-4">
                <h2 class="section-title">
                    <i class="bi bi-bag-plus" style="color:#16a34a;"></i>
                    Produk yang Baru Ditambahkan
                </h2>
                <p class="section-subtitle">Daftar 5 produk terbaru yang ditambahkan dalam sistem:</p>

                <div class="table-card">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produk</th>
                                    <th>Satuan</th>
                                    <th>Harga Normal</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- LANGSUNG GUNAKAN $produkBaru yang hanya berisi 5 data terbaru dari Controller --}}

                                @if(isset($produkBaru) && $produkBaru->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="bi bi-box-seam" style="font-size:2rem;"></i>
                                            <p class="mt-2 mb-0">Belum ada produk baru yang ditambahkan.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($produkBaru as $p)
                                        @php
                                            $statusStokClass = strtolower(str_replace(' ', '-', $p->status_stok ?? 'tersedia'));
                                            $statusTampilClass = strtolower(str_replace(' ', '_', $p->status_tampil ?? 'draft'));
                                            $stockStyle = ($p->stok ?? 0) == 0 ? 'font-weight: 700; color: #991B1B;' : '';
                                        @endphp
                                        <tr>
                                            <td>{{ $p->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="img-container">
                                                        <img src="{{ asset($p->gambar ?? 'images/default.png') }}" alt="{{ $p->nama_produk }}">
                                                        <span class="badge-supplier">{{ $p->supplier ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="product-info">
                                                        <span>{{ $p->nama_produk }}</span>
                                                        <small>{{ Str::limit($p->deskripsi ?? 'Tidak ada deskripsi', 40) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $p->satuan_berat }}</td>
                                            <td>{{ $p->harga }}</td>
                                            <td style="{{ $stockStyle }}">{{ $p->stok }}</td>
                                            <td>
                                                <span class="badge-status badge-{{ $statusTampilClass }}">{{ $p->status_tampil }}</span>
                                                <span class="badge-status badge-{{ $statusStokClass }}">{{ ucfirst($p->status_stok ?? 'Tersedia') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('produk.data') }}" class="view-all-btn">
                        <i class="bi bi-arrow-right"></i> Lihat Semua Produk
                    </a>
                </div>
            </div>
        </div>

        <script>
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
            document.addEventListener('DOMContentLoaded', colorizeBadges);
        </script>

        @endsection

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
