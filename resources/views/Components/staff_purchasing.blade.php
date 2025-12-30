<!-- Components/staff_purchasing.blade.php -->
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Staff Purchasing</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            :root {
                --sidebar-bg: #065f46;
                --sidebar-hover: #047857;
                --sidebar-active: #064e3b;
                --border-light: #e2e8f0;
                --bg-light: #f8f9fa;
                --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            body {
                background-color: var(--bg-light);
                font-family: 'Nunito', sans-serif;
                line-height: 1.6;
            }

            h1, h2, h3, h4, h5, h6, .nav-link, .btn {
                font-family: 'Montserrat', sans-serif;
            }

            /* Desktop Sidebar */
            .sidebar-desktop {
                height: 100vh;
                width: 250px;
                position: fixed;
                left: 0;
                top: 0;
                background: linear-gradient(180deg, var(--sidebar-bg) 0%, #047857 100%);
                color: white;
                padding-top: 25px;
                display: flex;
                flex-direction: column;
                box-shadow: 2px 0 20px rgba(0,0,0,0.1);
                z-index: 1030;
                transition: var(--transition);
            }

            .sidebar-desktop h4 {
                font-weight: 600;
                text-align: center;
                margin-bottom: 35px;
                color: white;
                font-size: 1.25rem;
            }

            .sidebar-desktop .nav-link {
                display: flex;
                align-items: center;
                gap: 10px;
                color: white;
                padding: 12px 20px;
                font-size: 15px;
                font-weight: 500;
                margin-right: 10px;
                border-radius: 0 12px 12px 0;
                transition: var(--transition);
            }

            .sidebar-desktop .nav-link:hover {
                background-color: rgba(255,255,255,0.1);
                padding-left: 25px;
                transform: translateX(5px);
                color: white;
            }

            .sidebar-desktop .nav-link.active {
                background-color: var(--sidebar-active);
                padding-left: 25px;
                box-shadow: inset 3px 0 0 white;
            }

            /* Main Content */
            .main-content-desktop {
                margin-left: 250px;
                padding: 1.5rem;
                min-height: 100vh;
                transition: var(--transition);
            }

            /* Mobile Sidebar */
            .sidebar-mobile {
                --bs-offcanvas-width: 280px;
                --bs-offcanvas-bg: var(--sidebar-bg);
            }
            .sidebar-mobile .nav-link {
                display: flex;
                align-items: center;
                gap: 10px;
                color: white;
                padding: 12px 20px;
                font-size: 15px;
                font-weight: 500;
            }
            .sidebar-mobile .nav-link.active {
                background-color: var(--sidebar-active);
                box-shadow: inset 3px 0 0 white;
            }

            /* Mobile Header */
            .mobile-header {
                background: white;
                box-shadow: 0 2px 10px rgba(0,0,0,0.08);
                padding: 0.75rem 1rem;
                z-index: 1040;
                border-bottom: 1px solid var(--border-light);
            }

            @media (max-width: 991.98px) {
                .sidebar-desktop, .main-content-desktop {
                    display: none !important;
                }
                }
                @media (min-width: 992px) {
                .sidebar-mobile, .main-content-mobile, .mobile-header {
                    display: none !important;
                }
            }
        </style>
    </head>

    <body>
        <!-- Mobile Header -->
        <div class="mobile-header d-lg-none">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/purchasing/dashboard">Staff Purchasing</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                    <i class="bi bi-list"></i>
                    </button>
                </div>
            </nav>
        </div>

        <!-- Mobile Sidebar -->
        <div class="sidebar-mobile d-lg-none offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Staff Purchasing</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body">
                <a href="/purchasing/dashboard" class="nav-link {{ request()->is('purchasing/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <a href="/purchasing/pesanan_masuk" class="nav-link {{ request()->is('purchasing/pesanan_masuk') ? 'active' : '' }}">
                    <i class="bi bi-bag-check"></i> Pesanan Masuk
                </a>

                <a href="/purchasing/cari_kurir" class="nav-link {{ request()->is('purchasing/cari_kurir') ? 'active' : '' }}">
                    <i class="bi bi-truck"></i> Cari Kurir
                </a>

                <a href="/purchasing/konfirmasi_pembayaran" class="nav-link {{ request()->is('purchasing/konfirmasi_pembayaran') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i> Konfirmasi Pembayaran
                </a>

                <a href="/purchasing/pesanan_berjalan" class="nav-link {{ request()->is('purchasing/pesanan_berjalan') ? 'active' : '' }}">
                    <i class="bi bi-hourglass-split"></i> Pesanan Berjalan
                </a>

                <a href="/purchasing/kelola_ongkir" class="nav-link {{ request()->is('purchasing/kelola_ongkir') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt"></i> Kelola Ongkir & Daerah
                </a>

                <a href="/purchasing/riwayat_pesanan" class="nav-link {{ request()->is('purchasing/riwayat_pesanan') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Riwayat Pesanan
                </a>

                <a href="/logout" class="nav-link">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>

        <!-- Desktop Sidebar -->
        <div class="sidebar-desktop d-none d-lg-block">
            <h4>Staff Purchasing</h4>

            <a href="/purchasing/dashboard" class="nav-link {{ request()->is('purchasing/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="/purchasing/pesanan_masuk" class="nav-link {{ request()->is('purchasing/pesanan_masuk') ? 'active' : '' }}">
                <i class="bi bi-bag-check"></i> Pesanan Masuk
            </a>

            <a href="/purchasing/cari_kurir" class="nav-link {{ request()->is('purchasing/cari_kurir') ? 'active' : '' }}">
                <i class="bi bi-truck"></i> Cari Kurir
            </a>

            <a href="/purchasing/konfirmasi_pembayaran" class="nav-link {{ request()->is('purchasing/konfirmasi_pembayaran') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i> Konfirmasi Pembayaran
            </a>

            <a href="/purchasing/pesanan_berjalan" class="nav-link {{ request()->is('purchasing/pesanan_berjalan') ? 'active' : '' }}">
                <i class="bi bi-hourglass-split"></i> Pesanan Berjalan
            </a>

            <a href="/purchasing/kelola_ongkir" class="nav-link {{ request()->is('purchasing/kelola_ongkir') ? 'active' : '' }}">
                <i class="bi bi-geo-alt"></i> Kelola Ongkir & Daerah
            </a>

            <a href="/purchasing/riwayat_pesanan" class="nav-link {{ request()->is('purchasing/riwayat_pesanan') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Pesanan
            </a>

            <a href="/logout" class="nav-link">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content-desktop">
            @yield('content')
        </div>

        <div class="main-content-mobile d-lg-none">
            @yield('content')
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
