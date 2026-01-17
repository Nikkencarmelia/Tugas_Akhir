<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Pengguna - Super Admin</title>
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
        .modal-body .form-control:disabled, .modal-body .form-select:disabled {
            background-color: #f8f9fa;
            opacity: 0.65;
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

        .badge-role-super_admin { background-color: var(--bs-primary-bg-subtle) !important; color: var(--bs-primary-text-emphasis) !important; }
        .badge-role-staff_purchasing { background-color: var(--bs-success-bg-subtle) !important; color: var(--bs-success-text-emphasis) !important; }
        .badge-role-staff_produk { background-color: var(--bs-info-bg-subtle) !important; color: var(--bs-info-text-emphasis) !important; }
        .badge-role-kurir { background-color: var(--bs-warning-bg-subtle) !important; color: var(--bs-warning-text-emphasis) !important; }
        .badge-role-user { background-color: var(--bs-secondary-bg-subtle) !important; color: var(--bs-secondary-text-emphasis) !important; }

        .badge-aktif-aktif { background-color: var(--bs-success-bg-subtle) !important; color: var(--bs-success-text-emphasis) !important; padding: 0.5em 0.75em; border-radius: 0.375rem; font-size: 0.75em; font-weight: 500; }
        .badge-aktif-tidak_aktif { background-color: var(--bs-danger-bg-subtle) !important; color: var(--bs-danger-text-emphasis) !important; padding: 0.5em 0.75em; border-radius: 0.375rem; font-size: 0.75em; font-weight: 500; }
    </style>
</head>
<body>
@extends('components.super_admin')
@section('content')
<div class="container py-5">
    <div class="orders-header">
        <h3><i class="bi bi-people"></i>Manajemen Pengguna</h3>
        <div class="search-input-group">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" id="searchUser" class="form-control" placeholder="Cari nama, email, atau telpon...">
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold">Data Pengguna</h5>
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
                    <th style="width: 100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr data-id="{{ $user['id'] }}" data-nama="{{ $user['nama_lengkap'] }}" data-email="{{ $user['email'] }}" data-telpon="{{ $user['no_telepon'] }}" data-role="{{ $user['role'] }}" data-aktif="{{ ($user['status_online'] == 'aktif') ? 'Aktif' : 'Tidak Aktif' }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user['nama_lengkap'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['no_telepon'] }}</td>
                    <td>
                        <span class="badge badge-role-{{ strtolower(str_replace(' ', '_', $user['role'])) }}">{{ $user['role'] }}</span>
                    </td>
                    <td>
                        <span class="badge badge-aktif-{{ strtolower($user['status_online']) }}">
                            {{ ($user['status_online'] == 'aktif') ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-edit-user" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada data pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="titleUser">Edit Pengguna</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formUser">
                <div class="modal-body">
                    <input type="hidden" id="idUser" value="">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="namaLengkap" readonly disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" readonly disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telpon</label>
                        <input type="text" class="form-control" id="noTelpon" readonly disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" id="role" required>
                            <option value="">Pilih Role</option>
                            <option value="user">User</option>
                            <option value="kurir">Kurir</option>
                            <option value="staff_produk">Staff Produk</option>
                            <option value="staff_purchasing">Staff Purchasing</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Online</label>
                        <select class="form-select" id="status_online" disabled>
                            <option value="aktif">Aktif</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    function showToast(message, type = 'success') {
        const toastContainer = document.createElement('div');
        toastContainer.className = `toast align-items-center text-white bg-${type} border-0 position-fixed top-0 end-0 m-3`;
        toastContainer.style.zIndex = 2000;
        toastContainer.innerHTML = `
        <div class="d-flex">
            <div class="toast-body fw-semibold">
                <i class="fa-solid fa-circle-${type === 'success' ? 'check' : 'xmark'} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
        `;
        document.body.appendChild(toastContainer);
        const toast = new bootstrap.Toast(toastContainer, { delay: 3000 });
        toast.show();
        toastContainer.addEventListener('hidden.bs.toast', () => toastContainer.remove());
    }

    document.getElementById('searchUser').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('#tableUser tbody tr');
        let index = 1;
        let hasVisible = false;

        rows.forEach(row => {
            if (row.classList.contains('no-results-row')) return;

            const nama = (row.dataset.nama || '').toLowerCase();
            const email = (row.dataset.email || '').toLowerCase();
            const telpon = (row.dataset.telpon || '').toLowerCase();
            const role = (row.dataset.role || '').toLowerCase();
            const status = (row.dataset.aktif || '').toLowerCase();

            const matches = nama.includes(searchTerm) || 
                          email.includes(searchTerm) || 
                          telpon.includes(searchTerm) || 
                          role.includes(searchTerm) || 
                          status.includes(searchTerm);

            if (matches) {
                row.style.display = '';
                row.querySelector('td:first-child').textContent = index++;
                hasVisible = true;
                highlightText(row, searchTerm);
            } else {
                row.style.display = 'none';
            }
        });

        const table = document.getElementById('tableUser');
        let noResultsRow = table.querySelector('.no-results-row');
        if (!hasVisible && searchTerm !== '') {
            if (!noResultsRow) {
                noResultsRow = document.createElement('tr');
                noResultsRow.className = 'no-results-row';
                noResultsRow.innerHTML = `<td colspan="7" class="text-center py-4 text-muted">Tidak ditemukan pengguna yang cocok dengan "${this.value}"</td>`;
                table.querySelector('tbody').appendChild(noResultsRow);
            } else {
                noResultsRow.style.display = '';
                noResultsRow.querySelector('td').innerText = `Tidak ditemukan pengguna yang cocok dengan "${this.value}"`;
            }
        } else if (noResultsRow) {
            noResultsRow.style.display = 'none';
        }
    });

    function highlightText(row, term) {
        const columns = [2, 3, 4, 5, 6]; // Nama, Email, Telpon, Role, Status
        columns.forEach(colIndex => {
            const el = row.querySelector(`td:nth-child(${colIndex})`);
            if (!el) return;
            
            // For columns with badges (Role and Status), target the span inside
            const target = el.querySelector('span.badge') || el;
            const originalText = target.textContent;
            
            if (!term) {
                target.innerHTML = originalText;
                return;
            }
            
            const regex = new RegExp(`(${term})`, 'gi');
            target.innerHTML = originalText.replace(regex, '<mark style="background-color: yellow; padding: 0.1em; border-radius: 2px;">$1</mark>');
        });
    }

document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-edit-user')) {
            const btn = e.target.closest('.btn-edit-user');
            const row = btn.closest('tr');
            document.getElementById('idUser').value = row.dataset.id;
            document.getElementById('namaLengkap').value = row.dataset.nama;
            document.getElementById('email').value = row.dataset.email;
            document.getElementById('noTelpon').value = row.dataset.telpon;
            document.getElementById('role').value = row.dataset.role;
            document.getElementById('status_online').value = row.dataset.aktif === 'Aktif' ? 'aktif' : 'tidak_aktif';

setTimeout(() => {
                const modalEl = document.getElementById('modalUser');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();

document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = '';
            }, 50);
        }
    });

