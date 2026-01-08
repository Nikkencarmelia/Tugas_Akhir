<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kurir - Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f5f7fa; }
        .orders-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;background:white;padding:1.5rem 2rem;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.08);}
        .orders-header h3{color:#2a522a;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;}
        .orders-header h3 i { color: #198754; }
        .orders-header .search-input-group { flex-grow: 1; max-width: 500px; margin-left: 1rem; }
        .orders-header .search-input-group .form-control { padding: 0.5rem 1rem; font-size: 0.875rem; border-radius: 0; }
        .orders-header .search-input-group .input-group-text { background: #f8f9fa; border-radius: 0; border: 1px solid #dee2e6; }
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

        .badge-role-super-admin { background-color: var(--bs-primary-bg-subtle) !important; color: var(--bs-primary-text-emphasis) !important; }
        .badge-role-staff-purchasing { background-color: var(--bs-success-bg-subtle) !important; color: var(--bs-success-text-emphasis) !important; }
        .badge-role-staff-produk { background-color: var(--bs-info-bg-subtle) !important; color: var(--bs-info-text-emphasis) !important; }
        .badge-role-kurir { background-color: var(--bs-warning-bg-subtle) !important; color: var(--bs-warning-text-emphasis) !important; }
        .badge-role-user { background-color: var(--bs-secondary-bg-subtle) !important; color: var(--bs-secondary-text-emphasis) !important; }

        .badge-online-aktif { background-color: var(--bs-success-bg-subtle) !important; color: var(--bs-success-text-emphasis) !important; padding: 0.5em 0.75em; border-radius: 0.375rem; font-size: 0.75em; font-weight: 500; }
        .badge-online-tidak-aktif { background-color: var(--bs-danger-bg-subtle) !important; color: var(--bs-danger-text-emphasis) !important; padding: 0.5em 0.75em; border-radius: 0.375rem; font-size: 0.75em; font-weight: 500; }

.badge-antar-siap { background-color: #198754 !important; color: white !important; padding: 0.5em 0.85em; border-radius: 50px; font-size: 0.75em; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-antar-sedang-antar { background-color: #f59e0b !important; color: white !important; padding: 0.5em 0.85em; border-radius: 50px; font-size: 0.75em; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-antar-- { background-color: #6c757d !important; color: white !important; padding: 0.5em 0.85em; border-radius: 50px; font-size: 0.75em; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    </style>
</head>
<body>
@extends('Components.super_admin')
@section('content')
<div class="container py-5">
    <div class="orders-header">
        <h3><i class="bi bi-truck"></i>Manajemen Kurir</h3>
        <div class="search-input-group">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" id="searchKurir" class="form-control" placeholder="Cari nama, email, atau telpon...">
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold">Data Kurir</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="tableKurir">
            <thead>
                <tr>
                    <th style="width: 60px">No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No Telpon</th>
                    <th>Role</th>
                    <th>Kendaraan</th>
                    <th>Status Online</th>
                    <th>Status Antar</th>
                    <th style="width: 100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kurir ?? [] as $index => $kurir_item)
                <tr data-id="{{ $kurir_item->id }}"
                    data-nama="{{ $kurir_item->nama_lengkap ?? '' }}"
                    data-email="{{ $kurir_item->email ?? '' }}"
                    data-telpon="{{ $kurir_item->no_telepon ?? '' }}"
                    data-role="{{ $kurir_item->role ?? 'Kurir' }}"
                    data-kendaraan="{{ $kurir_item->kendaraan ?? '' }}"
                    data-statusonline="{{ $kurir_item->status_online ?? 'Aktif' }}"
                    data-statusantar="{{ $kurir_item->status_antar ?? 'Siap' }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kurir_item->nama_lengkap ?? '' }}</td>
                    <td>{{ $kurir_item->email ?? '' }}</td>
                    <td>{{ $kurir_item->no_telepon ?? '-' }}</td>
                    <td>
                        <span class="badge badge-role-{{ strtolower(str_replace(' ', '-', str_replace('/', '', $kurir_item->role ?? 'kurir'))) }}">{{ $kurir_item->role ?? 'Kurir' }}</span>
                    </td>
                    <td>{{ $kurir_item->kendaraan ?? '-' }}</td>
                    <td>
                        <span class="badge badge-online-{{ strtolower(str_replace([' ', '_'], '-', $kurir_item->status_online ?? 'aktif')) }}">
                            {{ $kurir_item->status_online ?? 'Aktif' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-antar-{{ strtolower(str_replace([' ', '_'], '-', $kurir_item->status_antar ?? 'siap')) }}">
                            {{ $kurir_item->status_antar == 'sedang_antar' ? 'Sedang Antar' : ($kurir_item->status_antar == 'siap' ? 'Siap' : ($kurir_item->status_antar ?? 'Siap')) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-edit-kurir" data-bs-toggle="modal" data-bs-target="#modalKurir" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">Belum ada data kurir.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalKurir" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleKurir">Edit Kurir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formKurir">
                <div class="modal-body">
                    <input type="hidden" id="idKurir" value="">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="namaLengkap" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telpon</label>
                        <input type="text" class="form-control" id="noTelpon" disabled>
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
                        <label class="form-label">Kendaraan</label>
                        <input type="text" class="form-control" id="kendaraan" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Kosongkan jika tidak diubah" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Online</label>
                        <select class="form-select" id="statusOnline" disabled>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Antar</label>
                        <select class="form-select" id="statusAntar" disabled>
                            <option value="Siap">Siap</option>
                            <option value="Sedang Antar">Sedang Antar</option>
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

    document.getElementById('searchKurir').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tableKurir tbody tr');
        let index = 1;

        rows.forEach(row => {

            if (!row.dataset.nama) return;

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

let noResultsRow = document.getElementById('noResultsRow');
        let visibleRows = Array.from(rows).filter(r => r.style.display !== 'none' && r.dataset.nama);

        if (visibleRows.length === 0 && searchTerm !== '') {
            if (!noResultsRow) {
                noResultsRow = document.createElement('tr');
                noResultsRow.id = 'noResultsRow';
                noResultsRow.innerHTML = `<td colspan="9" class="text-center text-muted">Tidak ada data kurir yang cocok dengan pencarian "${searchTerm}".</td>`;
                document.querySelector('#tableKurir tbody').appendChild(noResultsRow);
            } else {
                noResultsRow.style.display = '';
                noResultsRow.innerHTML = `<td colspan="9" class="text-center text-muted">Tidak ada data kurir yang cocok dengan pencarian "${searchTerm}".</td>`;
            }
        } else if (noResultsRow) {
            noResultsRow.style.display = 'none';
        }
    });

document.querySelectorAll('.btn-edit-kurir').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            document.getElementById('idKurir').value = row.dataset.id;
            document.getElementById('namaLengkap').value = row.dataset.nama;
            document.getElementById('email').value = row.dataset.email;
            document.getElementById('noTelpon').value = row.dataset.telpon;
            document.getElementById('role').value = row.dataset.role;
            document.getElementById('kendaraan').value = row.dataset.kendaraan;

            document.getElementById('statusOnline').value = row.dataset.statusonline === 'Aktif' ? 'Aktif' : 'Tidak Aktif';
            document.getElementById('statusAntar').value = row.dataset.statusantar === 'Siap' ? 'Siap' : 'Sedang Antar';
        });
    });

document.getElementById('formKurir').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('idKurir').value;
        const formData = {
            role: document.getElementById('role').value,

};

fetch(`/super_admin/manajemen_kurir/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) {

                    row.dataset.role = formData.role;

                    const roleClass = formData.role.toLowerCase().replace(/ /g, '-').replace('_','-');
                    row.querySelector('td:nth-child(5) span').className = `badge badge-role-${roleClass}`;
                    row.querySelector('td:nth-child(5) span').textContent = formData.role;
                }
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalKurir'));
                modal.hide();
                window.location.reload();
            } else {
                alert('Gagal update: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan.');
        });
    });

document.getElementById('modalKurir').addEventListener('hidden.bs.modal', function() {
        document.getElementById('formKurir').reset();
        document.getElementById('idKurir').value = '';
    });
});
</script>
@endsection
</body>
</html>
