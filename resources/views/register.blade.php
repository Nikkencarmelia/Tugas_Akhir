<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Daftar Akun</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+Javanese:wght@400..700&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+Javanese:wght@400..700&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                border-color: #198754 !important;
                box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, .25) !important;
            }
            .google-icon {
                cursor: pointer;
            }
            .alert {
                margin-bottom: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="container d-flex align-items-center justify-content-center login-container">
            <div class="row w-100 shadow-lg" style="max-width: 1000px; border-radius: 20px; overflow: hidden;">

            <div class="col-md-6 p-5 left-box d-flex flex-column justify-content-center">
                <h2 class="mb-2 fw-bold">Food Center</h2>
                <p>Dinas Ketahanan Pangan Kabupaten Kutai Barat</p>
            </div>

            <div class="col-md-6 p-5 right-box">
                <h2 class="mb-4 fw-bold">Buat Akun</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                <div class="mb-3">
                    <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" placeholder="Nama Lengkap" required>
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="tel" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon') }}" placeholder="No Telepon" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    @error('no_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kata Sandi" style="border-right: none;" required>
                        <span class="input-group-text bg-white" style="border-left: none; cursor: pointer;" onclick="togglePassword('password', 'eyeIcon')">
                            <i class="fas fa-eye-slash text-muted" id="eyeIcon"></i>
                        </span>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Kata Sandi" style="border-right: none;" required>
                        <span class="input-group-text bg-white" style="border-left: none; cursor: pointer;" onclick="togglePassword('password_confirmation', 'eyeIconConfirm')">
                            <i class="fas fa-eye-slash text-muted" id="eyeIconConfirm"></i>
                        </span>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn w-100 mb-3 text-white" style="background-color: #2A522A">Daftar</button>
                <p class="text-center small text-muted">Atau Daftar dengan</p>
                <div class="d-flex justify-content-center gap-3 mb-3">
                    <a href="{{ route('auth.google') }}">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" width="24" alt="Google" class="google-icon">
                    </a>
                </div>
                <p class="text-center small">Sudah Punya Akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #2A522A">Masuk</a></p>
                </form>
            </div>
            </div>
        </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function togglePassword(inputId, iconId) {
                const passwordInput = document.getElementById(inputId);
                const eyeIcon = document.getElementById(iconId);
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
            }
        </script>
    </body>
</html>
