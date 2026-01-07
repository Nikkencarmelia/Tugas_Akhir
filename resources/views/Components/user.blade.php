<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

        <title>User Components</title>

        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
                background-color: #f8f9fa;
                font-family: 'Nunito', sans-serif;
            }

            h1, h2, h3, h4, h5, h6,
            .navbar-brand,
            .nav-link,
            .btn {
                font-family: 'Montserrat', sans-serif;
            }

            .navbar {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 1000;
                transition: background-color 0.3s ease, box-shadow 0.3s ease;
                font-size: 15px;
            }

            .navbar.transparent {
                background-color: transparent !important;
                box-shadow: none;
            }

            .navbar.white {
                background-color: #ffffff;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

@media (max-width: 991px) {
                .navbar {
                    background-color: #ffffff !important;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
                }
                .navbar.transparent {
                    background-color: #ffffff !important;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
                }
            }

            .nav-link {
                color: #495057 !important;
                transition: color 0.2s ease;
            }

            .nav-link.active {
                color: #2a522a !important;
                font-weight: 600;
            }

            .nav-link:hover {
                color: #2a522a !important;
            }

            .navbar-brand {
                color: #2a522a !important;
                font-weight: 600;
            }

            .btn-login {
                background-color: #2a522a;
                color: white !important;
                border-radius: 20px;
                padding: 8px 16px;
                font-weight: 500;
                transition: background-color 0.2s ease;
            }

            .btn-login:hover {
                background-color: #1e3d1e;
                color: white !important;
            }

            .container {
                margin-top: 80px;
            }

            footer {
                background-color: #2a522a;
                color: white;
                margin-top: 4rem;
                padding: 2rem 0;
                font-size: 14px;
            }

            footer h5, footer h6 {
                color: white;
                font-weight: 600;
                margin-bottom: 1rem;
            }

            footer a {
                color: #e9ecef;
                text-decoration: none;
                transition: color 0.2s ease;
            }

            footer a:hover {
                color: white;
            }

            footer p {
                margin-bottom: 0.5rem;
            }

            footer small {
                font-size: 12px;
            }

            @media (max-width: 768px) {
                .container {
                    margin-top: 70px;
                }
                footer .row > div {
                    margin-bottom: 1.5rem;
                }
            }
        </style>
    </head>

    <body>

        <nav class="navbar navbar-expand-lg @yield('navbar-class', 'white')">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Food Center</a>
                <button class="navbar-toggler" type="button" id="navbarToggler" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center gap-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('produk*') ? 'active' : '' }}" href="{{ route('produk') }}">Produk</a>
                        </li>

                        @auth
                        @php
                            $isRiwayat = request()->routeIs('pemesanan.riwayat.pesanan') || request()->routeIs('pemesanan.index');
                            $isProfil = request()->routeIs('user.profil');
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link {{ $isRiwayat ? 'active' : '' }}" href="{{ route('pemesanan.riwayat.pesanan') }}">Riwayat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $isProfil ? 'active' : '' }}" href="{{ route('user.profil') }}">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative {{ request()->routeIs('keranjang.index') ? 'active' : '' }}" href="{{ route('keranjang.index') }}">
                                <i class="fa-solid fa-cart-shopping"></i>
                                @php
                                    $cart = session('cart', []);
                                    $cartCount = array_sum(array_column($cart, 'quantity'));
                                @endphp
                                <span id="cartBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; padding: 0.25em 0.5em; {{ $cartCount > 0 ? '' : 'display: none;' }}">
                                    {{ $cartCount > 99 ? '99+' : $cartCount }}
                                </span>
                            </a>
                        </li>

                        <li class="nav-item ms-2">
                            <button type="button" class="btn btn-secondary shadow-sm" data-bs-toggle="modal" data-bs-target="#logoutModal" style="border-radius: 20px; padding: 8px 16px; font-weight: 500; font-size: 14px;">Logout</button>
                        </li>
                        @endauth
                        @guest
                        <li class="nav-item"><a href="/login" class="btn btn-login">Login</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @hasSection('content_full')
                @yield('content_full')
                @else
                    <div class="container mt-4">
                        @yield('content')
                    </div>
                @endif

        <footer>
            <div class="container">
                <div class="row">

                    <div class="col-md-6 pe-md-5">
                        <h5>Food Center</h5>
                        <p class="mb-1">Dinas Ketahanan Pangan Kabupaten Kutai Barat</p>
                        <p class="mb-3">Komplek Perkantoran, Blok E, Barong Tongkok, Kec. Barong Tongkok, Kabupaten Kutai Barat, Kalimantan Timur 75777</p>
                        <p class="mb-0 small">Copyright © 2026 Dinas Ketahanan Pangan Kabupaten Kutai Barat. All rights reserved.</p>
                    </div>

                    <div class="col-md-3">
                        <h6>Menu Utama</h6>
                        <ul class="list-unstyled">
                            <li><a href="/">Beranda</a></li>
                            <li><a href="/produk">Produk</a></li>
                            <li><a href="/keranjang">Keranjang</a></li>
                            <li><a href="/login">Login</a></li>
                            <li><a href="/register">Register</a></li>
                            </ul>
                        </div>

                    <div class="col-md-3">
                        <h6>Kontak Kami</h6>
                        <p class="mb-2"><i class="fa-solid fa-phone me-2"></i>081234567890</p>
                        <p class="mb-0"><i class="fa-solid fa-envelope me-2"></i>email@gmail.com</p>
                    </div>

                        </div>
                    </div>
                </footer>

                <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-danger text-white border-0">
                                <h5 class="modal-title fw-bold" id="logoutModalLabel">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Logout
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4 text-center">
                                <h5 class="mb-0">Apakah Anda yakin ingin keluar dari akun?</h5>
                            </div>
                            <div class="modal-footer border-0 justify-content-center">
                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger px-4">Ya, Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <script>

                    window.logout = function() {
                        const modalLogout = new bootstrap.Modal(document.getElementById('logoutModal'));
                        modalLogout.show();
                    };

                    document.addEventListener('DOMContentLoaded', function() {
                        const toggler = document.getElementById('navbarToggler');
                        const collapseEl = document.getElementById('navbarNav');

                        if (toggler && collapseEl) {
                            const bsCollapse = new bootstrap.Collapse(collapseEl, { toggle: false });

                            toggler.addEventListener('click', function(e) {
                                e.preventDefault();
                                bsCollapse.toggle();
                            });

                            collapseEl.addEventListener('show.bs.collapse', () => toggler.setAttribute('aria-expanded', 'true'));
                            collapseEl.addEventListener('hide.bs.collapse', () => toggler.setAttribute('aria-expanded', 'false'));
                        }
                    });

                    const isLandingPage = document.querySelector('.navbar').classList.contains('transparent');

                    if (isLandingPage) {
                        window.addEventListener('scroll', function () {

                            if (window.innerWidth <= 991) return;

                            const navbar = document.querySelector('.navbar');
                            if (window.scrollY > 50) {
                                navbar.classList.remove('transparent');
                                navbar.classList.add('white');
                            } else {
                                navbar.classList.add('transparent');
                                navbar.classList.remove('white');
                            }
                        });
                    }

                    document.addEventListener('DOMContentLoaded', function () {
                            const currentPath = window.location.pathname;
                            const origin = window.location.origin;

                        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
                            const href = link.getAttribute('href');
                            if (href === currentPath || href === origin + currentPath) {
                                link.classList.add('active');
                            }
                        });
                    });
            </script>
        </body>
    </html>
