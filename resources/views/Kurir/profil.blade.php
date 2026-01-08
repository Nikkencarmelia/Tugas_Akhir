<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <title>Profil Kurir</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            body {

                min-height: 100vh;
            }

            .profile-header {
                background: white;
                border-radius: 12px;
                padding: 2rem;
                margin-bottom: 2rem;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                text-align: center;
            }

            .profile-icon {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                background: #198754;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1rem;
                font-size: 40px;
                color: white;
                box-shadow: 0 2px 8px rgba(25,135,84,0.2);
            }

            .profile-name {
                color: #2a522a;
                font-weight: 600;
                font-size: 24px;
                margin-bottom: 0.5rem;
            }

            .profile-email {
                color: #6c757d;
                font-size: 16px;
                margin-bottom: 1.5rem;
            }

            .profile-nav {
                display: flex;
                gap: 0.5rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .nav-link-profile {
                padding: 8px 16px;
                border-radius: 20px;
                text-decoration: none;
                color: #6c757d;
                font-weight: 500;
                transition: background-color 0.2s ease;
                border: 1px solid #dee2e6;
                background: white;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .nav-link-profile.active {
                background: #198754;
                color: white;
                border-color: #198754;
            }

            .nav-link-profile:hover {
                background: #e9ecef;
                color: #495057;
            }

            .profile-section {
                background: white;
                border-radius: 12px;
                padding: 2rem;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                margin-bottom: 2rem;
                display: none;
            }

            .profile-section.active { display: block; }
            .section-title {
                color: #2a522a;
                font-weight: 600;
                margin-bottom: 1.5rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 20px;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: #198754 !important;
                box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25) !important;
            }

            .form-section {
                max-width: 600px;
                margin: 0 auto;
            }

            .form-label {
                font-weight: 500;
                color: #2a522a;
                margin-bottom: 0.5rem;
            }

            .form-control, .form-select {
                border-radius: 8px;
                border: 1px solid #ced4da;
                padding: 10px 12px;
                transition: border-color 0.2s ease;
                font-size: 16px;
            }

            .form-control:focus, .form-select:focus {
                border-color: #198754;
                box-shadow: 0 0 0 0.2rem rgba(25,135,84,0.1);
            }

            .btn-save {
                background: #198754;
                border: none;
                border-radius: 20px;
                padding: 10px 24px;
                color: white;
                font-weight: 600;
                transition: background-color 0.2s ease;
            }

            .btn-save:hover {
                background: #157347;
            }

            .btn-logout {
                background: #f8f9fa;
                color: #6c757d;
                border: 1px solid #dee2e6;
                border-radius: 20px;
                padding: 10px 24px;
                font-weight: 500;
                transition: background-color 0.2s ease;
            }

            .btn-logout:hover {
                background: #e9ecef;
                color: #495057;
            }

            .list-group-item {
                background: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                margin-bottom: 1rem;
                padding: 1rem;
                transition: background-color 0.2s ease;
            }

            .list-group-item:hover {
                background: #e9ecef;
            }

            .btn-outline-primary, .btn-outline-danger {
                border-radius: 20px;
                padding: 6px 10px;
                font-size: 14px;
                transition: background-color 0.2s ease;
            }

            .btn-outline-primary:hover, .btn-outline-danger:hover {
                background-color: #198754;
                border-color: #198754;
                color: white;
            }

            .modal-content {
                border-radius: 12px;
                border: none;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }

            .modal-header {
                background: #198754;
                color: white;
                border-radius: 12px 12px 0 0;
            }

            .modal-header .btn-close {
                filter: invert(1);
            }

            .modal-body {
                max-height: 70vh;
                overflow-y: auto;
                padding: 1.5rem;
            }

            .modal-footer {
                padding: 1rem 1.5rem;
                border-top: 1px solid #dee2e6;
            }

            .btn-primary {
                background: #198754;
                border: none;
                border-radius: 20px;
                padding: 10px 24px;
                font-weight: 600;
            }

            .btn-secondary {
                border-radius: 20px;
                padding: 10px 24px;
                font-weight: 500;
            }

            .toggle-password {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                color: #6c757d;
            }
            .toggle-password:hover {
                color: #198754;
            }

            @media (max-width: 768px) {
                .profile-header, .profile-section, .modal-body {
                    padding: 1.5rem;
                }

                .profile-nav {
                    flex-direction: column;
                    align-items: center;
                }

                .nav-link-profile {
                    width: 100%;
                    max-width: 250px;
                    justify-content: center;
                }

                .profile-icon {
                    width: 80px;
                    height: 80px;
                    font-size: 32px;
                }

                .profile-name { font-size: 20px; }
            }

        </style>
    </head>

    <body>
        @extends('Components.kurir')
        @section('content')

        <div class="container py-5">

            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
                <div id="toastSuccess" class="toast align-items-center text-bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">
                            <i class="fa-solid fa-circle-check me-2"></i>
                            <span id="toastMessage">Berhasil disimpan!</span>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            <div class="profile-header">
                <div class="profile-icon"><i class="fas fa-truck"></i></div>
                <h1 class="profile-name">{{ $user->nama_lengkap ?? 'Nama Pengguna' }}</h1>
                <p class="profile-email">{{ $user->email ?? 'email@example.com' }}</p>
                <div class="profile-nav">
                    <a href="#info" class="nav-link-profile {{ ($activeTab ?? 'info') == 'info' ? 'active' : '' }}" data-section="info"><i class="fas fa-user"></i> Informasi Pribadi</a>
                    <a href="#password" class="nav-link-profile {{ ($activeTab ?? 'info') == 'password' ? 'active' : '' }}" data-section="password"><i class="fas fa-lock"></i> Ubah Kata Sandi</a>
                    <button class="btn btn-outline-secondary btn-logout" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </div>
            </div>

<div id="info" class="profile-section {{ ($activeTab ?? 'info') == 'info' ? 'active' : '' }}">
                <h2 class="section-title"><i class="fas fa-user-circle me-2"></i>Informasi Pribadi</h2>
                <form method="POST" action="{{ route('kurir.profil.update') }}" class="form-section">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control {{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}" id="namaLengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap ?? '') }}" required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control {{ $errors->has('no_telepon') ? 'is-invalid' : '' }}" id="telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon ?? '') }}">
                        @error('no_telepon')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="kendaraan" class="form-label">Kendaraan</label>
                        <select class="form-select {{ $errors->has('jenis_kendaraan') ? 'is-invalid' : '' }}" id="kendaraan" name="jenis_kendaraan" required>
                            <option value="" {{ !isset($kurir->jenis_kendaraan) || $kurir->jenis_kendaraan == '' || is_null($kurir->jenis_kendaraan) ? 'selected' : '' }} disabled>-- Pilih Kendaraan --</option>
                            <option value="motor" {{ (isset($kurir->jenis_kendaraan) && $kurir->jenis_kendaraan == 'motor') ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ (isset($kurir->jenis_kendaraan) && $kurir->jenis_kendaraan == 'mobil') ? 'selected' : '' }}>Mobil</option>
                        </select>
                        @error('jenis_kendaraan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success text-white btn-save"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>

<div id="password" class="profile-section {{ ($activeTab ?? 'info') == 'password' ? 'active' : '' }}">
                <h2 class="section-title"><i class="fas fa-lock me-2"></i>Ubah Kata Sandi</h2>
                <form id="passwordForm" method="POST" action="{{ route('kurir.profil.password') }}" class="form-section">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 position-relative">
                        <label for="passwordLama" class="form-label">Kata Sandi Lama</label>
                        <div class="input-group">
                            <input type="password" class="form-control pe-5 {{ $errors->has('password_lama') ? 'is-invalid' : '' }}" id="passwordLama" name="password_lama" placeholder="Kata Sandi Lama" required style="border-right: none;">
                            <span class="input-group-text bg-white" style="border-left: none; cursor: pointer;">
                                <i class="fas fa-eye-slash toggle-password" data-target="passwordLama"></i>
                            </span>
                        </div>
                        @error('password_lama')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="passwordBaru" class="form-label">Kata Sandi Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control pe-5 {{ $errors->has('password_baru') ? 'is-invalid' : '' }}" id="passwordBaru" name="password_baru" placeholder="Kata Sandi Baru" required minlength="6" style="border-right: none;">
                            <span class="input-group-text bg-white" style="border-left: none; cursor: pointer;">
                                <i class="fas fa-eye-slash toggle-password" data-target="passwordBaru"></i>
                            </span>
                        </div>
                        @error('password_baru')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="konfirmasiPassword" class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control pe-5 {{ $errors->has('password_baru_confirmation') ? 'is-invalid' : '' }}" id="konfirmasiPassword" name="password_baru_confirmation" placeholder="Konfirmasi Kata Sandi Baru" required style="border-right: none;">
                            <span class="input-group-text bg-white" style="border-left: none; cursor: pointer;">
                                <i class="fas fa-eye-slash toggle-password" data-target="konfirmasiPassword"></i>
                            </span>
                        </div>
                        @error('password_baru_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-success text-white btn-save" id="btnUbahPassword">
                            <i class="fas fa-key me-1"></i> Ubah Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

<div class="modal fade" id="konfirmasiPasswordModal" tabindex="-1" aria-labelledby="konfirmasiPasswordLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-success">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="konfirmasiPasswordLabel"><i class="fas fa-key me-2"></i>Konfirmasi Perubahan Kata Sandi</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah kamu yakin ingin mengubah kata sandi? Pastikan sudah diisi dengan benar.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-success text-white" id="btnKonfirmasiUbahPassword">Ya, Ubah</button>
                        </div>
                    </div>
                </div>
            </div>

</div>

        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const toast = new bootstrap.Toast(document.getElementById('toastSuccess'));
                    document.getElementById('toastMessage').textContent = '{{ session('success') }}';
                    toast.show();
                });
            </script>
        @endif

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