document.getElementById('formUser').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('idUser').value;
        const formData = {
            role: document.getElementById('role').value
        };

        console.log('Mengirim ke URL: /super_admin/manajemen_pengguna/' + id);
        console.log('Data:', formData);

        fetch(`/super_admin/manajemen_pengguna/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('HTTP error! Status: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {

                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    row.dataset.role = formData.role;
                    const roleBadge = row.querySelector('td:nth-child(5) span');
                    if (roleBadge) {
                        roleBadge.textContent = formData.role.replace(/_/g, ' ');
                        roleBadge.className = `badge badge-role-${formData.role}`;
                    }
                }

const modalEl = document.getElementById('modalUser');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }

setTimeout(() => {
                    document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.paddingRight = '';
                }, 500);

setTimeout(() => {
                    showToast(data.message || 'Role berhasil diubah!', 'success');
                }, 550);
            } else {
                showToast('Gagal update: ' + (data.message || 'Server error'), 'danger');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            showToast('Terjadi kesalahan saat mengirim data. Cek console (F12) untuk detail.', 'danger');
        });
    });

const modalUser = document.getElementById('modalUser');
    modalUser.addEventListener('hidden.bs.modal', function() {
        document.getElementById('formUser').reset();
        document.getElementById('idUser').value = '';

setTimeout(() => {
            document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = '';
        }, 100);
    });
});
</script>
@endsection
</body>
</html>
