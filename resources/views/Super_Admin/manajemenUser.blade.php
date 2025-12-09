<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f5f7fa; }
        .orders-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;background:white;padding:1.5rem 2rem;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.08);}
        .orders-header h3{color:#2a522a;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;}
        .orders-header h3 i { color: #198754; }
        .orders-header .search-input-group { flex-grow: 1; max-width: 500px; margin-left: 1rem; } /* Ubah di sini: tambah flex-grow:1 dan margin-left untuk panjang search box */
        .orders-header .search-input-group .form-control { padding: 0.5rem 1rem; font-size: 0.875rem; border-radius: 5px; }
        .orders-header .search-input-group .input-group-text { background: #f8f9fa; border-radius: 5px; border: 1px solid #dee2e6; }
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
            border: none; /* Ubah di sini: Hilangkan border pada td */
        }
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
        /* Role Badges with Bootstrap Subtle Colors */
        .badge-role-super-admin { background-color: var(--bs-primary-bg-subtle) !important; color: var(--bs-primary-text-emphasis) !important; }
        .badge-role-staff-purchasing { background-color: var(--bs-success-bg-subtle) !important; color: var(--bs-success-text-emphasis) !important; }
        .badge-role-staff-produk { background-color: var(--bs-info-bg-subtle) !important; color: var(--bs-info-text-emphasis) !important; }
        .badge-role-kurir { background-color: var(--bs-warning-bg-subtle) !important; color: var(--bs-warning-text-emphasis) !important; }
        .badge-role-user { background-color: var(--bs-secondary-bg-subtle) !important; color: var(--bs-secondary-text-emphasis) !important; }
        /* Aktif Badges */
        .badge-aktif-aktif { background-color: var(--bs-success-bg-subtle) !important; color: var(--bs-success-text-emphasis) !important; padding: 0.5em 0.75em; border-radius: 0.375rem; font-size: 0.75em; font-weight: 500; }
        .badge-aktif-tidak-aktif { background-color: var(--bs-danger-bg-subtle) !important; color: var(--bs-danger-text-emphasis) !important; padding: 0.5em 0.75em; border-radius: 0.375rem; font-size: 0.75em; font-weight: 500; }
    </style>
</head>
<body>
@extends('components.super_admin')
@section('content')
<div class="container py-5">
    <div class="orders-header">
        <h3><i class="bi bi-people"></i>Manajemen User</h3>
        <div class="search-input-group">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" id="searchUser" class="form-control" placeholder="Cari nama, email, atau telpon...">
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold">Data User</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="tableUser">
            <thead>
                <tr>
                    <th style="width: 60px">No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No Telpon</th>
                    <th>Role</th>
                    <th>Status Online</th>
                    <th style="width: 140px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users ?? [] as $index => $user)
                <tr data-id="{{ $user['id'] ?? $index }}" data-nama="{{ $user['nama_lengkap'] ?? '' }}" data-email="{{ $user['email'] ?? '' }}" data-telpon="{{ $user['no_telpon'] ?? '' }}" data-role="{{ $user['role'] ?? '' }}" data-aktif="{{ $user['aktif'] ?? 'Aktif' }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user['nama_lengkap'] ?? '' }}</td>
                    <td>{{ $user['email'] ?? '' }}</td>
                    <td>{{ $user['no_telpon'] ?? '' }}</td>
                    <td>
                        <span class="badge badge-role-{{ strtolower(str_replace(' ', '-', str_replace('/', '', $user['role'] ?? 'staff'))) }}">{{ $user['role'] ?? 'Staff' }}</span>
                    </td>
                    <td>
                        <span class="badge badge-aktif-{{ strtolower(str_replace(' ', '-', $user['aktif'] ?? 'aktif')) }}">
                            {{ $user['aktif'] ?? 'Aktif' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-edit-user" data-bs-toggle="modal" data-bs-target="#modalUser" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete-user" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{-- Modal Edit User --}}
<div class="modal fade" id="modalUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleUser">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formUser">
                <div class="modal-body">
                    <input type="hidden" id="idUser" value="">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="namaLengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telpon</label>
                        <input type="text" class="form-control" id="noTelpon" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" id="role" required>
                            <option value="">Pilih Role</option>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Staff Purchasing">Staff Purchasing</option>
                            <option value="Staff Produk">Staff Produk</option>
                            <option value="Kurir">Kurir</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Kosongkan jika tidak diubah">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="aktif" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    document.getElementById('searchUser').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tableUser tbody tr');
        let index = 1;
        rows.forEach(row => {
            const nama = row.dataset.nama.toLowerCase();
            const email = row.dataset.email.toLowerCase();
            const telpon = row.dataset.telpon.toLowerCase();
            if (nama.includes(searchTerm) || email.includes(searchTerm) || telpon.includes(searchTerm)) {
                row.style.display = '';
                row.querySelector('td:first-child').textContent = index++;
            } else {
                row.style.display = 'none';
            }
        });
    });
    // Edit user
    document.querySelectorAll('.btn-edit-user').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            document.getElementById('idUser').value = row.dataset.id;
            document.getElementById('namaLengkap').value = row.dataset.nama;
            document.getElementById('email').value = row.dataset.email;
            document.getElementById('noTelpon').value = row.dataset.telpon;
            document.getElementById('role').value = row.dataset.role;
            document.getElementById('aktif').value = row.dataset.aktif;
        });
    });
    // Submit form (edit only)
    document.getElementById('formUser').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('idUser').value;
        // Simulate submit
        alert('User diupdate!');
        bootstrap.Modal.getInstance(document.getElementById('modalUser')).hide();
        this.reset();
        document.getElementById('idUser').value = '';
    });
    // Delete user
    document.querySelectorAll('.btn-delete-user').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Yakin hapus user ini?')) {
                const row = this.closest('tr');
                row.remove();
                alert('User dihapus!');
            }
        });
    });
    // Reset modal on close
    document.getElementById('modalUser').addEventListener('hidden.bs.modal', function() {
        document.getElementById('formUser').reset();
        document.getElementById('idUser').value = '';
    });
});
</script>
@endsection
</body>
</html>
