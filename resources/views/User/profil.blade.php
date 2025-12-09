<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <title>Profil</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            body {
                /* background: #f8f9fa;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */
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
    top: 70%;
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
            <!-- TOAST -->
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
                <h1 class="profile-name">John Doe</h1>
                <p class="profile-email">johndoe@example.com</p>
                <div class="profile-nav">
                    <a href="#info" class="nav-link-profile active" data-section="info"><i class="fas fa-user"></i> Informasi Pribadi</a>
                    <a href="#alamat" class="nav-link-profile" data-section="alamat"><i class="fas fa-map-marker-alt"></i> Alamat</a>
                    <a href="#password" class="nav-link-profile" data-section="password"><i class="fas fa-lock"></i> Ubah Password</a>
                    <button class="btn btn-outline-secondary btn-logout" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </div>
            </div>

            <!-- ===================== INFORMASI PRIBADI ===================== -->
            <div id="info" class="profile-section active">
                <h2 class="section-title"><i class="fas fa-user-circle me-2"></i>Informasi Pribadi</h2>
                <form class="form-section">
                    <div class="mb-3">
                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="namaLengkap" value="Nikken Carmelia">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="nikken@mail.com">
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" id="telepon" value="08123456789">
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-success text-white btn-save"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- ===================== ALAMAT PENGIRIMAN ===================== -->
            <div id="alamat" class="profile-section">
                <h2 class="section-title"><i class="fas fa-map-marker-alt me-2"></i>Alamat Pengiriman</h2>

                <!-- Tombol Tambah Alamat -->
                <div class="text-end mb-3">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahAlamatModal">
                        <i class="fas fa-plus me-1"></i> Tambah Alamat
                    </button>
                </div>

                <!-- Daftar Alamat -->
                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1 fw-bold">Nikken Carmelia</h6>
                            <p class="mb-1">Jl. Pahlawan No. 45, RT 03 RW 02, Kel. Melak Ulu, Kec. Melak, 75711</p>
                            <small>Telp: 08123456789</small>
                        </div>
                        <div>
                            <button class="btn btn-outline-success btn-sm me-1"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1 fw-bold">Citra Anggraini</h6>
                            <p class="mb-1">Jl. Mawar No. 12, RT 01 RW 01, Kel. Simpang Raya, Kec. Barong Tongkok, 75712</p>
                            <small>Telp: 08129876543</small>
                        </div>
                        <div>
                            <button class="btn btn-outline-success btn-sm me-1"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== MODAL TAMBAH ALAMAT ===================== -->
            <div class="modal fade" id="tambahAlamatModal" tabindex="-1" aria-labelledby="tambahAlamatLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahAlamatLabel"><i class="fas fa-map-marker-alt me-2"></i>Tambah Alamat Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="namaPenerima" class="form-label">Nama Penerima</label>
                                    <input type="text" class="form-control" id="namaPenerima" placeholder="Masukkan nama penerima">
                                </div>

                                <div class="mb-3">
                                    <label for="noTelp" class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control" id="noTelp" placeholder="Masukkan nomor telepon penerima">
                                </div>

                                <div class="mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <select class="form-select" id="kecamatan">
                                        <option selected disabled>Pilih Kecamatan</option>
                                        <option value="barong-tongkok">Barong Tongkok</option>
                                        <option value="melak">Melak</option>
                                        <option value="damai">Damai</option>
                                        <option value="linggang-bigung">Linggang Bigung</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="kelurahan" class="form-label">Kelurahan</label>
                                    <select class="form-select" id="kelurahan">
                                        <option selected disabled>Pilih Kelurahan</option>
                                        <option value="simpang-raya">Simpang Raya</option>
                                        <option value="melak-ulu">Melak Ulu</option>
                                        <option value="linggang-melapeh">Linggang Melapeh</option>
                                        <option value="barong-loko">Barong Loko</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="kodePos" class="form-label">Kode Pos</label>
                                    <select class="form-select" id="kodePos">
                                        <option selected disabled>Pilih Kode Pos</option>
                                        <option value="75711">75711</option>
                                        <option value="75712">75712</option>
                                        <option value="75713">75713</option>
                                        <option value="75714">75714</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="alamatLengkap" class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control" id="alamatLengkap" rows="3" placeholder="Contoh: Jl. Mawar No. 12, RT 01 RW 01"></textarea>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-success text-white">Simpan Alamat</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== MODAL EDIT ALAMAT ===================== -->
            <div class="modal fade" id="editAlamatModal" tabindex="-1" aria-labelledby="editAlamatLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAlamatLabel"><i class="fas fa-edit me-2"></i>Edit Alamat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form id="formEditAlamat">
                            <div class="mb-3">
                                <label for="editNamaPenerima" class="form-label">Nama Penerima</label>
                                <input type="text" class="form-control" id="editNamaPenerima">
                            </div>

                            <div class="mb-3">
                                <label for="editNoTelp" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="editNoTelp">
                            </div>

                            <div class="mb-3">
                                <label for="editKecamatan" class="form-label">Kecamatan</label>
                                <select class="form-select" id="editKecamatan">
                                <option value="barong-tongkok">Barong Tongkok</option>
                                <option value="melak">Melak</option>
                                <option value="damai">Damai</option>
                                <option value="linggang-bigung">Linggang Bigung</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="editKelurahan" class="form-label">Kelurahan</label>
                                <select class="form-select" id="editKelurahan">
                                <option value="simpang-raya">Simpang Raya</option>
                                <option value="melak-ulu">Melak Ulu</option>
                                <option value="linggang-melapeh">Linggang Melapeh</option>
                                <option value="barong-loko">Barong Loko</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="editKodePos" class="form-label">Kode Pos</label>
                                <select class="form-select" id="editKodePos">
                                <option value="75711">75711</option>
                                <option value="75712">75712</option>
                                <option value="75713">75713</option>
                                <option value="75714">75714</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="editAlamatLengkap" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="editAlamatLengkap" rows="3"></textarea>
                            </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-success text-white" id="btnSimpanEdit">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== MODAL KONFIRMASI HAPUS ALAMAT ===================== -->
            <div class="modal fade" id="konfirmasiHapusModal" tabindex="-1" aria-labelledby="konfirmasiHapusLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-success">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="konfirmasiHapusLabel"><i class="fas fa-trash-alt me-2"></i>Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            Apakah kamu yakin ingin menghapus alamat ini? Tindakan ini tidak bisa dibatalkan.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-success text-white" id="btnKonfirmasiHapus">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- ===================== UBAH PASSWORD ===================== -->
            <div id="password" class="profile-section">
                <h2 class="section-title"><i class="fas fa-lock me-2"></i>Ubah Password</h2>
                <form class="form-section">
                    <div class="mb-3 position-relative">
                        <label for="passwordLama" class="form-label">Password Lama</label>
                        <input type="password" class="form-control pe-5" id="passwordLama">
                        <i class="fas fa-eye toggle-password" data-target="passwordLama"></i>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="passwordBaru" class="form-label">Password Baru</label>
                        <input type="password" class="form-control pe-5" id="passwordBaru">
                        <i class="fas fa-eye toggle-password" data-target="passwordBaru"></i>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="konfirmasiPassword" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control pe-5" id="konfirmasiPassword">
                        <i class="fas fa-eye toggle-password" data-target="konfirmasiPassword"></i>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-success text-white btn-save">
                            <i class="fas fa-key me-1"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- ===================== MODAL KONFIRMASI UBAH PASSWORD ===================== -->
            <div class="modal fade" id="konfirmasiPasswordModal" tabindex="-1" aria-labelledby="konfirmasiPasswordLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-success">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="konfirmasiPasswordLabel"><i class="fas fa-key me-2"></i>Konfirmasi Perubahan Password</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah kamu yakin ingin mengubah password? Pastikan sudah diisi dengan benar.
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
            // === TOAST SETUP (global) ===
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

            // === TOMBOL SIMPAN & PASSWORD ===
            document.querySelectorAll('.btn-save').forEach(btn => {
                btn.addEventListener('click', () => {
                if (btn.textContent.includes('Simpan')) {
                    showToast('Perubahan berhasil disimpan!');
                } else if (btn.textContent.includes('Password')) {
                    // buka konfirmasi ubah password
                    const modalKonfirmasi = new bootstrap.Modal(document.getElementById('konfirmasiPasswordModal'));
                    modalKonfirmasi.show();
                }
                });
            });

            // === KONFIRMASI UBAH PASSWORD ===
            const btnKonfirmasiUbahPassword = document.getElementById('btnKonfirmasiUbahPassword');
            if (btnKonfirmasiUbahPassword) {
                btnKonfirmasiUbahPassword.addEventListener('click', () => {
                const modalEl = document.getElementById('konfirmasiPasswordModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                document.body.classList.remove('modal-open');
                document.body.style = '';

                showToast('Password berhasil diubah!', 'success');
                });
            }

            // === TOMBOL SIMPAN ALAMAT BARU ===
            const btnAlamat = document.querySelector('.modal-footer .btn-success');
            if (btnAlamat) {
                btnAlamat.addEventListener('click', () => {
                const modalEl = btnAlamat.closest('.modal');
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.hide();

                // Hapus backdrop biar layar gak gelap
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                document.body.classList.remove('modal-open');
                document.body.style = '';
                showToast('Alamat baru berhasil ditambahkan!');
                });
            }

            // === EDIT ALAMAT ===
            document.querySelectorAll('.btn-outline-success').forEach(btn => {
                if (btn.querySelector('.fa-edit')) {
                btn.addEventListener('click', () => {
                    const parent = btn.closest('.list-group-item');
                    const nama = parent.querySelector('h6').textContent.trim();
                    const alamat = parent.querySelector('p').textContent.trim();
                    const telp = parent.querySelector('small').textContent.replace('Telp: ', '').trim();

                    document.getElementById('editNamaPenerima').value = nama;
                    document.getElementById('editNoTelp').value = telp;
                    document.getElementById('editAlamatLengkap').value = alamat;

                    const modalEdit = new bootstrap.Modal(document.getElementById('editAlamatModal'));
                    modalEdit.show();
                });
                }
            });

            // === SIMPAN EDIT ALAMAT ===
            const btnSimpanEdit = document.getElementById('btnSimpanEdit');
            if (btnSimpanEdit) {
                btnSimpanEdit.addEventListener('click', () => {
                const modalEl = document.getElementById('editAlamatModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                document.body.classList.remove('modal-open');
                document.body.style = '';
                showToast('Alamat berhasil diperbarui!');
                });
            }

            // === HAPUS ALAMAT (PAKAI KONFIRMASI MODAL) ===
            let alamatYangAkanDihapus = null;
            document.querySelectorAll('.btn-outline-danger').forEach(btn => {
                btn.addEventListener('click', () => {
                alamatYangAkanDihapus = btn.closest('.list-group-item');
                const modalHapus = new bootstrap.Modal(document.getElementById('konfirmasiHapusModal'));
                modalHapus.show();
                });
            });

            const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
            if (btnKonfirmasiHapus) {
                btnKonfirmasiHapus.addEventListener('click', () => {
                const modalEl = document.getElementById('konfirmasiHapusModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                if (alamatYangAkanDihapus) {
                    alamatYangAkanDihapus.remove();
                    alamatYangAkanDihapus = null;
                }

                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                document.body.classList.remove('modal-open');
                document.body.style = '';

                showToast('Alamat berhasil dihapus!', 'danger');
                });
            }

            // === GANTI TAB PROFIL ===
            document.querySelectorAll('.nav-link-profile').forEach(link => {
                link.addEventListener('click', e => {
                e.preventDefault();
                document.querySelectorAll('.nav-link-profile').forEach(l => l.classList.remove('active'));
                link.classList.add('active');
                document.querySelectorAll('.profile-section').forEach(s => s.classList.remove('active'));
                document.getElementById(link.dataset.section).classList.add('active');
                });
            });

            // === TOGGLE PASSWORD ===
            document.querySelectorAll('.toggle-password').forEach(icon => {
                icon.addEventListener('click', () => {
                const input = document.getElementById(icon.dataset.target);
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
                });
            });

            // === LOGOUT ===
            window.logout = function() {
                if (confirm('Yakin logout?')) window.location.href = '/login';
            };
            });
        </script>


        @endsection
    </body>
</html>
