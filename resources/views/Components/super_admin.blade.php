<!-- Components/staff_produk.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Super Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  @stack('styles')
  <style>
    :root {
      --sidebar-bg: #065f46;
      --sidebar-hover: #047857;
      --sidebar-active: #064e3b;
      --border-light: #e2e8f0;
      --text-muted: #6b7280;
      --bg-light: #f8f9fa;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    body {
      background-color: var(--bg-light);
      font-family: 'Nunito', sans-serif;
      line-height: 1.6;
    }

    h1, h2, h3, h4, h5, h6,
    .nav-link,
    .btn {
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
      padding: 0 20px;
      text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    .sidebar-desktop .nav-link {
      display: flex;
      align-items: center;
      gap: 10px;
      color: white;
      text-decoration: none;
      padding: 12px 20px;
      transition: var(--transition);
      font-size: 15px;
      font-weight: 500;
      border-radius: 0 12px 12px 0;
      margin-right: 10px;
      border: none;
      background: none;
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
      color: white;
      box-shadow: inset 3px 0 0 white;
    }

    /* Main Content Desktop */
    .main-content-desktop {
      margin-left: 250px;
      padding: 1.5rem;
      min-height: 100vh;
      transition: var(--transition);
    }

    /* Mobile: Offcanvas Sidebar */
    .sidebar-mobile {
      --bs-offcanvas-width: 280px;
      --bs-offcanvas-bg: var(--sidebar-bg);
      --bs-offcanvas-border-width: 0;
    }
    .sidebar-mobile .offcanvas-header {
      background: linear-gradient(180deg, var(--sidebar-bg) 0%, #047857 100%);
      color: white;
      border-bottom: 1px solid rgba(255,255,255,0.1);
      padding: 1rem 1.5rem;
    }
    .sidebar-mobile .offcanvas-header h5 {
      font-weight: 600;
      color: white;
      font-size: 1.25rem;
      margin: 0;
    }
    .sidebar-mobile .offcanvas-body {
      background: inherit;
      padding: 0;
      scrollbar-width: thin;
      scrollbar-color: rgba(255,255,255,0.2) transparent;
    }
    .sidebar-mobile .offcanvas-body::-webkit-scrollbar {
      width: 4px;
    }
    .sidebar-mobile .offcanvas-body::-webkit-scrollbar-track {
      background: transparent;
    }
    .sidebar-mobile .offcanvas-body::-webkit-scrollbar-thumb {
      background: rgba(255,255,255,0.2);
      border-radius: 2px;
    }
    .sidebar-mobile .nav-link {
      display: flex;
      align-items: center;
      gap: 10px;
      color: white;
      text-decoration: none;
      padding: 12px 20px;
      transition: var(--transition);
      font-size: 15px;
      font-weight: 500;
      border-radius: 0;
      border: none;
      background: none;
      width: 100%;
    }
    .sidebar-mobile .nav-link:hover {
      background-color: rgba(255,255,255,0.1);
      padding-left: 25px;
      color: white;
    }
    .sidebar-mobile .nav-link.active {
      background-color: var(--sidebar-active);
      padding-left: 25px;
      color: white;
      box-shadow: inset 3px 0 0 white;
    }

    /* Mobile Main Content */
    .main-content-mobile {
      padding: 1rem;
      min-height: 100vh;
    }

    /* Mobile Header */
    .mobile-header {
      background: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      padding: 0.75rem 1rem;
      z-index: 1040;
      border-bottom: 1px solid var(--border-light);
    }
    .mobile-header .navbar-brand {
      font-weight: 600;
      color: var(--sidebar-bg);
      font-size: 1.25rem;
      text-decoration: none;
    }
    .mobile-header .navbar-toggler {
      border: none;
      padding: 0.5rem;
      color: var(--sidebar-bg);
      font-size: 1.25rem;
    }
    .mobile-header .navbar-toggler:focus {
      box-shadow: none;
      color: var(--sidebar-bg);
    }

    /* Responsive */
    @media (max-width: 991.98px) {
      .sidebar-desktop,
      .main-content-desktop {
        display: none !important;
      }
      .sidebar-mobile,
      .main-content-mobile,
      .mobile-header {
        display: block !important;
      }
    }

    @media (min-width: 992px) {
      .sidebar-mobile,
      .main-content-mobile,
      .mobile-header {
        display: none !important;
      }
      .sidebar-desktop,
      .main-content-desktop {
        display: block !important;
      }
    }

    /* Smooth Transitions for All */
    .offcanvas {
      transition: var(--transition);
    }
    .offcanvas.show {
      transform: none;
    }
  </style>
</head>
<body>
  <!-- Mobile Header with Toggle -->
  <div class="mobile-header d-lg-none">
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <a class="navbar-brand" href="/dashboard_produk">Staff Produk</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
          <i class="bi bi-list"></i>
        </button>
      </div>
    </nav>
  </div>

  <!-- Mobile Sidebar (Offcanvas) -->
  <div class="sidebar-mobile d-lg-none offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">Super Admin</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <a href="/super_admin/dashboard" class="nav-link {{ request()->is('super_admin/dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <a href="/super_admin/manajemen_user" class="nav-link {{ request()->is('super_admin/manajemen_user') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Manajemen User
      </a>
      <a href="/super_admin/manajemen_pengurus" class="nav-link {{ request()->is('super_admin/manajemen_pengurus') ? 'active' : '' }}">
        <i class="bi bi-person-badge"></i> Manajemen Pengurus
      </a>
      <a href="/super_admin/manajemen_kurir" class="nav-link {{ request()->is('super_admin/manajemen_kurir') ? 'active' : '' }}">
        <i class="bi bi-truck"></i> Manajemen Kurir
      </a>
      <a href="/super_admin/laporan" class="nav-link {{ request()->is('super_admin/laporan') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-bar-graph"></i> Laporan
      </a>
      <a href="/logout" class="nav-link">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </div>
  </div>

  <!-- Desktop Sidebar -->
  <div class="sidebar-desktop d-none d-lg-block">
    <h4>Super Admin</h4>
    <a href="/super_admin/dashboard" class="nav-link {{ request()->is('super_admin/dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <a href="/super_admin/manajemen_user" class="nav-link {{ request()->is('super_admin/manajemen_user') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Manajemen User
      </a>
      <a href="/super_admin/manajemen_pengurus" class="nav-link {{ request()->is('super_admin/manajemen_pengurus') ? 'active' : '' }}">
        <i class="bi bi-person-badge"></i> Manajemen Pengurus
      </a>
      <a href="/super_admin/manajemen_kurir" class="nav-link {{ request()->is('super_admin/manajemen_kurir') ? 'active' : '' }}">
        <i class="bi bi-truck"></i> Manajemen Kurir
      </a>
      <a href="/super_admin/laporan" class="nav-link {{ request()->is('super_admin/laporan') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-bar-graph"></i> Laporan
      </a>
      <a href="/logout" class="nav-link">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
  </div>

  <!-- Main Content -->
  <div class="main-content-desktop d-none d-lg-block">
    @yield('content')
  </div>
  <div class="main-content-mobile d-lg-none">
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
