<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manajemen Pengurus - Super Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            :root {
                --green-primary: #166534;
                --green-soft: #E9F7EF;
                --green-text: #15803D;
                --border-color: #E5E7EB;
                --text-dark: #1F2937;
                --text-muted: #6B7280;
                --bg-main: #F9FAFB;
                --white: #FFFFFF;
                --shadow: rgba(0,0,0,0.05);
            }

            .orders-header{
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-bottom:2rem;
                background:var(--white);
                padding:1.5rem 2rem;
                border-radius:16px;
                box-shadow:0 4px 20px var(--shadow);
            }

            .orders-header h3{
                color:#2a522a;
                font-weight:700;
                margin:0;
                display:flex;
                align-items:center;
                gap:.5rem;
            }

            .orders-header h3 i {
                color: #2a522a;
            }

            .orders-header .search-input-group {
                flex-grow: 1;
                max-width: 500px;
                margin-left: 1rem;
            }

            .orders-header .search-input-group .form-control {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
                border-radius: 5px;
            }

            .orders-header .search-input-group .input-group-text {
                background: #f8f9fa;
                border-radius: 5px;
                border: 1px solid var(--border-color);
            }

            .btn-add {
                background: #198754;
                border-color: #198754;
                border-radius: 10px;
                padding: 0.5rem 1rem;
                font-weight: 500;
                transition: all 0.2s ease;
                color: var(--white);
            }

            .btn-add:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
            }

            .table {
                background: var(--white);
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 12px var(--shadow);
            }
            .table thead th {
                background: #f8f9fa;
                border: none;
                font-weight: 600;
                color: #495057;
                padding: 1rem;
                border-bottom: 2px solid var(--border-color);
            }
            .table tbody tr {
                transition: background-color 0.2s ease;
            }
            .table tbody tr:hover {
                background: #f8f9fa;
            }
            .table tbody td {
                padding: 1rem;
                vertical-align: middle;
                border: none;
            }
            .img-thumbnail { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
            .btn-primary {
                border-radius: 10px;
                padding: 0.5rem 1rem;
                font-weight: 500;
                transition: all 0.2s ease;
                background: #0d6efd;
                border-color: #0d6efd;
            }
            .btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            }
            .modal-content {
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
                border: none;
                overflow: hidden;
            }
            .modal-header {
                background: var(--white);
                color: #495057;
                border-bottom: 1px solid #e9ecef;
                padding: 1.5rem 2rem;
                border-radius: 20px 20px 0 0 !important;
            }
            .modal-header .btn-close {
                filter: invert(0);
                opacity: 0.8;
            }
            .modal-header .btn-close:hover {
                opacity: 1;
            }
            .modal-title {
                font-weight: 600;
                font-size: 1.25rem;
            }
            .modal-body {
                padding: 2rem;
                background: var(--white);
            }
            .modal-body .form-label {
                font-weight: 500;
                color: #495057;
                font-size: 0.875rem;
            }
            .modal-body .form-control, .modal-body .form-select {
                border-radius: 10px;
                border: 1px solid #e9ecef;
                padding: 0.75rem 1rem;
                transition: all 0.2s ease;
            }
            .modal-body .form-control:focus, .modal-body .form-select:focus {
                border-color: #0d6efd;
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
            }
            .modal-body .form-file {
                border-radius: 10px;
                border: 1px solid #e9ecef;
                padding: 0.75rem;
            }

            .modal-body .form-file:focus-within {
                border-color: #0d6efd;
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
            }

            .modal-body .img-preview {
                max-width: 200px;
                max-height: 200px;
                border-radius: 10px;
                display: none;
                margin-top: 1rem;
            }

            .modal-footer {
                background: #f8f9fa;
                border-top: 1px solid #e9ecef;
                padding: 1.5rem 2rem;
                border-radius: 0 0 20px 20px;
            }

            .search-controls {
                display: flex;
                gap: 1rem;
                align-items: center;
                margin-bottom: 1rem;
            }

            .search-controls .input-group {
                flex-grow: 1;
            }

            .deskripsi-text {
                max-width: 200px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .modal-rusak .form-control {
                border-radius: .5rem;
            }

            .modal-rusak .form-label {
                font-weight: 600;
            }

            .modal-rusak input[type="file"] {
                border: 1px solid var(--border-color);
                border-radius: .5rem;
                padding: .5rem;
            }

            .toast-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1055;
            }

            .alert {
                border-radius: 10px;
            }

            #modalDeleteConfirm .modal-content {
                border-radius: 20px !important;
            }

            #modalDeleteConfirm .modal-header {
                background: var(--white) !important;
                color: #495057 !important;
                border-radius: 20px 20px 0 0 !important;
                border-bottom: 1px solid #e9ecef !important;
                padding: 1.5rem 2rem !important;
            }

            #modalDeleteConfirm .modal-header .btn-close {
                filter: invert(0) !important;
                opacity: 0.8 !important;
            }

            #modalDeleteConfirm .modal-header .btn-close:hover {
                opacity: 1 !important;
            }

            #modalDeleteConfirm .modal-body {
                background: var(--white) !important;
                padding: 2rem !important;
                border-radius: 0 !important;
            }

            #modalDeleteConfirm .modal-footer {
                background: #f8f9fa !important;
                border-top: 1px solid #e9ecef !important;
                padding: 1.5rem 2rem !important;
                border-radius: 0 0 20px 20px !important;
            }

            #modalDeleteConfirm .modal-dialog {
                margin: 1.75rem auto;
                max-width: 500px;
            }

        </style>
    </head>
    <body>
        @extends('components.super_admin')
        @section('content')
        <div class="container py-5">

            <div class="orders-header mb-4">
                <h3><i class="bi bi-person-lines-fill"></i> Manajemen Pengurus</h3>
                <div class="d-flex align-items-center gap-2">
                    <div class="search-input-group">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchPengurus" class="form-control" placeholder="Cari nama atau jabatan...">
                        </div>
                    </div>
                    <button class="btn btn-success btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-lg"></i> Tambah Pengurus
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tablePengurus">
                    <thead>
                        <tr>
                            <th width="80">Gambar</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th width="250">Deskripsi</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kepengurusan as $item)
                        <tr data-nama="{{ strtolower($item->nama) }}"
                            data-jabatan="{{ strtolower($item->jabatan) }}">

                            <td>
                                @if($item->gambar)
                                    <img src="{{ asset('storage/'.$item->gambar) }}" class="img-thumbnail" width="60">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>

                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td class="deskripsi-text">
                                {{ $item->deskripsi }}
                            </td>

                            <td>
                                <button class="btn btn-warning btn-sm me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $item->id }}"
                                        title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button type="button" class="btn btn-danger btn-sm btn-delete-pengurus"
                                        data-id="{{ $item->id }}"
                                        data-nama="{{ $item->nama }}"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade modal-rusak" id="modalEdit{{ $item->id }}">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST"
                                        enctype="multipart/form-data"
                                        action="{{ route('super_admin.pengurus.update', $item->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Pengurus: {{ $item->nama }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                <input type="text" class="form-control" name="nama" value="{{ $item->nama }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Jabatan</label>
                                                <input type="text" class="form-control" name="jabatan" value="{{ $item->jabatan }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea class="form-control" name="deskripsi" rows="3">{{ $item->deskripsi }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Gambar</label>
                                                <input type="file" name="gambar" class="form-control" accept="image/*">
                                                @if($item->gambar)
                                                    <div class="mt-2">
                                                        <img src="{{ asset('storage/'.$item->gambar) }}" class="img-preview" alt="Gambar Saat Ini" style="display: block; max-width: 200px; border-radius: 10px;">
                                                    </div>
                                                    <small class="text-muted">Upload gambar baru untuk mengganti.</small>
                                                @else
                                                    <img src="" class="img-preview" alt="Preview" style="display: none;">
                                                @endif
                                                <br>
                                                <small class="text-muted">Format: JPG, JPEG, PNG. Maks 5MB.</small>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada data pengurus. Tambahkan yang pertama!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade modal-rusak" id="modalTambah" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('super_admin.pengurus.store') }}">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Pengurus Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" placeholder="Masukkan nama lengkap" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" class="form-control" name="jabatan" placeholder="Masukkan jabatan" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3" placeholder="Masukkan deskripsi singkat" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gambar Profil</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*" required>
                                <div class="mt-2 text-center">
                                    <img src="" class="img-preview" alt="Preview Gambar" style="display: none; max-width: 200px; border-radius: 10px;">
                                </div>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maks 5MB.</small>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Pengurus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalDeleteConfirm" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5>Konfirmasi Hapus</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Yakin hapus <strong id="deleteName"></strong>?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="toast-container">
            <div id="toastSuccess" class="toast align-items-center text-white bg-success border-0" role="alert" data-bs-autohide="true" data-bs-delay="5000">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-2"></i>
                        @if(session('success'))
                            {{ session('success') }}
                        @else
                            Data berhasil disimpan!
                        @endif
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
            <div id="toastError" class="toast align-items-center text-white bg-danger border-0" role="alert" data-bs-autohide="true" data-bs-delay="5000">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        @if($errors->any())
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @elseif(session('error'))
                            {{ session('error') }}
                        @else
                            Terjadi kesalahan. Silakan coba lagi.
                        @endif
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>

        @endsection

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const searchInput = document.getElementById('searchPengurus');
                const tableRows = document.querySelectorAll('#tablePengurus tbody tr');

                searchInput.addEventListener('input', function() {
                    const val = this.value.toLowerCase();
                    tableRows.forEach(row => {
                        const nama = (row.dataset.nama || '').toLowerCase();
                        const jabatan = (row.dataset.jabatan || '').toLowerCase();
                        row.style.display = (nama.includes(val) || jabatan.includes(val)) ? '' : 'none';
                    });
                });

                const addFileInput = document.querySelector('#modalTambah input[name="gambar"]');
                const addPreview = document.querySelector('#modalTambah .img-preview');
                if (addFileInput) {
                    addFileInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                addPreview.src = e.target.result;
                                addPreview.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        } else {
                            addPreview.style.display = 'none';
                        }
                    });
                }

                // Setup Validation Toast
                const toastId = 'validationToast';
                let toastEl = document.getElementById(toastId);
                if (!toastEl) {
                    let toastContainer = document.querySelector('.toast-container');
                    if (!toastContainer) {
                        toastContainer = document.createElement('div');
                        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                        toastContainer.style.zIndex = '2000';
                        document.body.appendChild(toastContainer);
                    }

                    toastEl = document.createElement('div');
                    toastEl.id = toastId;
                    toastEl.className = 'toast align-items-center text-white bg-danger border-0';
                    toastEl.setAttribute('role', 'alert');
                    toastEl.setAttribute('aria-live', 'assertive');
                    toastEl.setAttribute('aria-atomic', 'true');
                    toastEl.innerHTML = `
                        <div class="d-flex">
                            <div class="toast-body" id="toastBody"></div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    `;
                    toastContainer.appendChild(toastEl);
                }
                const toastBody = document.getElementById('toastBody');
                const toast = new bootstrap.Toast(toastEl);

                function showToast(message) {
                    toastBody.textContent = message;
                    toast.show();
                }

                document.querySelectorAll('input[name="gambar"]').forEach(fileInput => {
                    const preview = fileInput.closest('.modal').querySelector('.img-preview');
                    if (preview) {
                        fileInput.addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                if (!file.type.startsWith('image/')) {
                                    showToast('File yang dipilih bukan gambar!');
                                    this.value = '';
                                    preview.src = '#';
                                    preview.style.display = 'none';
                                    return;
                                }

                                const maxSize = 5 * 1024 * 1024; // 5MB
                                if (file.size > maxSize) {
                                    showToast('Ukuran file terlalu besar! Maksimal 5MB.');
                                    this.value = '';
                                    preview.src = '#';
                                    preview.style.display = 'none';
                                    return;
                                }

                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    preview.src = e.target.result;
                                    preview.style.display = 'block';
                                };
                                reader.readAsDataURL(file);
                            } else {
                                preview.style.display = 'none';
                            }
                        });
                    }
                });

                @if(session('success'))
                    const successToast = new bootstrap.Toast(document.getElementById('toastSuccess'));
                    successToast.show();
                @endif

                @if($errors->any() || session('error'))
                    const errorToast = new bootstrap.Toast(document.getElementById('toastError'));
                    errorToast.show();
                @endif

                document.querySelectorAll('form[action*="update"]').forEach(form => {
                    const inputs = form.querySelectorAll('input[type="text"], textarea, input[type="file"]');
                    let originalData = {};

                    form.closest('.modal').addEventListener('shown.bs.modal', () => {
                        originalData = {};
                        inputs.forEach(input => {
                            if (input.type !== 'file') {
                                originalData[input.name] = input.value;
                            }
                        });
                    });

                    form.addEventListener('submit', (e) => {
                        let hasChanges = false;
                        inputs.forEach(input => {
                            if (input.type === 'file' && input.files.length > 0) {
                                hasChanges = true;
                            } else if (input.value !== originalData[input.name]) {
                                hasChanges = true;
                            }
                        });
                        if (!hasChanges) {
                            e.preventDefault();
                            alert('Tidak ada perubahan. Edit data terlebih dahulu.');
                        }
                    });
                });

                const deleteModalEl = document.getElementById('modalDeleteConfirm');
                const deleteModal = new bootstrap.Modal(deleteModalEl);
                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                let deleteId = null;

                document.querySelectorAll('.btn-delete-pengurus').forEach(btn => {
                    btn.addEventListener('click', function () {
                        deleteId = this.dataset.id;
                        document.getElementById('deleteName').textContent = this.dataset.nama;
                        deleteModal.show();
                    });
                });

                confirmDeleteBtn.addEventListener('click', function () {
                    if (!deleteId) return;

                    deleteModal.hide();

                    setTimeout(() => {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = "{{ route('super_admin.pengurus.destroy', ':id') }}".replace(':id', deleteId);
                        form.innerHTML = `
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }, 300);
                });

                deleteModalEl.addEventListener('hidden.bs.modal', function () {
                    deleteId = null;
                    document.body.classList.remove('modal-open');
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                });

                document.querySelectorAll('#modalEdit input[type="submit"]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        btn.disabled = true;
                        btn.innerHTML = '<i class="bi bi-hourglass-split spinner-border-sm me-1"></i>Memproses...';
                    });
                });
            });
        </script>

    </body>
</html>
