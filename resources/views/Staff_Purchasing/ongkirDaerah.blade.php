<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

.modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .modal-header {
            background: #198754;
            color: white;
            border-bottom: none;
            padding: 1rem 1.5rem;
            border-radius: 12px 12px 0 0 !important;
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
            padding: 1rem 1.5rem;
            border-radius: 0 0 12px 12px;
        }

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

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
        }

        .alert {
            border-radius: 10px;
        }

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
    @extends('Components.staff_purchasing')

    @section('content')
    <div class="container py-5">
        <div class="orders-header">
            <h3><i class="bi bi-geo-alt"></i>Kelola Ongkir & Daerah</h3>
            <small class="text-muted">Kelola data wilayah dan ongkos kirim</small>
        </div>

<div class="orders-tabs mb-4">
            <a href="{{ route('staff_purchasing.ongkir.index', ['tab' => 'kecamatan']) }}" class="orders-tab {{ $activeTab == 'kecamatan' ? 'active' : '' }}" data-tab="kecamatan">Kecamatan</a>
            <a href="{{ route('staff_purchasing.ongkir.index', ['tab' => 'kelurahan']) }}" class="orders-tab {{ $activeTab == 'kelurahan' ? 'active' : '' }}" data-tab="kelurahan">Kelurahan</a>
            <a href="{{ route('staff_purchasing.ongkir.index', ['tab' => 'kodepos']) }}" class="orders-tab {{ $activeTab == 'kodepos' ? 'active' : '' }}" data-tab="kodepos">Kode Pos</a>
        </div>

        <div class="tab-content">

<div class="tab-panel {{ $activeTab == 'kecamatan' ? 'active' : '' }}" id="kecamatan">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold">Data Kecamatan</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalKecamatan">
                        <i class="bi bi-plus-circle"></i> Tambah Kecamatan
                    </button>
                </div>

                <form method="GET" action="{{ route('staff_purchasing.ongkir.index') }}" class="search-controls mb-3">
                    <input type="hidden" name="tab" value="kecamatan">
                    <div class="input-group flex-grow-1">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search_kecamatan" class="form-control" placeholder="Cari kecamatan..." value="{{ request('search_kecamatan') }}">
                        <button type="submit" class="btn btn-outline-secondary">Cari</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px">No</th>
                                <th>Nama Kecamatan</th>
                                <th>Ongkir Minimal Mobil (Rp)</th>
                                <th>Ongkir Minimal Motor (Rp)</th>
                                <th>Jumlah Kelurahan</th>
                                <th style="width: 140px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kecamatan as $index => $item)
                                <tr data-id="{{ $item->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_kecamatan }}</td>
                                    <td>{{ number_format($item->ongkir_minimal_mobil, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->ongkir_minimal_motor, 0, ',', '.') }}</td>
                                    <td><span class="badge bg-success">{{ $item->kelurahan_count }}</span></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-edit-kec" data-bs-toggle="modal" data-bs-target="#modalKecamatan" data-id="{{ $item->id }}" data-nama="{{ $item->nama_kecamatan }}" data-ongkir-mobil="{{ $item->ongkir_minimal_mobil }}" data-ongkir-motor="{{ $item->ongkir_minimal_motor }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-delete-kec"
                                            data-url="{{ route('staff_purchasing.kecamatan.destroy', $item->id) }}"
                                            data-nama="{{ $item->nama_kecamatan }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data kecamatan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

