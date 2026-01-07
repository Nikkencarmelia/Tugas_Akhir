<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <title>Profil</title>
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
        @extends('components.user')
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
                <div class="profile-icon"><i class="fas fa-user"></i></div>
                <h1 class="profile-name">{{ $user->nama_lengkap }}</h1>
                <p class="profile-email">{{ $user->email }}</p>
                <div class="profile-nav">
                    <a href="{{ route('user.profil') }}" class="nav-link-profile {{ $activeTab == 'info' ? 'active' : '' }}" data-section="info"><i class="fas fa-user"></i> Informasi Pribadi</a>
                    <a href="{{ route('user.profil', ['tab' => 'alamat']) }}" class="nav-link-profile {{ $activeTab == 'alamat' ? 'active' : '' }}" data-section="alamat"><i class="fas fa-map-marker-alt"></i> Alamat</a>
                    <a href="{{ route('user.profil', ['tab' => 'password']) }}" class="nav-link-profile {{ $activeTab == 'password' ? 'active' : '' }}" data-section="password"><i class="fas fa-lock"></i> Ubah Kata Sandi</a>
                    <button class="btn btn-outline-secondary btn-logout" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </div>
            </div>

<div id="info" class="profile-section {{ $activeTab == 'info' ? 'active' : '' }}">
                <h2 class="section-title"><i class="fas fa-user-circle me-2"></i>Informasi Pribadi</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="form-section" action="{{ route('user.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="namaLengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control @error('no_telepon') is-invalid @enderror" id="telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}">
                        @error('no_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success text-white btn-save"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>

<div id="alamat" class="profile-section {{ $activeTab == 'alamat' ? 'active' : '' }}">
                <h2 class="section-title"><i class="fas fa-map-marker-alt me-2"></i>Alamat Pengiriman</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

<div class="text-end mb-3">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahAlamatModal">
                        <i class="fas fa-plus me-1"></i> Tambah Alamat
                    </button>
                </div>

<div class="list-group">
                    @forelse($alamats as $alamat)
                        <div class="list-group-item d-flex justify-content-between align-items-start" data-id="{{ $alamat->id }}">
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $alamat->nama_penerima }}</h6>
                                <p class="mb-1">{{ $alamat->alamat_lengkap }}, {{ $alamat->kelurahan->nama_kelurahan ?? '' }}, {{ $alamat->kecamatan->nama_kecamatan ?? '' }}, {{ $alamat->kodePos->kode_pos ?? '' }}</p>
                                <small>Telp: {{ $alamat->no_telpon }}</small>
                            </div>
                            <div>
                                <button class="btn btn-outline-success btn-sm me-1 edit-alamat" data-bs-toggle="modal" data-bs-target="#editAlamatModal" data-id="{{ $alamat->id }}" data-nama="{{ $alamat->nama_penerima }}" data-telp="{{ $alamat->no_telpon }}" data-kec="{{ $alamat->id_kecamatan }}" data-kel="{{ $alamat->id_kelurahan }}" data-kp="{{ $alamat->id_kode_pos }}" data-alamat="{{ $alamat->alamat_lengkap }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm delete-alamat" data-id="{{ $alamat->id }}" data-nama="{{ $alamat->nama_penerima }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                            <p>Belum ada alamat. Tambahkan alamat pertama Anda!</p>
                        </div>
                    @endforelse
                </div>
            </div>

