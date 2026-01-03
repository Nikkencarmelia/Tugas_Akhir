<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reset Kata Sandi</title>
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
            <div class="row w-100 shadow-lg" style="max-width:1000px;border-radius:20px;overflow:hidden">

                <!-- KIRI -->
                <div class="col-md-6 p-5 left-box d-flex flex-column justify-content-center">
                    <h2 class="fw-bold mb-2">Food Center</h2>
                    <p>Dinas Ketahanan Pangan Kabupaten Kutai Barat</p>
                    <img src="https://i.imgur.com/n8f8k0v.png" class="img-fluid mt-auto" style="max-height:250px">
                </div>

                <!-- KANAN -->
                <div class="col-md-6 p-5 right-box">
                    <h2 class="fw-bold mb-4">Reset Kata Sandi</h2>
                    <p class="text-muted mb-4">Masukkan Kata Sandi baru untuk akun Anda. Pastikan Kata Sandi kuat dan mudah diingat.</p>

                    {{-- ERROR --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- SUCCESS --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- ERROR SESSION --}}
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- FORM RESET PASSWORD --}}
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        {{-- HIDDEN FIELDS --}}
                        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                        <input type="hidden" name="token" value="{{ $token ?? old('token') }}">

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email_display" value="{{ $email ?? old('email') }}" class="form-control" readonly>
                            <small class="form-text text-muted">Email akun Anda (tidak dapat diubah)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kata Sandi Baru</label>
                            <input type="password" name="password" value="{{ old('password') }}"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Kata Sandi baru" required minlength="6">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
                                class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Kata Sandi baru" required minlength="6">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 text-end">
                            <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color:#2A522A;font-size:.9rem">
                                Kembali ke Masuk Akun
                            </a>
                        </div>

                        <button type="submit" class="btn w-100 text-white mb-3" style="background:#2A522A">
                            Update Kata Sandi
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            // Gak ada JS interaksi, cuma placeholder
            console.log('Reset password UI loaded');
        </script>
    </body>
</html>