<div class="tab-panel {{ $activeTab == 'kelurahan' ? 'active' : '' }}" id="kelurahan">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold">Data Kelurahan</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalKelurahan">
                        <i class="bi bi-plus-circle"></i> Tambah Kelurahan
                    </button>
                </div>

                <form method="GET" action="{{ route('staff_purchasing.ongkir.index') }}" class="row mb-3 g-0">
                    <input type="hidden" name="tab" value="kelurahan">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Kecamatan</label>
                        <select class="form-select" name="filter_kec_kelurahan" onchange="this.form.submit()">
                            <option value="">Semua Kecamatan</option>
                            @foreach($kecamatan as $kec)
                                <option value="{{ $kec->id }}" {{ request('filter_kec_kelurahan') == $kec->id ? 'selected' : '' }}>{{ $kec->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Cari Kelurahan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search_kelurahan" class="form-control" placeholder="Cari kelurahan..." value="{{ request('search_kelurahan') }}">
                            <button type="submit" class="btn btn-outline-secondary">Cari</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
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
                            @forelse($kelurahan as $index => $item)
                                <tr data-id="{{ $item->id }}" data-kec="{{ $item->id_kecamatan }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_kelurahan }}</td>
                                    <td>{{ $item->kecamatan->nama_kecamatan ?? '-' }}</td>
                                    <td><span class="badge bg-info">{{ $item->kode_pos_count }}</span></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-edit-kel" data-bs-toggle="modal" data-bs-target="#modalKelurahan" data-id="{{ $item->id }}" data-nama="{{ $item->nama_kelurahan }}" data-kec="{{ $item->id_kecamatan }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-delete-kel"
                                            data-url="{{ route('staff_purchasing.kelurahan.destroy', $item->id) }}"
                                            data-nama="{{ $item->nama_kelurahan }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data kelurahan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

<div class="tab-panel {{ $activeTab == 'kodepos' ? 'active' : '' }}" id="kodepos">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold">Data Kode Pos</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalKodePos">
                        <i class="bi bi-plus-circle"></i> Tambah Kode Pos
                    </button>
                </div>

                <form method="GET" action="{{ route('staff_purchasing.ongkir.index') }}" class="row mb-3 g-0">
                    <input type="hidden" name="tab" value="kodepos">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Kecamatan</label>
                        <select class="form-select" name="filter_kec_kodepos" onchange="this.form.submit()">
                            <option value="">Semua Kecamatan</option>
                            @foreach($kecamatan as $kec)
                                <option value="{{ $kec->id }}" {{ request('filter_kec_kodepos') == $kec->id ? 'selected' : '' }}>{{ $kec->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Kelurahan</label>
                        <select class="form-select" name="filter_kel_kodepos" onchange="this.form.submit()">
                            <option value="">Semua Kelurahan</option>
                            @foreach($filter_kelurahans as $id => $nama)
                                <option value="{{ $id }}" {{ request('filter_kel_kodepos') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Cari Kode Pos</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search_kodepos" class="form-control" placeholder="Cari kode pos..." value="{{ request('search_kodepos') }}">
                            <button type="submit" class="btn btn-outline-secondary">Cari</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
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
                            @forelse($kodepos as $index => $item)
                                <tr data-id="{{ $item->id }}" data-kel="{{ $item->id_kelurahan }}" data-kec="{{ $item->kelurahan->id_kecamatan ?? '' }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->kode_pos }}</td>
                                    <td>{{ $item->kelurahan->nama_kelurahan ?? '-' }}</td>
                                    <td>{{ $item->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-edit-kp" data-bs-toggle="modal" data-bs-target="#modalKodePos" data-id="{{ $item->id }}" data-kode="{{ $item->kode_pos }}" data-kel="{{ $item->id_kelurahan }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-delete-kp"
                                            data-url="{{ route('staff_purchasing.kodepos.destroy', $item->id) }}"
                                            data-nama="{{ $item->kode_pos }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data kode pos.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

<div class="modal fade" id="modalKecamatan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleKecamatan">Tambah Kecamatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formKecamatan" method="POST" action="{{ route('staff_purchasing.kecamatan.store') }}">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <div class="modal-body">
                        <input type="hidden" id="idKecamatan" name="id" value="">
                        <div class="mb-3">
                            <label class="form-label">Nama Kecamatan</label>
                            <input type="text" class="form-control" id="namaKecamatan" name="nama_kecamatan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ongkir Minimal Mobil (Rp)</label>
                            <input type="number" class="form-control" id="ongkirMobilKecamatan" name="ongkir_minimal_mobil" min="1" step="1000" required oninput="if(this.value === '0') this.value = '';">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ongkir Minimal Motor (Rp)</label>
                            <input type="number" class="form-control" id="ongkirMotorKecamatan" name="ongkir_minimal_motor" min="1" step="1000" required oninput="if(this.value === '0') this.value = '';">
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

<div class="modal fade" id="modalKelurahan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleKelurahan">Tambah Kelurahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formKelurahan" method="POST" action="{{ route('staff_purchasing.kelurahan.store') }}">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <div class="modal-body">
                        <input type="hidden" id="idKelurahan" name="id" value="">
                        <div class="mb-3">
                            <label class="form-label">Kecamatan</label>
                            <select class="form-select" id="kecamatanKelurahan" name="id_kecamatan" required>
                                <option value="">Pilih Kecamatan</option>
                                @foreach($kecamatan as $kec)
                                    <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Kelurahan</label>
                            <input type="text" class="form-control" id="namaKelurahan" name="nama_kelurahan" required>
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

<div class="modal fade" id="modalKodePos" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleKodePos">Tambah Kode Pos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formKodePos" method="POST" action="{{ route('staff_purchasing.kodepos.store') }}">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <div class="modal-body">
                        <input type="hidden" id="idKodePos" name="id" value="">
                        <div class="mb-3">
                            <label class="form-label">Kelurahan</label>
                            <select class="form-select" id="kelurahanKodePos" name="id_kelurahan" required>
                                <option value="">Pilih Kelurahan</option>
                                @foreach($filter_kelurahans as $id => $nama)
                                    <option value="{{ $id }}">{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" class="form-control" id="kodePos" name="kode_pos" maxlength="5" pattern="[0-9]{5}" title="Kode pos harus 5 digit angka (leading zero diperbolehkan)" required>
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

<div class="modal fade" id="modalDeleteConfirm" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-danger">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus <strong id="deleteName"></strong>?</p>
                    <p class="text-danger small mb-0"><i class="bi bi-exclamation-triangle"></i> Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>

<div class="toast-container">
        <div id="toastSuccess" class="toast align-items-center text-white bg-success border-0" role="alert" data-bs-autohide="true" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle me-2"></i>
                    <span id="successMessage">
                        @if(session('success'))
                            {{ session('success') }}
                        @else
                            Data berhasil disimpan!
                        @endif
                    </span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <div id="toastError" class="toast align-items-center text-white bg-danger border-0" role="alert" data-bs-autohide="true" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <span id="errorMessage">
                        @if(session('error'))
                            {{ session('error') }}
                        @elseif($errors->any())
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        @else
                            Terjadi kesalahan. Silakan coba lagi.
                        @endif
                    </span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            @if(session('success'))
                const successToast = new bootstrap.Toast(document.getElementById('toastSuccess'));
                successToast.show();
            @endif

            @if(session('error') || $errors->any())
                const errorToast = new bootstrap.Toast(document.getElementById('toastError'));
                errorToast.show();
            @endif

window.showToast = function(type, message, delay = 5000) {
                const toastId = type === 'success' ? 'toastSuccess' : 'toastError';
                const toastEl = document.getElementById(toastId);
                const messageEl = document.getElementById(type === 'success' ? 'successMessage' : 'errorMessage');

                if (messageEl) {
                    messageEl.innerHTML = message;
                }

                const toast = new bootstrap.Toast(toastEl, { delay: delay });
                toast.show();
            };

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

            document.getElementById('formKecamatan').dataset.defaultAction = `{{ route('staff_purchasing.kecamatan.store') }}`;
            document.getElementById('formKelurahan').dataset.defaultAction = `{{ route('staff_purchasing.kelurahan.store') }}`;
            document.getElementById('formKodePos').dataset.defaultAction = `{{ route('staff_purchasing.kodepos.store') }}`;

let deleteUrl = '';

            function setupDeleteListener(selector) {
                document.querySelectorAll(selector).forEach(btn => {
                    btn.addEventListener('click', function() {
                        deleteUrl = this.dataset.url;
                        const nama = this.dataset.nama;
                        document.getElementById('deleteName').textContent = nama;
                        new bootstrap.Modal(document.getElementById('modalDeleteConfirm')).show();
                    });
                });
            }

            setupDeleteListener('.btn-delete-kec');
            setupDeleteListener('.btn-delete-kel');
            setupDeleteListener('.btn-delete-kp');

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (deleteUrl) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = deleteUrl;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                    const inputs = [
                        {name: '_token', value: '{{ csrf_token() }}', type: 'hidden'},
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

        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-edit-kec')) {
                const btn = e.target.closest('.btn-edit-kec');
                const id = btn.dataset.id;
                const nama = btn.dataset.nama;
                const ongkirMobil = btn.dataset.ongkirMobil;
                const ongkirMotor = btn.dataset.ongkirMotor;
                const form = document.getElementById('formKecamatan');
                let updateUrl = `{{ route('staff_purchasing.kecamatan.update', ':id') }}`;
                form.action = updateUrl.replace(':id', id);
                form.querySelector('input[name="_method"]').value = 'PUT';
                document.getElementById('namaKecamatan').value = nama;
                document.getElementById('ongkirMobilKecamatan').value = ongkirMobil;
                document.getElementById('ongkirMotorKecamatan').value = ongkirMotor;
                document.getElementById('titleKecamatan').textContent = 'Edit Kecamatan';
                document.getElementById('idKecamatan').value = id;
            }

            if (e.target.closest('.btn-edit-kel')) {
                const btn = e.target.closest('.btn-edit-kel');
                const id = btn.dataset.id;
                const nama = btn.dataset.nama;
                const kec = btn.dataset.kec;
                const form = document.getElementById('formKelurahan');
                let updateUrl = `{{ route('staff_purchasing.kelurahan.update', ':id') }}`;
                form.action = updateUrl.replace(':id', id);
                form.querySelector('input[name="_method"]').value = 'PUT';
                document.getElementById('namaKelurahan').value = nama;
                document.getElementById('kecamatanKelurahan').value = kec;
                document.getElementById('titleKelurahan').textContent = 'Edit Kelurahan';
                document.getElementById('idKelurahan').value = id;
            }

            if (e.target.closest('.btn-edit-kp')) {
                const btn = e.target.closest('.btn-edit-kp');
                const id = btn.dataset.id;
                const kode = btn.dataset.kode;
                const kel = btn.dataset.kel;
                const form = document.getElementById('formKodePos');
                let updateUrl = `{{ route('staff_purchasing.kodepos.update', ':id') }}`;
                form.action = updateUrl.replace(':id', id);
                form.querySelector('input[name="_method"]').value = 'PUT';
                document.getElementById('kodePos').value = kode;
                document.getElementById('idKodePos').value = id;
                document.getElementById('kelurahanKodePos').value = kel;
                document.getElementById('titleKodePos').textContent = 'Edit Kode Pos';
            }
        });

        const modals = ['modalKecamatan', 'modalKelurahan', 'modalKodePos'];
        modals.forEach(modalId => {
            const modalEl = document.getElementById(modalId);
            modalEl.addEventListener('hidden.bs.modal', function() {
                const form = this.querySelector('form');
                form.action = form.dataset.defaultAction;
                form.querySelector('input[name="_method"]').value = 'POST';
                const title = this.querySelector('.modal-title');
                if (title.textContent.startsWith('Edit ')) {
                    title.textContent = title.textContent.replace('Edit ', 'Tambah ');
                }
                form.reset();
                const hiddenId = this.querySelector('input[type="hidden"][name="id"]');
                if (hiddenId) hiddenId.value = '';
            });
        });
    </script>
</body>
</html>