<div class="modal fade" id="tambahAlamatModal" tabindex="-1" aria-labelledby="tambahAlamatLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahAlamatLabel"><i class="fas fa-map-marker-alt me-2"></i>Tambah Alamat Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form id="formTambahAlamat" method="POST" action="{{ route('user.alamat.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="namaPenerima" class="form-label">Nama Penerima</label>
                                    <input type="text" class="form-control @error('nama_penerima') is-invalid @enderror" id="namaPenerima" name="nama_penerima" placeholder="Masukkan nama penerima" value="{{ old('nama_penerima') }}" required>
                                    @error('nama_penerima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="noTelp" class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control @error('no_telpon') is-invalid @enderror" id="noTelp" name="no_telpon" placeholder="Masukkan nomor telepon penerima" value="{{ old('no_telpon') }}" required>
                                    @error('no_telpon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <select class="form-select @error('id_kecamatan') is-invalid @enderror" id="kecamatan" name="id_kecamatan" required>
                                        <option selected disabled>Pilih Kecamatan</option>
                                        @foreach($kecamatans as $kec)
                                            <option value="{{ $kec->id }}" {{ old('id_kecamatan') == $kec->id ? 'selected' : '' }}>{{ $kec->nama_kecamatan }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_kecamatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kelurahan" class="form-label">Kelurahan</label>
                                    <select class="form-select @error('id_kelurahan') is-invalid @enderror" id="kelurahan" name="id_kelurahan" required disabled>
                                        <option selected disabled>Pilih Kelurahan</option>
                                    </select>
                                    @error('id_kelurahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kodePos" class="form-label">Kode Pos</label>
                                    <select class="form-select @error('id_kode_pos') is-invalid @enderror" id="kodePos" name="id_kode_pos" required disabled>
                                        <option selected disabled>Pilih Kode Pos</option>
                                    </select>
                                    @error('id_kode_pos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="alamatLengkap" class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control @error('alamat_lengkap') is-invalid @enderror" id="alamatLengkap" name="alamat_lengkap" rows="3" placeholder="Contoh: Jl. Mawar No. 12, RT 01 RW 01" required>{{ old('alamat_lengkap') }}</textarea>
                                    @error('alamat_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success text-white">Simpan Alamat</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

<div class="modal fade" id="editAlamatModal" tabindex="-1" aria-labelledby="editAlamatLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAlamatLabel"><i class="fas fa-edit me-2"></i>Edit Alamat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form id="formEditAlamat" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="editAlamatId" name="id">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="editNamaPenerima" class="form-label">Nama Penerima</label>
                                    <input type="text" class="form-control" id="editNamaPenerima" name="nama_penerima" required>
                                </div>

                                <div class="mb-3">
                                    <label for="editNoTelp" class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control" id="editNoTelp" name="no_telpon" required>
                                </div>

                                <div class="mb-3">
                                    <label for="editKecamatan" class="form-label">Kecamatan</label>
                                    <select class="form-select" id="editKecamatan" name="id_kecamatan" required>
                                        <option disabled>Pilih Kecamatan</option>
                                        @foreach($kecamatans as $kec)
                                            <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="editKelurahan" class="form-label">Kelurahan</label>
                                    <select class="form-select" id="editKelurahan" name="id_kelurahan" required disabled>
                                        <option disabled>Pilih Kelurahan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="editKodePos" class="form-label">Kode Pos</label>
                                    <select class="form-select" id="editKodePos" name="id_kode_pos" required disabled>
                                        <option disabled>Pilih Kode Pos</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="editAlamatLengkap" class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control" id="editAlamatLengkap" name="alamat_lengkap" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success text-white" id="btnSimpanEdit">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

<div class="modal fade" id="konfirmasiHapusModal" tabindex="-1" aria-labelledby="konfirmasiHapusLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-danger">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="konfirmasiHapusLabel"><i class="fas fa-trash-alt me-2"></i>Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            Apakah kamu yakin ingin menghapus alamat <strong id="namaAlamatHapus"></strong>? Tindakan ini tidak bisa dibatalkan.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                            <form id="formHapusAlamat" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" id="hapusAlamatId" name="id">
                                <button type="submit" class="btn btn-danger text-white" id="btnKonfirmasiHapus">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<div id="password" class="profile-section {{ $activeTab == 'password' ? 'active' : '' }}">
                <h2 class="section-title"><i class="fas fa-lock me-2"></i>Ubah Kata Sandi</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="passwordForm" class="form-section" action="{{ route('user.profil.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 position-relative">
                        <label for="passwordLama" class="form-label">Kata Sandi Lama</label>
                        <div class="input-group">
                            <input type="password" class="form-control pe-5 @error('password_lama') is-invalid @enderror" id="passwordLama" name="password_lama" value="{{ old('password_lama') }}" placeholder="Kata Sandi Lama" required style="border-right: none;">
                            <span class="input-group-text bg-white" style="border-left: none; cursor: pointer;">
                                <i class="fas fa-eye-slash toggle-password" data-target="passwordLama"></i>
                            </span>
                            @error('password_lama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="passwordBaru" class="form-label">Kata Sandi Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control pe-5 @error('password_baru') is-invalid @enderror" id="passwordBaru" name="password_baru" value="{{ old('password_baru') }}" placeholder="Kata Sandi Baru" required minlength="6" style="border-right: none;">
                            <span class="input-group-text bg-white" style="border-left: none; cursor: pointer;">
                                <i class="fas fa-eye-slash toggle-password" data-target="passwordBaru"></i>
                            </span>
                            @error('password_baru')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="konfirmasiPassword" class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control pe-5 @error('password_baru_confirmation') is-invalid @enderror" id="konfirmasiPassword" name="password_baru_confirmation" value="{{ old('password_baru_confirmation') }}" placeholder="Konfirmasi Kata Sandi Baru" required style="border-right: none;">
                            <span class="input-group-text bg-white" style="border-left: none; cursor: pointer;">
                                <i class="fas fa-eye-slash toggle-password" data-target="konfirmasiPassword"></i>
                            </span>
                            @error('password_baru_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-success text-white btn-save">
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                function showToast(message, type = 'success') {
                    const toastContainer = document.createElement('div');
                    toastContainer.className = `toast align-items-center text-white bg-${type} border-0 position-fixed top-0 end-0 m-3`;
                    toastContainer.style.zIndex = 2000;
                    toastContainer.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                    `;
                    document.body.appendChild(toastContainer);
                    const toast = new bootstrap.Toast(toastContainer, { delay: 2000 });
                    toast.show();
                    toastContainer.addEventListener('hidden.bs.toast', () => toastContainer.remove());
                }

@if(session('success'))
                    showToast('{{ session('success') }}');
                @endif

document.querySelectorAll('.btn-save').forEach(btn => {
                    btn.addEventListener('click', () => {
                        if (btn.textContent.includes('Kata Sandi')) {

                            const modalKonfirmasi = new bootstrap.Modal(document.getElementById('konfirmasiPasswordModal'));
                            modalKonfirmasi.show();
                        }
                    });
                });

const btnKonfirmasiUbahPassword = document.getElementById('btnKonfirmasiUbahPassword');
                if (btnKonfirmasiUbahPassword) {
                    btnKonfirmasiUbahPassword.addEventListener('click', () => {
                        const modalEl = document.getElementById('konfirmasiPasswordModal');
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        modal.hide();

                        document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                        document.body.classList.remove('modal-open');
                        document.body.style = '';

                        const form = document.getElementById('passwordForm');
                        form.submit();
                    });
                }

function enableSelect(selectId) {
                    const $select = $(`#${selectId}`);
                    $select.prop('disabled', false);

                    $select[0].offsetHeight;
                    $select.trigger('change');
                }

$('#kecamatan').change(function() {
                    const kecId = $(this).val();
                    if (kecId) {
                        $.get(`/user/kelurahan/${kecId}`, function(data) {
                            $('#kelurahan').html('<option disabled selected>Pilih Kelurahan</option>');
                            data.forEach(function(kel) {
                                $('#kelurahan').append(`<option value="${kel.id}">${kel.nama_kelurahan}</option>`);
                            });
                            enableSelect('kelurahan');
                            $('#kodePos').html('<option disabled selected>Pilih Kode Pos</option>').prop('disabled', true);
                        });
                    } else {
                        $('#kelurahan').html('<option disabled selected>Pilih Kelurahan</option>').prop('disabled', true);
                        $('#kodePos').html('<option disabled selected>Pilih Kode Pos</option>').prop('disabled', true);
                    }
                });

                $('#kelurahan').change(function() {
                    const kelId = $(this).val();
                    if (kelId) {
                        $.get(`/user/kodepos/${kelId}`, function(data) {
                            $('#kodePos').html('<option disabled selected>Pilih Kode Pos</option>');
                            data.forEach(function(kp) {
                                $('#kodePos').append(`<option value="${kp.id}">${kp.kode_pos}</option>`);
                            });
                            enableSelect('kodePos');
                        });
                    } else {
                        $('#kodePos').html('<option disabled selected>Pilih Kode Pos</option>').prop('disabled', true);
                    }
                });

$('#editKecamatan').change(function() {
                    const kecId = $(this).val();
                    if (kecId) {
                        $.get(`/user/kelurahan/${kecId}`, function(data) {
                            $('#editKelurahan').html('<option disabled selected>Pilih Kelurahan</option>');
                            data.forEach(function(kel) {
                                $('#editKelurahan').append(`<option value="${kel.id}">${kel.nama_kelurahan}</option>`);
                            });
                            enableSelect('editKelurahan');
                            $('#editKodePos').html('<option disabled selected>Pilih Kode Pos</option>').prop('disabled', true);
                        });
                    } else {
                        $('#editKelurahan').html('<option disabled selected>Pilih Kelurahan</option>').prop('disabled', true);
                        $('#editKodePos').html('<option disabled selected>Pilih Kode Pos</option>').prop('disabled', true);
                    }
                });

                $('#editKelurahan').change(function() {
                    const kelId = $(this).val();
                    if (kelId) {
                        $.get(`/user/kodepos/${kelId}`, function(data) {
                            $('#editKodePos').html('<option disabled selected>Pilih Kode Pos</option>');
                            data.forEach(function(kp) {
                                $('#editKodePos').append(`<option value="${kp.id}">${kp.kode_pos}</option>`);
                            });
                            enableSelect('editKodePos');
                        });
                    } else {
                        $('#editKodePos').html('<option disabled selected>Pilih Kode Pos</option>').prop('disabled', true);
                    }
                });

document.querySelectorAll('.edit-alamat').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.id;
                        const nama = btn.dataset.nama;
                        const telp = btn.dataset.telp;
                        const kec = btn.dataset.kec;
                        const kel = btn.dataset.kel;
                        const kp = btn.dataset.kp;
                        const alamat = btn.dataset.alamat;

                        document.getElementById('editAlamatId').value = id;
                        document.getElementById('editNamaPenerima').value = nama;
                        document.getElementById('editNoTelp').value = telp;
                        document.getElementById('editKecamatan').value = kec;
                        document.getElementById('editAlamatLengkap').value = alamat;

if (kec) {
                            const urlKelurahan = `{{ route('user.ajax.kelurahan') }}?id_kecamatan=${kec}`;
                            $.get(urlKelurahan, function(data) {
                                $('#editKelurahan').html('<option disabled selected>Pilih Kelurahan</option>');
                                data.forEach(function(kelData) {
                                    const selected = kelData.id == kel ? 'selected' : '';
                                    $('#editKelurahan').append(`<option value="${kelData.id}" ${selected}>${kelData.nama_kelurahan}</option>`);
                                });
                                enableSelect('editKelurahan');

if (kel) {
                                    const urlKodepos = `{{ route('user.ajax.kodepos') }}?id_kelurahan=${kel}`;
                                    $.get(urlKodepos, function(kpData) {
                                        $('#editKodePos').html('<option disabled selected>Pilih Kode Pos</option>');
                                        kpData.forEach(function(kpItem) {
                                            const selected = kpItem.id == kp ? 'selected' : '';
                                            $('#editKodePos').append(`<option value="${kpItem.id}" ${selected}>${kpItem.kode_pos}</option>`);
                                        });
                                        enableSelect('editKodePos');
                                    });
                                }
                            });
                        }

document.getElementById('formEditAlamat').action = `/user/alamat/${id}`;
                    });
                });

const editModal = document.getElementById('editAlamatModal');
                editModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('formEditAlamat').action = '';
                    document.getElementById('formEditAlamat').reset();
                    $('#editKelurahan').prop('disabled', true).html('<option disabled selected>Pilih Kelurahan</option>');
                    $('#editKodePos').prop('disabled', true).html('<option disabled selected>Pilih Kode Pos</option>');
                });

const btnSimpanEdit = document.getElementById('btnSimpanEdit');
                if (btnSimpanEdit) {
                    btnSimpanEdit.addEventListener('click', (e) => {
                        e.preventDefault();
                        document.getElementById('formEditAlamat').submit();
                    });
                }

let alamatIdToDelete = null;
                document.querySelectorAll('.delete-alamat').forEach(btn => {
                    btn.addEventListener('click', () => {
                        alamatIdToDelete = btn.dataset.id;
                        document.getElementById('namaAlamatHapus').textContent = btn.dataset.nama;
                        document.getElementById('hapusAlamatId').value = alamatIdToDelete;
                        document.getElementById('formHapusAlamat').action = `/user/alamat/${alamatIdToDelete}`;
                        const modalHapus = new bootstrap.Modal(document.getElementById('konfirmasiHapusModal'));
                        modalHapus.show();
                    });
                });

document.querySelectorAll('.nav-link-profile').forEach(link => {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        const tab = link.dataset.section;

                        const url = new URL(window.location);
                        url.searchParams.set('tab', tab);
                        window.history.pushState({}, '', url);

document.querySelectorAll('.nav-link-profile').forEach(l => l.classList.remove('active'));
                        link.classList.add('active');
                        document.querySelectorAll('.profile-section').forEach(s => s.classList.remove('active'));
                        document.getElementById(tab).classList.add('active');
                    });
                });

const urlParams = new URLSearchParams(window.location.search);
                const urlTab = urlParams.get('tab');
                if (urlTab) {
                    document.querySelectorAll('.nav-link-profile').forEach(l => l.classList.remove('active'));
                    const activeLink = document.querySelector(`[data-section="${urlTab}"]`);
                    if (activeLink) activeLink.classList.add('active');
                    document.querySelectorAll('.profile-section').forEach(s => s.classList.remove('active'));
                    const activeSection = document.getElementById(urlTab);
                    if (activeSection) activeSection.classList.add('active');
                }

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
