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
        body { background: #f5f7fa; }
        .orders-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;background:white;padding:1.5rem 2rem;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.08);}
        .orders-header h3{color:#2a522a;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;}
        .orders-header h3 i { color: #198754; }
        .orders-header .search-input-group { flex-grow: 1; max-width: 500px; margin-left: 1rem; }
        .orders-header .search-input-group .form-control { padding: 0.5rem 1rem; font-size: 0.875rem; border-radius: 5px; }
        .orders-header .search-input-group .input-group-text { background: #f8f9fa; border-radius: 5px; border: 1px solid #dee2e6; }
        .btn-add { background: #198754; border-color: #198754; border-radius: 10px; padding: 0.5rem 1rem; font-weight: 500; transition: all 0.2s ease; }
        .btn-add:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3); }
        .table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .table thead th {
            background: #f8f9fa;
            border: none;
            font-weight: 600;
            color: #495057;
            padding: 1rem;
            border-bottom: 2px solid #e9ecef;
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
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
        }
        .modal-content {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: none;
            overflow: hidden;
        }
        .modal-header {
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
            border-bottom: none;
            padding: 1.5rem 2rem;
            border-radius: 20px 20px 0 0 !important;
        }
        .modal-header .btn-close {
            filter: invert(1);
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
            background: #fafbfc;
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
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.1);
        }
        .modal-body .form-file { border-radius: 10px; border: 1px solid #e9ecef; padding: 0.75rem; }
        .modal-body .form-file:focus-within { border-color: #198754; box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.1); }
        .modal-body .img-preview { max-width: 200px; max-height: 200px; border-radius: 10px; display: none; }
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
        .deskripsi-text { max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    </style>
</head>
<body>
@extends('components.super_admin')
@section('content')
<div class="container py-5">
    <div class="orders-header">
        <h3><i class="bi bi-person-lines-fill"></i>Manajemen Pengurus</h3>
        <div class="d-flex align-items-center gap-2">
            <div class="search-input-group">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchPengurus" class="form-control" placeholder="Cari nama atau jabatan...">
                </div>
            </div>
            <button class="btn btn-success btn-add" data-bs-toggle="modal" data-bs-target="#modalPengurus" id="btnAddPengurus">
                <i class="bi bi-plus-lg"></i> Tambah Pengurus
            </button>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold">Data Pengurus</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="tablePengurus">
            <thead>
                <tr>
                    <th style="width: 80px">Gambar</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th style="width: 200px">Deskripsi</th>
                    <th style="width: 140px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kepengurusan ?? [] as $index => $item)
                <tr data-id="{{ $item['id'] ?? $index }}" data-nama="{{ $item['nama'] ?? '' }}" data-jabatan="{{ $item['jabatan'] ?? '' }}" data-deskripsi="{{ $item['deskripsi'] ?? '' }}">
                    <td>
                        @if($item['gambar'] ?? '')
                            <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama'] }}" class="img-thumbnail">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>
                    <td>{{ $item['nama'] ?? '' }}</td>
                    <td>{{ $item['jabatan'] ?? '' }}</td>
                    <td class="deskripsi-text">{{ $item['deskripsi'] ?? '' }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-edit-pengurus" data-bs-toggle="modal" data-bs-target="#modalPengurus" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete-pengurus" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data pengurus.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{-- Modal Tambah/Edit Pengurus --}}
<div class="modal fade" id="modalPengurus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titlePengurus">Tambah Pengurus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formPengurus" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idPengurus" value="">
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <div class="form-file">
                            <input type="file" class="form-control" id="gambar" accept="image/*">
                        </div>
                        <img id="imgPreview" class="img-preview mt-2" alt="Preview">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalPengurus = document.getElementById('modalPengurus');
    const formPengurus = document.getElementById('formPengurus');
    const titlePengurus = document.getElementById('titlePengurus');
    const gambarInput = document.getElementById('gambar');
    const imgPreview = document.getElementById('imgPreview');

    // Preview gambar
    gambarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imgPreview.style.display = 'none';
        }
    });

    // Search functionality
    document.getElementById('searchPengurus').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tablePengurus tbody tr');
        rows.forEach(row => {
            const nama = row.dataset.nama.toLowerCase();
            const jabatan = row.dataset.jabatan.toLowerCase();
            if (nama.includes(searchTerm) || jabatan.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Add pengurus
    document.getElementById('btnAddPengurus').addEventListener('click', function() {
        titlePengurus.textContent = 'Tambah Pengurus';
        formPengurus.reset();
        imgPreview.style.display = 'none';
        document.getElementById('idPengurus').value = '';
    });

    // Edit pengurus
    document.querySelectorAll('.btn-edit-pengurus').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            titlePengurus.textContent = 'Edit Pengurus';
            document.getElementById('idPengurus').value = row.dataset.id;
            document.getElementById('nama').value = row.dataset.nama;
            document.getElementById('jabatan').value = row.dataset.jabatan;
            document.getElementById('deskripsi').value = row.dataset.deskripsi;
            // Preview gambar existing
            const imgSrc = row.querySelector('img') ? row.querySelector('img').src : '';
            if (imgSrc && imgSrc !== '{{ asset("images/") }}') {
                imgPreview.src = imgSrc;
                imgPreview.style.display = 'block';
            } else {
                imgPreview.style.display = 'none';
            }
        });
    });

    // Submit form
    formPengurus.addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('idPengurus').value;
        const isAdd = !id;
        const action = isAdd ? 'Ditambahkan!' : 'Diupdate!';
        // Simulate submit (ganti dengan AJAX ke backend)
        alert(`Pengurus ${action}`);
        bootstrap.Modal.getInstance(modalPengurus).hide();
        location.reload(); // Reload untuk update tabel
    });

    // Delete pengurus
    document.querySelectorAll('.btn-delete-pengurus').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Yakin hapus pengurus ini?')) {
                const row = this.closest('tr');
                row.remove();
                alert('Pengurus dihapus!');
            }
        });
    });

    // Reset modal on close
    modalPengurus.addEventListener('hidden.bs.modal', function() {
        formPengurus.reset();
        imgPreview.style.display = 'none';
        document.getElementById('idPengurus').value = '';
        titlePengurus.textContent = 'Tambah Pengurus';
    });
});
</script>
@endsection
</body>
</html>
