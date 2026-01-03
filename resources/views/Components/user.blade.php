<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Font Awesome Icons -->
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
                margin-top: 80px; /* Offset untuk navbar fixed */
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
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg @yield('navbar-class', 'white')">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Food Center</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center gap-2">
                        <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.produk') }}">Produk</a></li>

                        @auth
                        <li class="nav-item"><a class="nav-link" href="/riwayat">Riwayat</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.profil') }}">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('keranjang.index') }}">
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
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-secondary" style="border-radius: 20px; padding: 8px 16px; font-weight: 500;">Logout</button>
                            </form>
                        </li>
                        @endauth
                        @guest
                        <li class="nav-item"><a href="/login" class="btn btn-login">Login</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- konten dari halaman lain -->
        @hasSection('content_full')
        @yield('content_full')
        @else
            <div class="container mt-4">
                @yield('content')
            </div>
        @endif

        <!-- footer -->
        <footer>
            <div class="container">
                <div class="row">

                <!-- Kiri: Info Food Center -->
                <div class="col-md-6 pe-md-5">
                    <h5>Food Center</h5>
                    <p class="mb-1">Dinas Ketahanan Pangan Kabupaten Kutai Barat</p>
                    <p class="mb-3">Komplek Perkantoran, Blok E, Barong Tongkok, Kec. Barong Tongkok, Kabupaten Kutai Barat, Kalimantan Timur 75777</p>
                    <p class="mb-0 small">Copyright © 2025 Dinas Ketahanan Pangan Kabupaten Kutai Barat. All rights reserved.</p>
                </div>

                <!-- Tengah: Menu Utama -->
                <div class="col-md-3">
                    <h6>Menu Utama</h6>
                    <ul class="list-unstyled">
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#">Produk</a></li>
                    <li><a href="#">Cara Belanja</a></li>
                    <li><a href="#">Tentang Kami</a></li>
                    </ul>
                </div>

                <!-- Kanan: Kontak Kami -->
                <div class="col-md-3">
                    <h6>Kontak Kami</h6>
                    <p class="mb-2"><i class="fa-solid fa-phone me-2"></i>0812345678</p>
                    <p class="mb-0"><i class="fa-solid fa-envelope me-2"></i>email@gmail.com</p>
                </div>

                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            window.addEventListener('scroll', function () {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.classList.remove('transparent');
                    navbar.classList.add('white');
                } else {
                    navbar.classList.add('transparent');
                    navbar.classList.remove('white');
                }
            });

            // Saat halaman pertama dibuka, kasih class transparent
            document.addEventListener('DOMContentLoaded', function () {
                const navbar = document.querySelector('.navbar');
                navbar.classList.add('transparent');
            });

            //button aktif di halaman itu pada navbar
            document.addEventListener('DOMContentLoaded', function () {
                const currentPath = window.location.pathname;
                document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
                    if (link.getAttribute('href') === currentPath) {
                        link.classList.add('active');
                    }
                });
            });
        </script>
    </body>
</html>
