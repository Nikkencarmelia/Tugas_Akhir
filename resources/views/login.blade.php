<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login Page</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+Javanese:wght@400..700&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+Javanese:wght@400..700&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <style>
            body {
                background-color: #F7F7F9;
                font-family: 'Nunito', sans-serif;
            }

            h1, h2, h3, h4, h5, h6,
            .navbar-brand,
            .nav-link,
            .btn {
                font-family: 'Montserrat', sans-serif;
            }

            .login-container {
                min-height: 100vh;
            }

            .left-box {
                background-color: #2A522A;
                color: white;
                border-top-right-radius: 60px;
                border-bottom-right-radius: 60px;
            }

            .left-box h1 {
                font-weight: bold;
            }

            .right-box {
                background-color: white;
                border-top-right-radius: 60px;
                border-bottom-right-radius: 60px;
            }

            .form-control::placeholder {
                font-size: 0.9rem;
            }

            .form-control:focus {
                border-color: #198754 !important; /* warna border success */
                box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, .25) !important; /* efek glow hijau */
            }

        </style>
    </head>
    <body>
        <div class="container d-flex align-items-center justify-content-center login-container">
            <div class="row w-100 shadow-lg" style="max-width: 1000px; border-radius: 20px; overflow: hidden;">

            <!-- KIRI -->
            <div class="col-md-6 p-5 left-box d-flex flex-column justify-content-center">
                <h2 class="mb-2 fw-bold">Food Center</h2>
                <p>Dinas Ketahanan Pangan Kabupaten Kutai Barat</p>
                <img src="https://i.imgur.com/n8f8k0v.png" alt="Illustration" class="img-fluid mt-auto" style="max-height: 250px;">
            </div>

            <!-- KANAN -->
            <div class="col-md-6 p-5 right-box">
                <h2 class="mb-4 fw-bold">Masuk Akun</h2>
                <form>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Email">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Password">
                </div>
                <!-- Lupa Kata Sandi -->
                <div class="mb-3 text-end">
                    <a href="#" class="text-decoration-none fw-bold" style="color: #2A522A; font-size: 0.9rem;">Lupa kata sandi?</a>
                </div>
                <button type="submit" class="btn w-100 mb-3 text-white" style="background-color: #2A522A">Masuk</button>

                <p class="text-center small text-muted">Atau masuk dengan</p>
                <div class="d-flex justify-content-center gap-3 mb-3">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" width="24">
                </div>
                <p class="text-center small">Belum punya akun? <a href="/register" class="text-decoration-none fw-bold" style="color: #2A522A">Daftar</a></p>
                </form>
            </div>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