const btnUbahPassword = document.getElementById('btnUbahPassword');
                if (btnUbahPassword) {
                    btnUbahPassword.addEventListener('click', (e) => {
                        e.preventDefault();

                        const modalKonfirmasi = new bootstrap.Modal(document.getElementById('konfirmasiPasswordModal'));
                        modalKonfirmasi.show();
                    });
                }

                const btnKonfirmasiUbahPassword = document.getElementById('btnKonfirmasiUbahPassword');
                if (btnKonfirmasiUbahPassword) {
                    btnKonfirmasiUbahPassword.addEventListener('click', () => {
                        const modalEl = document.getElementById('konfirmasiPasswordModal');
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        modal.hide();

                        document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                        document.body.classList.remove('modal-open');
                        document.body.style = '';

                        document.getElementById('passwordForm').submit();
                    });
                }

document.querySelectorAll('.nav-link-profile').forEach(link => {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        document.querySelectorAll('.nav-link-profile').forEach(l => l.classList.remove('active'));
                        link.classList.add('active');
                        document.querySelectorAll('.profile-section').forEach(s => s.classList.remove('active'));
                        document.getElementById(link.dataset.section).classList.add('active');
                    });
                });

document.querySelectorAll('.toggle-password').forEach(icon => {
                    icon.addEventListener('click', () => {
                        const input = document.getElementById(icon.dataset.target);
                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.classList.replace('fa-eye-slash', 'fa-eye');
                        } else {
                            input.type = 'password';
                            icon.classList.replace('fa-eye', 'fa-eye-slash');
                        }
                    });
                });

});
        </script>

        @endsection
    </body>
</html>
