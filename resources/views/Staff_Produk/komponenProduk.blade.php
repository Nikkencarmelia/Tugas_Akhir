<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kelola Kategori, Satuan & Supplier</title>
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
            /* Modern Modal Styles (Synced with Profil) */
            .modal-content {
                border-radius: 12px;
                border: none;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
            .modal-header {
                background: #198754;
                color: white;
                border-radius: 12px 12px 0 0 !important;
                padding: 1rem 1.5rem;
            }
            .modal-header .btn-close {
                filter: invert(1);
            }
            .modal-title {
                font-weight: 600;
                font-size: 1.25rem;
            }
            .modal-body {
                padding: 1.5rem;
                background: #fff;
            }
            .modal-body .form-label {
                font-weight: 500;
                color: #2a522a;
                margin-bottom: 0.5rem;
            }
            .modal-body .form-control, .modal-body .form-select {
                border-radius: 8px;
                border: 1px solid #ced4da;
                padding: 10px 12px;
                transition: border-color 0.2s ease;
            }
            .modal-body .form-control:focus, .modal-body .form-select:focus {
                border-color: #198754;
                box-shadow: 0 0 0 0.2rem rgba(25,135,84,0.1);
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
            .table tbody tr:hover {
                background: #f8f9fa;
            }
            .table tbody td {
                padding: 1rem;
                border-color: #f1f3f4;
            }
            .btn-primary {
                background: #198754;
                border: none;
                border-radius: 20px;
                padding: 10px 24px;
                font-weight: 600;
            }
            .btn-primary:hover {
                background: #157347;
                transform: translateY(-1px);
            }
            .btn-secondary {
                border-radius: 20px;
                padding: 10px 24px;
                font-weight: 500;
            }
            .modal-footer {
                padding: 1rem 1.5rem;
                border-top: 1px solid #dee2e6;
                border-radius: 0 0 12px 12px;
                background: #fff;
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
            .warning-note {
                background-color: #fff3cd;
                border: 1px solid #ffeaa7;
                color: #856404;
                padding: 1rem;
                border-radius: 10px;
                margin-bottom: 1rem;
            }
            .toast-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1055;
            }
            .alert { border-radius: 10px; }
            .no-options { color: #dc3545; font-weight: 500; }
            /* Danger Header for Delete Modal */
            .modal-header-danger {
                background: #dc3545;
                color: white;
                border-radius: 12px 12px 0 0 !important;
                padding: 1rem 1.5rem;
            }
            .modal-header-danger .btn-close { filter: invert(1); }
        </style>
    </head>
    <body>
       @extends('Components.staff_produk')
@section('content')
<div class="container py-5">
    <div class="orders-header">
        <h3><i class="bi bi-tag"></i>Kelola Kategori, Satuan & Supplier</h3>
        <small class="text-muted">Kelola data kategori, satuan, dan supplier produk</small>
    </div>
    <!-- Flash Messages -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <!-- Custom Tab Buttons -->
    <div class="orders-tabs mb-4">
        <a href="{{ route('produk.komponen.index', ['tab' => 'kategori']) }}" class="orders-tab {{ $activeTab == 'kategori' ? 'active' : '' }}" data-tab="kategori">Kategori</a>
        <a href="{{ route('produk.komponen.index', ['tab' => 'satuan']) }}" class="orders-tab {{ $activeTab == 'satuan' ? 'active' : '' }}" data-tab="satuan">Satuan</a>
        <a href="{{ route('produk.komponen.index', ['tab' => 'supplier']) }}" class="orders-tab {{ $activeTab == 'supplier' ? 'active' : '' }}" data-tab="supplier">Supplier</a>
    </div>
    <div class="tab-content">
        <!-- ============================
             TAB 1 — KATEGORI
        =============================-->
        <div class="tab-panel {{ $activeTab == 'kategori' ? 'active' : '' }}" id="kategori">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold">Data Kategori</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalKategori">
                    <i class="bi bi-plus-circle"></i> Tambah Kategori
                </button>
            </div>
            <div class="search-controls mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchKategori" class="form-control" placeholder="Cari kategori...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tableKategori">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px">No</th>
                            <th>Nama Kategori</th>
                            <th>Jumlah Produk</th>
                            <th style="width: 140px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $index => $kat)
                            <tr data-id="{{ $kat->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kat->nama_kategori }}</td>
                                <td><span class="badge bg-success">{{ $kat->produk_count }}</span></td>
                                <td>
                                    <button class="btn btn-warning btn-sm btn-edit-kat" data-bs-toggle="modal" data-bs-target="#editModalKategori" data-id="{{ $kat->id }}" data-nama="{{ $kat->nama_kategori }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete-kat" data-id="{{ $kat->id }}" data-nama="{{ $kat->nama_kategori }}" data-count="{{ $kat->produk_count }}" data-destroy-url="{{ route('produk.komponen.kategori.destroy', $kat->id) }}" data-type="kategori">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- ============================
             TAB 2 — SATUAN
        =============================-->
        <div class="tab-panel {{ $activeTab == 'satuan' ? 'active' : '' }}" id="satuan">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold">Data Satuan</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalSatuan">
                    <i class="bi bi-plus-circle"></i> Tambah Satuan
                </button>
            </div>
            <div class="search-controls mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchSatuan" class="form-control" placeholder="Cari satuan...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tableSatuan">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px">No</th>
                            <th>Nama Satuan</th>
                            <th>Jumlah Produk</th>
                            <th style="width: 140px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($satuan as $index => $sat)
                            <tr data-id="{{ $sat->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sat->nama_satuan }}</td>
                                <td><span class="badge bg-info">{{ $sat->produk_count }}</span></td>
                                <td>
                                    <button class="btn btn-warning btn-sm btn-edit-sat" data-bs-toggle="modal" data-bs-target="#editModalSatuan" data-id="{{ $sat->id }}" data-nama="{{ $sat->nama_satuan }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete-sat" data-id="{{ $sat->id }}" data-nama="{{ $sat->nama_satuan }}" data-count="{{ $sat->produk_count }}" data-destroy-url="{{ route('produk.komponen.satuan.destroy', $sat->id) }}" data-type="satuan">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- ============================
             TAB 3 — SUPPLIER
        =============================-->
        <div class="tab-panel {{ $activeTab == 'supplier' ? 'active' : '' }}" id="supplier">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold">Data Supplier</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalSupplier">
                    <i class="bi bi-plus-circle"></i> Tambah Supplier
                </button>
            </div>
            <div class="search-controls mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchSupplier" class="form-control" placeholder="Cari supplier...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tableSupplier">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px">No</th>
                            <th>Nama Supplier</th>
                            <th>Jumlah Produk</th>
                            <th style="width: 140px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supplier as $index => $sup)
                            <tr data-id="{{ $sup->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sup->nama_supplier }}</td>
                                <td><span class="badge bg-primary">{{ $sup->produk_count }}</span></td>
                                <td>
                                    <button class="btn btn-warning btn-sm btn-edit-sup" data-bs-toggle="modal" data-bs-target="#editModalSupplier" data-id="{{ $sup->id }}" data-nama="{{ $sup->nama_supplier }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete-sup" data-id="{{ $sup->id }}" data-nama="{{ $sup->nama_supplier }}" data-count="{{ $sup->produk_count }}" data-destroy-url="{{ route('produk.komponen.supplier.destroy', $sup->id) }}" data-type="supplier">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- Modal Tambah Kategori --}}
<div class="modal fade" id="modalKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('produk.komponen.kategori.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
{{-- Modal Edit Kategori --}}
<div class="modal fade" id="editModalKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="formEditKategori">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="warning-note">
                        <strong>Catatan:</strong> Jika anda ingin mengubah nama kategori "<span id="editNamaKategori"></span>" maka seluruh produk terkait yang memakai nama "<span id="editNamaKategori"></span>" akan diubah semua.
                    </div>
                    <input type="hidden" id="editIdKategori" name="id">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori Baru</label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="editNamaKategoriInput" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-warning">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Move Kategori --}}
<div class="modal fade" id="modalMoveKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="moveModalTitleKategori">Pindahkan Produk Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('produk.komponen.kategori.move') }}">
                @csrf
                <input type="hidden" id="moveSourceIdKategori" name="source_id">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <p class="mb-3">Kategori ini masih digunakan oleh <strong id="moveCountKategori"></strong> produk. Untuk menghapus, pindahkan dulu semua produk ke kategori lain.</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Kategori Tujuan</label>
                        <select name="target_id" id="moveSelectKategori" class="form-select" required>
                            <option value="">Pilih Kategori Lain</option>
                        </select>
                    </div>
                    <div id="noOptionsKategori" class="alert alert-danger no-options" style="display: none;">
                        Tidak ada kategori lain yang tersedia. Silakan tambahkan kategori baru terlebih dahulu.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="batalMoveKategori">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitMoveKategori">Pindahkan Semua Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Tambah Satuan --}}
<div class="modal fade" id="modalSatuan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Satuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('produk.komponen.satuan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Satuan</label>
                        <input type="text" class="form-control @error('nama_satuan') is-invalid @enderror" name="nama_satuan" value="{{ old('nama_satuan') }}" required>
                        @error('nama_satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
{{-- Modal Edit Satuan --}}
<div class="modal fade" id="editModalSatuan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Edit Satuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="formEditSatuan">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="warning-note">
                        <strong>Catatan:</strong> Jika anda ingin mengubah nama satuan "<span id="editNamaSatuan"></span>" maka seluruh produk terkait yang memakai nama "<span id="editNamaSatuan"></span>" akan diubah semua.
                    </div>
                    <input type="hidden" id="editIdSatuan" name="id">
                    <div class="mb-3">
                        <label class="form-label">Nama Satuan Baru</label>
                        <input type="text" class="form-control @error('nama_satuan') is-invalid @enderror" id="editNamaSatuanInput" name="nama_satuan" value="{{ old('nama_satuan') }}" required>
                        @error('nama_satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-warning">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Move Satuan --}}
<div class="modal fade" id="modalMoveSatuan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="moveModalTitleSatuan">Pindahkan Produk Satuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('produk.komponen.satuan.move') }}">
                @csrf
                <input type="hidden" id="moveSourceIdSatuan" name="source_id">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <p class="mb-3">Satuan ini masih digunakan oleh <strong id="moveCountSatuan"></strong> produk. Untuk menghapus, pindahkan dulu semua produk ke satuan lain.</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Satuan Tujuan</label>
                        <select name="target_id" id="moveSelectSatuan" class="form-select" required>
                            <option value="">Pilih Satuan Lain</option>
                        </select>
                    </div>
                    <div id="noOptionsSatuan" class="alert alert-danger no-options" style="display: none;">
                        Tidak ada satuan lain yang tersedia. Silakan tambahkan satuan baru terlebih dahulu.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="batalMoveSatuan">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitMoveSatuan">Pindahkan Semua Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Tambah Supplier --}}
<div class="modal fade" id="modalSupplier" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('produk.komponen.supplier.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Supplier</label>
                        <input type="text" class="form-control @error('nama_supplier') is-invalid @enderror" name="nama_supplier" value="{{ old('nama_supplier') }}" required>
                        @error('nama_supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
{{-- Modal Edit Supplier --}}
<div class="modal fade" id="editModalSupplier" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Edit Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="formEditSupplier">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="warning-note">
                        <strong>Catatan:</strong> Jika anda ingin mengubah nama supplier "<span id="editNamaSupplier"></span>" maka seluruh produk terkait yang memakai nama "<span id="editNamaSupplier"></span>" akan diubah semua.
                    </div>
                    <input type="hidden" id="editIdSupplier" name="id">
                    <div class="mb-3">
                        <label class="form-label">Nama Supplier Baru</label>
                        <input type="text" class="form-control @error('nama_supplier') is-invalid @enderror" id="editNamaSupplierInput" name="nama_supplier" value="{{ old('nama_supplier') }}" required>
                        @error('nama_supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-warning">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Move Supplier --}}
<div class="modal fade" id="modalMoveSupplier" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="moveModalTitleSupplier">Pindahkan Produk Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('produk.komponen.supplier.move') }}">
                @csrf
                <input type="hidden" id="moveSourceIdSupplier" name="source_id">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <p class="mb-3">Supplier ini masih digunakan oleh <strong id="moveCountSupplier"></strong> produk. Untuk menghapus, pindahkan dulu semua produk ke supplier lain.</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Supplier Tujuan</label>
                        <select name="target_id" id="moveSelectSupplier" class="form-select" required>
                            <option value="">Pilih Supplier Lain</option>
                        </select>
                    </div>
                    <div id="noOptionsSupplier" class="alert alert-danger no-options" style="display: none;">
                        Tidak ada supplier lain yang tersedia. Silakan tambahkan supplier baru terlebih dahulu.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="batalMoveSupplier">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitMoveSupplier">Pindahkan Semua Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="modalDeleteConfirm" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus <strong id="deleteName"></strong>?</p>
                <p id="deleteWarning" class="text-danger" style="display: none;">Catatan: Ini akan menghapus seluruh data terkait jika ada.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>
{{-- Toast Container --}}
<div class="toast-container">
    <div id="toastSuccess" class="toast" role="alert" data-bs-delay="5000">
        <div class="toast-header">
            <i class="bi bi-check-circle text-success me-2"></i>
            <strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            @if(session('success'))
                {{ session('success') }}
            @else
                Data berhasil disimpan.
            @endif
        </div>
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // TAMBAHAN: Tab Switching
    const tabs = document.querySelectorAll('.orders-tab');
    const panels = document.querySelectorAll('.tab-panel');
    
    function activateTab(tabName) {
        tabs.forEach(t => {
            t.classList.remove('active');
            if(t.dataset.tab === tabName) t.classList.add('active');
        });
        panels.forEach(p => {
            p.classList.remove('active');
            if(p.id === tabName) p.classList.add('active');
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', e => {
            e.preventDefault();
            activateTab(tab.dataset.tab);
        });
    });

    // ================= KATEGORI =================
    document.querySelectorAll('.btn-edit-kat').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nama = btn.dataset.nama;
            document.getElementById('editNamaKategori').textContent = nama;
            document.getElementById('editNamaKategoriInput').value = nama;
            document.getElementById('formEditKategori').action = "{{ url('/staff_produk/komponen/kategori') }}/" + id;
        });
    });

    // ================= SATUAN =================
    document.querySelectorAll('.btn-edit-sat').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nama = btn.dataset.nama;
            document.getElementById('editNamaSatuan').textContent = nama;
            document.getElementById('editNamaSatuanInput').value = nama;
            document.getElementById('formEditSatuan').action = "{{ url('/staff_produk/komponen/satuan') }}/" + id;
        });
    });

    // ================= SUPPLIER =================
    document.querySelectorAll('.btn-edit-sup').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nama = btn.dataset.nama;
            document.getElementById('editNamaSupplier').textContent = nama;
            document.getElementById('editNamaSupplierInput').value = nama;
            document.getElementById('formEditSupplier').action = "{{ url('/staff_produk/komponen/supplier') }}/" + id;
        });
    });

    // ================= SEARCH =================
    function searchTable(inputId, tableId) {
        document.getElementById(inputId).addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll(`#${tableId} tbody tr`);
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
    }
    searchTable('searchKategori', 'tableKategori');
    searchTable('searchSatuan', 'tableSatuan');
    searchTable('searchSupplier', 'tableSupplier');

    // Auto-show toast success
    @if(session('success'))
        const toastEl = document.getElementById('toastSuccess');
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    @endif

    // ================= DELETE & MOVE =================
    function capitalize(str) { return str.charAt(0).toUpperCase() + str.slice(1); }

    function populateMoveSelect(capitalType, excludeId) {
        const select = document.getElementById(`moveSelect${capitalType}`);
        const allRows = document.querySelectorAll(`#table${capitalType} tbody tr`);
        const noOptionsDiv = document.getElementById(`noOptions${capitalType}`);
        const submitBtn = document.getElementById(`submitMove${capitalType}`);
        const batalBtn = document.getElementById(`batalMove${capitalType}`);

        // Capture placeholder logic
        const placeholderText = `Pilih ${capitalType} Lain`;
        
        // ROBUST RESET: Clear entirely and re-add placeholder
        select.innerHTML = ''; 
        const placeholderOpt = document.createElement('option');
        placeholderOpt.value = "";
        placeholderOpt.textContent = placeholderText;
        select.appendChild(placeholderOpt);

        const addedIds = new Set();
        let hasOptions = false;

        allRows.forEach(row => {
            const id = row.dataset.id;
            // Only add if not excluded and not already added
            if (id != excludeId && !addedIds.has(id)) {
                const opt = document.createElement('option');
                opt.value = id;
                opt.textContent = row.querySelector('td:nth-child(2)').textContent.trim();
                select.appendChild(opt);
                
                addedIds.add(id);
                hasOptions = true;
            }
        });

        // Set default to placeholder
        select.selectedIndex = 0;

        if (!hasOptions) {
            noOptionsDiv.style.display = 'block';
            batalBtn.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.type = 'button';
            submitBtn.setAttribute('data-bs-dismiss', 'modal');
            submitBtn.textContent = 'OK';
            submitBtn.classList.remove('btn-primary');
            submitBtn.classList.add('btn-secondary');
        } else {
            noOptionsDiv.style.display = 'none';
            batalBtn.style.display = '';
            submitBtn.disabled = false;
            submitBtn.type = 'submit';
            submitBtn.removeAttribute('data-bs-dismiss');
            submitBtn.textContent = 'Pindahkan Semua Produk';
            submitBtn.classList.remove('btn-secondary');
            submitBtn.classList.add('btn-primary');
        }
    }

    function handleDelete(type, btn) {
        const id = btn.dataset.id;
        const count = parseInt(btn.dataset.count);
        const nama = btn.dataset.nama;
        const destroyUrl = btn.dataset.destroyUrl;
        const capitalType = capitalize(type);

        if (count === 0) {
            document.getElementById('deleteName').textContent = nama;
            // Simpan URL di tombol konfirmasi
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            confirmBtn.dataset.url = destroyUrl; 
            
            // Show Modal
            new bootstrap.Modal(document.getElementById('modalDeleteConfirm')).show();
        } else {
            document.getElementById(`moveSourceId${capitalType}`).value = id;
            populateMoveSelect(capitalType, id);
            document.getElementById(`moveCount${capitalType}`).textContent = count;
            document.getElementById(`moveModalTitle${capitalType}`).textContent = `Pindahkan Produk dari "${nama}" ke ${type} lain`;
            new bootstrap.Modal(document.getElementById(`modalMove${capitalType}`)).show();
        }
    }

    // Event listeners for delete buttons
    document.querySelectorAll('.btn-delete-kat').forEach(btn => {
        btn.addEventListener('click', () => handleDelete('kategori', btn));
    });
    document.querySelectorAll('.btn-delete-sat').forEach(btn => {
        btn.addEventListener('click', () => handleDelete('satuan', btn));
    });
    document.querySelectorAll('.btn-delete-sup').forEach(btn => {
        btn.addEventListener('click', () => handleDelete('supplier', btn));
    });

    // Action listener for Confirm Delete Button
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        const url = this.dataset.url;
        if(url) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            const inputs = [
                {name: '_token', value: "{{ csrf_token() }}", type: 'hidden'},
                {name: '_method', value: 'DELETE', type: 'hidden'}
            ];
            inputs.forEach(i => {
                const input = document.createElement('input');
                input.type = i.type;
                input.name = i.name;
                input.value = i.value;
                form.appendChild(input);
            });
            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>
    </body>
</html>
