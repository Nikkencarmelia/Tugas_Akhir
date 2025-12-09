<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kelola Ongkir & Daerah</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                background: #f5f7fa;
                font-family: 'Inter', sans-serif;
            }
            .orders-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;background:white;padding:1.5rem 2rem;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.08);}
            .orders-header h3{color:#2a522a;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;}
            .orders-header h3 i { color: #198754; }
            .order-card{background:white;border-radius:16px;padding:1.5rem;margin-bottom:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.06);transition:all .3s ease;border:1px solid #f1f3f4;}
            .order-card:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(0,0,0,0.1);}
            .order-card.hidden { display: none !important; }
            .order-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid #e9ecef;}
            .order-meta{display:flex;flex-direction:column;font-size:14px;color:#6c757d;}
            .order-meta .alamat{background:#e8f5e9;color:#1b5e20;padding:3px 8px;border-radius:6px;display:inline-block;margin-top:4px;font-size:13px;}
            .order-meta .metode{background:#e3f2fd;color:#0d47a1;padding:3px 8px;border-radius:6px;margin-top:4px;font-size:13px;}
            .order-number{font-weight:600;color:#495057;}
            .order-product{display:flex;align-items:center;gap:1rem;margin-bottom:1rem;padding:1rem;background:#f8f9fa;border-radius:12px;}
            .order-product img{width:80px;height:80px;object-fit:cover;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
            .order-product-details { flex-grow: 1; }
            .produk-lain { font-size: 12px; color: #6c757d; font-style: italic; }

            /* Badge Supplier Styles */
            .img-container { position: relative; width: 80px; height: 80px; }
            .img-container img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #f1f3f4; }
            .badge-supplier {
            position: absolute; top: 5px; right: 5px;
            font-size: .7rem; font-weight: 600;
            padding: .3rem .55rem; border-radius: .4rem; line-height: 1;
            }

            .order-actions{display:flex;gap:.5rem;margin-top:1rem;flex-wrap:wrap;}
            .btn-order{padding:6px 14px;border-radius:20px;font-size:13px;font-weight:500;transition:all .3s ease;}
            .btn-primary-order{background:#198754;color:white;border:1px solid #198754;}
            .btn-primary-order:hover{background:#146c43;border-color:#146c43;}
            .btn-secondary-order{background:#f8f9fa;color:#495057;border:1px solid #dee2e6;}
            .btn-secondary-order:hover{background:#e9ecef;color:#212529;}
            .select-controls{display:flex;justify-content:flex-start;align-items:center;margin-bottom:1rem;gap:1rem;flex-wrap:nowrap;overflow:hidden;}
            .order-status{display:flex;align-items:center;gap:.5rem;padding:6px 12px;border-radius:20px;font-size:13px;font-weight:500;margin-bottom:1rem;}
            .status-menunggu-cari-kurir{background:#fff3cd;color:#856404;border:1px solid #ffeaa7;}
            @media(max-width:768px){.orders-header{flex-direction:column;gap:1rem;text-align:center}.order-header{flex-direction:column;gap:.5rem;align-items:flex-start}.order-product{flex-direction:column;text-align:center}.order-actions{justify-content:center}.select-controls{flex-wrap:wrap;gap:0.5rem;justify-content:flex-start;}.select-controls .input-group{max-width:200px !important;}.select-controls .form-select{max-width:140px !important;}}

            /* Modern Modal Styles */
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
                border-color: #f1f3f4;
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
            .modal-footer {
                background: #f8f9fa;
                border-top: 1px solid #e9ecef;
                padding: 1.5rem 2rem;
                border-radius: 0 0 20px 20px;
            }

            /* Custom Tab Buttons Style */
            .orders-tabs{display:flex;gap:1rem;align-items:center;flex-wrap:wrap;}
            .orders-tab{padding:8px 16px;border-radius:20px;background:#ffffff;text-decoration:none;color:#6c757d;font-weight:500;border:1px solid #e9ecef;transition:all .3s ease;}
            .orders-tab.active{background:#198754;color:white;border-color:#198754;}
            .orders-tab.active .badge { color: white !important; }
            .orders-tab:hover{background:#e9ecef;color:#495057;}
            .tab-panel{display:none;}
            .tab-panel.active{display:block;}

            .table th, .table td { vertical-align: middle; }
            .badge { font-size: 0.75em; }

            .search-controls {
                display: flex;
                gap: 1rem;
                align-items: center;
                margin-bottom: 1rem;
            }
            .search-controls .input-group {
                flex-grow: 1;
            }
        </style>
    </head>

    <body>
       @extends('Components.staff_purchasing')

@section('content')

<div class="container py-5">

    <div class="orders-header">
        <h3><i class="bi bi-geo-alt"></i>Kelola Ongkir & Daerah</h3>
        <small class="text-muted">Kelola data wilayah dan ongkos kirim</small>
    </div>

    <!-- Custom Tab Buttons -->
    <div class="orders-tabs mb-4">
        <a href="#" class="orders-tab active" data-tab="kecamatan">Kecamatan</a>
        <a href="#" class="orders-tab" data-tab="kelurahan">Kelurahan</a>
        <a href="#" class="orders-tab" data-tab="kodepos">Kode Pos</a>
    </div>

    <div class="tab-content">

        <!-- ============================
             TAB 1 — KECAMATAN
        =============================-->
        <div class="tab-panel active" id="kecamatan">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold">Data Kecamatan</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalKecamatan">
                    <i class="bi bi-plus-circle"></i> Tambah Kecamatan
                </button>
            </div>

            <div class="search-controls mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchKecamatan" class="form-control" placeholder="Cari kecamatan...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tableKecamatan">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px">No</th>
                            <th>Nama Kecamatan</th>
                            <th>Ongkir Minimal (Rp)</th>
                            <th>Jumlah Kelurahan</th>
                            <th style="width: 140px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="1">
                            <td>1</td>
                            <td>Melak</td>
                            <td>10.000</td>
                            <td><span class="badge bg-success" data-count="5">5</span></td>
                            <td>
                                <button class="btn btn-warning btn-sm btn-edit-kec" data-bs-toggle="modal" data-bs-target="#modalKecamatan" data-id="1" data-nama="Melak" data-ongkir="10000">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-sm btn-delete-kec" data-id="1">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Tambah row dinamis via JS jika perlu -->
                    </tbody>
                </table>
            </div>

        </div>


        <!-- ============================
             TAB 2 — KELURAHAN
        =============================-->
        <div class="tab-panel" id="kelurahan">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold">Data Kelurahan</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalKelurahan">
                    <i class="bi bi-plus-circle"></i> Tambah Kelurahan
                </button>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <label class="form-label">Kecamatan</label>
                    <select class="form-select" id="filterKecamatanKelurahan">
                        <option value="">Semua Kecamatan</option>
                        <option value="1">Melak</option>
                        <option value="2">Barong Tongkok</option>
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Cari Kelurahan</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchKelurahan" class="form-control" placeholder="Cari kelurahan...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tableKelurahan">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px">No</th>
                            <th>Nama Kelurahan</th>
                            <th>Kecamatan</th>
                            <th>Jumlah Kode Pos</th>
                            <th style="width: 140px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="1" data-kec="1">
                            <td>1</td>
                            <td>Kelurahan Simpang Raya</td>
                            <td>Melak</td>
                            <td><span class="badge bg-info" data-count="2">2</span></td>
                            <td>
                                <button class="btn btn-warning btn-sm btn-edit-kel" data-bs-toggle="modal" data-bs-target="#modalKelurahan" data-id="1" data-nama="Kelurahan Simpang Raya" data-kec="1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-sm btn-delete-kel" data-id="1">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Tambah row dinamis -->
                    </tbody>
                </table>
            </div>

        </div>


        <!-- ============================
             TAB 3 — KODE POS
        =============================-->
        <div class="tab-panel" id="kodepos">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold">Data Kode Pos</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalKodePos">
                    <i class="bi bi-plus-circle"></i> Tambah Kode Pos
                </button>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 mb-2">
                    <label class="form-label">Kecamatan</label>
                    <select class="form-select" id="filterKecamatanKodePos">
                        <option value="">Semua Kecamatan</option>
                        <option value="1">Melak</option>
                        <option value="2">Barong Tongkok</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label">Kelurahan</label>
                    <select class="form-select" id="filterKelurahanKodePos" disabled>
                        <option value="">Semua Kelurahan</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label">Cari Kode Pos</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchKodePos" class="form-control" placeholder="Cari kode pos...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tableKodePos">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px">No</th>
                            <th>Kode Pos</th>
                            <th>Kelurahan</th>
                            <th>Kecamatan</th>
                            <th style="width: 140px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="1" data-kel="1" data-kec="1">
                            <td>1</td>
                            <td>75765</td>
                            <td>Simpang Raya</td>
                            <td>Melak</td>
                            <td>
                                <button class="btn btn-warning btn-sm btn-edit-kp" data-bs-toggle="modal" data-bs-target="#modalKodePos" data-id="1" data-kode="75765" data-kel="1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-sm btn-delete-kp" data-id="1">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Tambah row dinamis -->
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>

{{-- Modal Kecamatan --}}
<div class="modal fade" id="modalKecamatan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleKecamatan">Tambah Kecamatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formKecamatan">
                <div class="modal-body">
                    <input type="hidden" id="idKecamatan" value="">
                    <div class="mb-3">
                        <label class="form-label">Nama Kecamatan</label>
                        <input type="text" class="form-control" id="namaKecamatan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ongkir Minimal (Rp)</label>
                        <input type="number" class="form-control" id="ongkirKecamatan" min="0" step="1000" required>
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

{{-- Modal Kelurahan --}}
<div class="modal fade" id="modalKelurahan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleKelurahan">Tambah Kelurahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formKelurahan">
                <div class="modal-body">
                    <input type="hidden" id="idKelurahan" value="">
                    <div class="mb-3">
                        <label class="form-label">Kecamatan</label>
                        <select class="form-select" id="kecamatanKelurahan" required>
                            <option value="">Pilih Kecamatan</option>
                            <option value="1">Melak</option>
                            <option value="2">Barong Tongkok</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kelurahan</label>
                        <input type="text" class="form-control" id="namaKelurahan" required>
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

{{-- Modal Kode Pos --}}
<div class="modal fade" id="modalKodePos" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleKodePos">Tambah Kode Pos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formKodePos">
                <div class="modal-body">
                    <input type="hidden" id="idKodePos" value="">
                    <div class="mb-3">
                        <label class="form-label">Kecamatan</label>
                        <select class="form-select kecamatan-kp" id="kecamatanKodePos" required onchange="loadKelurahanKodePos()">
                            <option value="">Pilih Kecamatan</option>
                            <option value="1">Melak</option>
                            <option value="2">Barong Tongkok</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelurahan</label>
                        <select class="form-select kelurahan-kp" id="kelurahanKodePos" required disabled>
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" class="form-control" id="kodePos" required pattern="\d{5}">
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

@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Data simulasi (ganti dengan AJAX ke backend Laravel) - tambah ongkir
    const kecamatans = [
        { id: 1, nama: 'Melak', ongkir: 10000, kelurahan_count: 5 },
        { id: 2, nama: 'Barong Tongkok', ongkir: 15000, kelurahan_count: 3 }
    ];
    const kelurahans = [
        { id: 1, nama: 'Kelurahan Simpang Raya', kec_id: 1, kodepos_count: 2 },
        { id: 2, nama: 'Kelurahan Lain', kec_id: 1, kodepos_count: 3 },
        { id: 3, nama: 'Kelurahan Barong', kec_id: 2, kodepos_count: 1 }
    ];
    const kodeposs = [
        { id: 1, kode: '75765', kel_id: 1 },
        { id: 2, kode: '75766', kel_id: 1 },
        { id: 3, kode: '75767', kel_id: 2 }
    ];

    // Custom Tab Switching
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.orders-tab');
        const panels = document.querySelectorAll('.tab-panel');
        tabs.forEach(tab => {
            tab.addEventListener('click', e => {
                e.preventDefault();
                tabs.forEach(t => t.classList.remove('active'));
                panels.forEach(p => p.classList.remove('active'));
                tab.classList.add('active');
                document.getElementById(tab.dataset.tab).classList.add('active');
            });
        });
    });

    // Fungsi untuk load kelurahan berdasarkan kecamatan di modal Kode Pos
    function loadKelurahanKodePos() {
        const kecId = document.getElementById('kecamatanKodePos').value;
        const kelSelect = document.getElementById('kelurahanKodePos');
        kelSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
        kelSelect.disabled = true;

        if (kecId) {
            const filteredKel = kelurahans.filter(k => k.kec_id == kecId);
            filteredKel.forEach(kel => {
                const option = document.createElement('option');
                option.value = kel.id;
                option.textContent = kel.nama;
                kelSelect.appendChild(option);
            });
            kelSelect.disabled = false;
        }
    }

    // Search functionality for Kecamatan
    document.getElementById('searchKecamatan').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tableKecamatan tbody tr');
        let index = 1;
        rows.forEach(row => {
            const nama = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (nama.includes(searchTerm)) {
                row.style.display = '';
                row.querySelector('td:first-child').textContent = index++;
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Filter functionality for Kelurahan
    function filterKelurahan() {
        const kecId = document.getElementById('filterKecamatanKelurahan').value;
        const search = document.getElementById('searchKelurahan').value.toLowerCase();
        const rows = document.querySelectorAll('#tableKelurahan tbody tr');
        let index = 1;
        rows.forEach(row => {
            const rowKec = row.dataset.kec;
            const rowNama = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const kecMatch = !kecId || rowKec == kecId;
            const searchMatch = !search || rowNama.includes(search);
            if (kecMatch && searchMatch) {
                row.style.display = '';
                row.querySelector('td:first-child').textContent = index++;
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.getElementById('filterKecamatanKelurahan').addEventListener('change', filterKelurahan);
    document.getElementById('searchKelurahan').addEventListener('input', filterKelurahan);

    // Filter functionality for Kode Pos
    function filterKodePos() {
        const kecId = document.getElementById('filterKecamatanKodePos').value;
        const kelId = document.getElementById('filterKelurahanKodePos').value;
        const search = document.getElementById('searchKodePos').value.toLowerCase();
        const rows = document.querySelectorAll('#tableKodePos tbody tr');
        let index = 1;
        rows.forEach(row => {
            const rowKec = row.dataset.kec;
            const rowKel = row.dataset.kel;
            const rowKode = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const kecMatch = !kecId || rowKec == kecId;
            const kelMatch = !kelId || rowKel == kelId;
            const searchMatch = !search || rowKode.includes(search);
            if (kecMatch && kelMatch && searchMatch) {
                row.style.display = '';
                row.querySelector('td:first-child').textContent = index++;
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Load kelurahan options for filter on kec change
    document.getElementById('filterKecamatanKodePos').addEventListener('change', function() {
        const kecId = this.value;
        const kelSelect = document.getElementById('filterKelurahanKodePos');
        kelSelect.innerHTML = '<option value="">Semua Kelurahan</option>';
        kelSelect.disabled = true;
        if (kecId) {
            const filteredKel = kelurahans.filter(k => k.kec_id == kecId);
            filteredKel.forEach(kel => {
                const option = document.createElement('option');
                option.value = kel.id;
                option.textContent = kel.nama;
                kelSelect.appendChild(option);
            });
            kelSelect.disabled = false;
        }
        filterKodePos();
    });

    document.getElementById('filterKelurahanKodePos').addEventListener('change', filterKodePos);
    document.getElementById('searchKodePos').addEventListener('input', filterKodePos);

    // Event untuk edit Kecamatan - tambah ongkir
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-edit-kec')) {
            const btn = e.target.closest('.btn-edit-kec');
            const id = btn.dataset.id;
            const nama = btn.dataset.nama;
            const ongkir = btn.dataset.ongkir;
            document.getElementById('idKecamatan').value = id;
            document.getElementById('namaKecamatan').value = nama;
            document.getElementById('ongkirKecamatan').value = ongkir;
            document.getElementById('titleKecamatan').textContent = 'Edit Kecamatan';
        }
    });

    // Submit Form Kecamatan - tambah ongkir
    document.getElementById('formKecamatan').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('idKecamatan').value;
        const nama = document.getElementById('namaKecamatan').value;
        const ongkir = document.getElementById('ongkirKecamatan').value;
        // Di sini kirim ke backend via fetch('/kecamatan', {method: 'POST', body: JSON.stringify({id, nama, ongkir})})
        // Lalu reload table atau tambah row
        alert(id ? 'Diupdate!' : 'Ditambahkan!');
        bootstrap.Modal.getInstance(document.getElementById('modalKecamatan')).hide();
        // Reset form
        this.reset();
        document.getElementById('idKecamatan').value = '';
        document.getElementById('titleKecamatan').textContent = 'Tambah Kecamatan';
    });

    // Event untuk edit Kelurahan
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-edit-kel')) {
            const btn = e.target.closest('.btn-edit-kel');
            const id = btn.dataset.id;
            const nama = btn.dataset.nama;
            const kec = btn.dataset.kec;
            document.getElementById('idKelurahan').value = id;
            document.getElementById('namaKelurahan').value = nama;
            document.getElementById('kecamatanKelurahan').value = kec;
            document.getElementById('titleKelurahan').textContent = 'Edit Kelurahan';
        }
    });

    // Submit Form Kelurahan
    document.getElementById('formKelurahan').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('idKelurahan').value;
        const nama = document.getElementById('namaKelurahan').value;
        const kecId = document.getElementById('kecamatanKelurahan').value;
        // Kirim ke backend
        alert(id ? 'Diupdate!' : 'Ditambahkan!');
        bootstrap.Modal.getInstance(document.getElementById('modalKelurahan')).hide();
        this.reset();
        document.getElementById('idKelurahan').value = '';
        document.getElementById('titleKelurahan').textContent = 'Tambah Kelurahan';
    });

    // Event untuk edit Kode Pos
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-edit-kp')) {
            const btn = e.target.closest('.btn-edit-kp');
            const id = btn.dataset.id;
            const kode = btn.dataset.kode;
            const kel = btn.dataset.kel;
            document.getElementById('idKodePos').value = id;
            document.getElementById('kodePos').value = kode;
            document.getElementById('kelurahanKodePos').value = kel;
            // Load kecamatan berdasarkan kelurahan
            const selectedKel = kelurahans.find(k => k.id == kel);
            if (selectedKel) {
                document.getElementById('kecamatanKodePos').value = selectedKel.kec_id;
                loadKelurahanKodePos();
            }
            document.getElementById('titleKodePos').textContent = 'Edit Kode Pos';
        }
    });

    // Submit Form Kode Pos
    document.getElementById('formKodePos').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('idKodePos').value;
        const kode = document.getElementById('kodePos').value;
        const kelId = document.getElementById('kelurahanKodePos').value;
        // Kirim ke backend
        alert(id ? 'Diupdate!' : 'Ditambahkan!');
        bootstrap.Modal.getInstance(document.getElementById('modalKodePos')).hide();
        this.reset();
        document.getElementById('idKodePos').value = '';
        document.getElementById('kelurahanKodePos').innerHTML = '<option value="">Pilih Kelurahan</option>';
        document.getElementById('kelurahanKodePos').disabled = true;
        document.getElementById('titleKodePos').textContent = 'Tambah Kode Pos';
    });

    // Event delete (konfirmasi)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete-kec') || e.target.closest('.btn-delete-kel') || e.target.closest('.btn-delete-kp')) {
            if (confirm('Yakin hapus?')) {
                // Kirim delete ke backend via fetch
                alert('Dihapus!');
                e.target.closest('tr').remove();
            }
        }
    });

    // Inisialisasi filter awal
</script>
    </body>
</html>
