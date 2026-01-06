<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kelola Batch - Data Produk</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
            body { background-color: var(--bg-main); color: var(--text-dark); }
            .dashboard-container { padding: 1.5rem; max-width: 1200px; margin: auto; }
            .dashboard-title { font-size: 1.6rem; font-weight: 700; color: var(--green-primary); display: flex; align-items: center; gap: .5rem; }

            .product-detail-card { background: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); overflow: hidden; margin-bottom: 2rem; }
            .product-detail-header { background: var(--green-soft); padding: 1.5rem; border-bottom: 1px solid var(--border-color); position: relative; display: flex; align-items: center; justify-content: space-between; }
            .header-left { display: flex; align-items: center; gap: 1rem; }
            .btn-back { background: transparent; border: none; color: var(--text-muted); font-size: 1.2rem; padding: 0; }
            .btn-back:hover { color: var(--text-dark); }
            .btn-add-top { position: absolute; right: 1.5rem; top: 1.4rem; background: var(--green-primary); color: white; border-radius: .5rem; padding: .45rem .9rem; font-weight: 600; border: none; }
            .btn-add-top:hover { background: var(--green-text); }

            .product-detail-body { padding: 1.5rem; }
            .product-detail-body img { width: 100%; border-radius: .5rem; border: 1px solid var(--border-color); }

            .badge-kategori, .badge-supplier {
                font-size: .8rem; padding: .4rem .7rem; border-radius: .5rem; font-weight: 600;
            }

            .batch-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: var(--white); padding: 1.5rem 2rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
            .batch-header h3 { color: #2a522a; margin: 0; display: flex; align-items: center; gap: .5rem; }
            .batch-search {
                width: 500px !important;
                max-width: 500px !important;
            }

            .table-card { background: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); overflow: hidden; }
            .table { table-layout: fixed; }
            .table th, .table td { font-size: .8rem; padding: .5rem .25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .table th { background: var(--green-soft); color: var(--green-text); font-weight: 600; font-size: .75rem; text-transform: uppercase; border-bottom: 2px solid var(--border-color); }
            .table td { vertical-align: middle; border-top: 1px solid var(--border-color); color: var(--text-dark); }
            .table tbody tr:hover { background-color: #F3F4F6; }
            .harga-normal { font-weight: 600; color: var(--text-dark); font-size: .8rem; }
            .col-batch { width: 8%; }
            .col-tgl-masuk { width: 10%; }
            .col-tgl-exp { width: 10%; }
            .col-sisa-hari { width: 8%; text-align: center; }
            .col-harga-normal { width: 9%; }
            .col-harga-saat { width: 9%; }
            .col-tgl-perubahan { width: 10%; }
            .col-ket-harga { width: 12%; }
            .col-stok { width: 6%; text-align: center; }
            .col-status-stok { width: 8%; }
            .col-aksi {
                width: 10%;
                position: relative;
                overflow: visible !important; /* Fix: Izinkan overflow agar dropdown muncul keluar dari sel tabel */
                padding-right: 0.5rem; /* Tambahan: Sedikit padding ekstra untuk ruang button */
            }
            .table td.col-aksi { overflow: visible !important; } /* Override khusus untuk td.col-aksi */

            .btn-table-action { border: none; border-radius: .4rem; padding: .35rem .7rem; font-size: .85rem; font-weight: 500; transition: all .3s ease; margin-right: .25rem; white-space: nowrap; }
            .btn-table-warning { background: #F59E0B; color: white; }
            .btn-table-warning:hover { background: #d97706; }
            .btn-table-primary { background: var(--green-primary); color: white; }
            .btn-table-primary:hover { background: var(--green-text); }
            .btn-table-danger { background: #EF4444; color: white; }
            .btn-table-danger:hover { background: #dc2626; }

            .dropdown-menu { min-width: 140px; z-index: 1070 !important; position: absolute; }
            .dropdown-item { padding: .5rem .75rem; font-size: .85rem; }
            .dropdown-item:hover { background-color: #f8f9fa; }
            .dropdown-divider { margin: 0; }

            .badge-status { padding: .25rem .6rem; font-size: .7rem; border-radius: 1rem; font-weight: 600; display: inline-block; margin-right: .25rem; line-height: 1.5; }
            .badge-tersedia { background: #DBEAFE; color: #1E40AF; }
            .badge-menipis { background: #FEF3C7; color: #92400E; }
            .badge-habis { background: #FEE2E2; color: #991B1B; }
            .badge-ditampilkan { background: #DCFCE7; color: #166534; }
            .badge-diarsipkan { background: #E5E7EB; color: #374151; }
            .badge-draft { background: #F3E8FF; color: #7E22CE; }

            .badge-harga-normal, .badge-harga-diskon, .badge-harga-naik {
                font-size: .65rem; padding: .25rem .5rem; border-radius: 15px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px; display: block;
            }
            .badge-harga-normal {
                background: linear-gradient(135deg, #6B7280, #9CA3AF);
                color: white;
                box-shadow: 0 1px 2px rgba(107, 114, 128, 0.2);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .badge-harga-normal:hover {
                transform: scale(1.05);
                box-shadow: 0 2px 4px rgba(107, 114, 128, 0.3);
            }

            .badge-harga-diskon {
                background: linear-gradient(135deg, #F59E0B, #D97706);
                color: white;
                box-shadow: 0 1px 2px rgba(245, 158, 11, 0.3);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .badge-harga-diskon:hover {
                transform: scale(1.05);
                box-shadow: 0 2px 4px rgba(245, 158, 11, 0.4);
            }

            .badge-harga-naik {
                background: linear-gradient(135deg, #10B981, #059669);
                color: white;
                box-shadow: 0 1px 2px rgba(16, 185, 129, 0.3);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .badge-harga-naik:hover {
                transform: scale(1.05);
                box-shadow: 0 2px 4px rgba(16, 185, 129, 0.4);
            }

            .modal-rusak .form-control { border-radius: .5rem; }
            .modal-rusak .form-label { font-weight: 600; }
            .modal-rusak input[type="file"] { border: 1px solid var(--border-color); border-radius: .5rem; padding: .5rem; }

            .table-responsive { overflow: visible; }
            .col-aksi .dropdown-menu { margin-top: 0; }

            @media (max-width: 768px) {
                .batch-header { flex-direction: column; gap: 1rem; text-align: center; }
                .batch-search { width: 100% !important; }
                .table th, .table td { font-size: .75rem; padding: .4rem .2rem; }
                .dropdown-menu { min-width: 100px; }
                .badge-harga-normal, .badge-harga-diskon, .badge-harga-naik { max-width: 80px; font-size: .6rem; }
                .product-detail-body .row { flex-direction: column; }
                .col-aksi { padding-right: 0.25rem; } /* Adjust untuk mobile */
                .header-left { flex-direction: column; align-items: flex-start; gap: .5rem; }
                .dashboard-title { font-size: 1.4rem; }
            }
        </style>
    </head>
    <body>
        @extends('Components.staff_produk')
        @section('content')

        <div class="dashboard-container">

            <div class="product-detail-card">
                <div class="product-detail-header">
                    <div class="header-left">
                        {{-- DYNAMIC BACK URL DARI SESSION --}}
                        @php
                            $refData = \Illuminate\Support\Facades\Session::get('batch_referrer', ['route' => 'produk.data', 'query' => []]);
                            $backUrl = route($refData['route']);
                            if (!empty($refData['query'])) {
                                $backUrl .= '?' . http_build_query($refData['query']);
                            }
                        @endphp
                        <a href="{{ $backUrl }}" class="btn-back">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                        <h4 class="dashboard-title mb-0"><i class="bi bi-box-seam"></i> Detail Produk</h4>
                    </div>
                    <button class="btn btn-add-top" data-bs-toggle="modal" data-bs-target="#addBatchModal">
                        <i class="bi bi-plus-circle"></i> Tambah Batch
                    </button>
                </div>

                <div class="product-detail-body">
                    <div class="row align-items-start">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/'.$produk->gambar) }}" alt="Produk">
                        </div>

                        <div class="col-md-8">
                            <h4 class="fw-bold">{{ $produk->nama_produk }}</h4>
                            <p class="text-muted">{{ $produk->deskripsi }}</p>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <p>
                                        <strong>Supplier:</strong>
                                        <span class="badge-supplier">
                                            {{ $produk->supplier->nama_supplier ?? '-' }}
                                        </span>
                                    </p>

                                    <p>
                                        <strong>Kategori:</strong>
                                        <span class="badge-kategori">
                                            {{ $produk->kategori->nama_kategori ?? '-' }}
                                        </span>
                                    </p>

                                    <p>
                                        <strong>Satuan:</strong>
                                        {{ $produk->jumlah_satuan }} {{ $produk->satuan->nama_satuan ?? '-' }}
                                    </p>
                                </div>

                                <div class="col-6">
                                    <p>
                                        <strong>Total Stok:</strong>
                                        <span class="fw-bold">
                                            {{ $total_stok }}
                                        </span>
                                    </p>

                                    <p>
                                        <strong>Status Tampil:</strong>
                                        <span class="badge-status badge-{{ strtolower(str_replace([' ', '_'], '-', $produk->status_tampil ?? 'draft')) }}">
                                            {{ $produk->status_tampil }}
                                        </span>
                                    </p>

                                    <p>
                                        <strong>Status Stok:</strong>
                                        <span class="badge-status badge-{{ strtolower(str_replace([' ', '_'], '-', $status_stok ?? 'tersedia')) }}">
                                            {{ $status_stok ?? 'Tersedia' }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="batch-header">
                <div>
                    <h3><i class="bi bi-layers"></i> Daftar Batch <span class="badge bg-success ms-2">{{ count($batches) }}</span></h3>
                    <small class="text-muted">Kelola batch stok produk</small>
                </div>

                <div class="input-group batch-search">
                    <input type="text" class="form-control" id="batchSearch" placeholder="Cari batch...">
                    <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
                </div>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table align-middle table-sm" id="batchTable">
                        <thead>
                            <tr>
                                <th class="col-batch">Batch</th>
                                <th class="col-tgl-masuk">Tgl. Masuk</th>
                                <th class="col-tgl-exp">Tgl. Kadaluarsa</th>
                                <th class="col-sisa-hari">Sisa Hari</th>
                                <th class="col-harga-normal">Harga Normal</th>
                                <th class="col-harga-saat">Harga Saat Ini</th>
                                <th class="col-tgl-perubahan">Tgl. Perubahan</th>
                                <th class="col-ket-harga">Keterangan Harga</th>
                                <th class="col-stok">Stok</th>
                                <th class="col-status-stok">Status Stok</th>
                                <th class="col-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($batches as $batch)
                                <tr>
                                    <td class="col-batch">Batch {{ $batch->id }}</td>
                                    <td class="col-tgl-masuk">{{ $batch->tgl_masuk->format('d/m/Y') }}</td>
                                    <td class="col-tgl-exp">{{ $batch->tgl_kadaluwarsa->format('d/m/Y') }}</td>
                                    <td class="col-sisa-hari fw-bold {{ $batch->sisa_color }}">{{ $batch->sisa_text }}</td>
                                    <td class="col-harga-normal {{ $batch->harga_saat_ini < $batch->harga_normal ? 'text-decoration-line-through text-muted' : '' }}">{{ $batch->harga_normal_rp }}</td>
                                    <td class="col-harga-saat fw-bold {{ $batch->harga_saat_ini < $batch->harga_normal ? 'text-success' : ($batch->harga_saat_ini > $batch->harga_normal ? 'text-success' : '') }}">{{ $batch->harga_saat_ini_rp }}</td>
                                    <td class="col-tgl-perubahan">{{ $batch->tgl_perubahan_format }}</td>
                                    <td class="col-ket-harga" title="{{ $batch->keterangan }}">
                                        @if($batch->harga_saat_ini < $batch->harga_normal)
                                            <span class="badge-harga-diskon">{{ $batch->keterangan }}</span>
                                        @elseif($batch->harga_saat_ini > $batch->harga_normal)
                                            <span class="badge-harga-naik">{{ $batch->keterangan }}</span>
                                        @else
                                            <span class="badge-harga-normal">{{ $batch->keterangan }}</span>
                                        @endif
                                    </td>
                                    <td class="col-stok">{{ $batch->stok }}</td>
                                    <td class="col-status-stok"><span class="badge-status {{ $batch->status_stok_badge }}">{{ $batch->status_stok_text }}</span></td>
                                    <td class="col-aksi">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $batch->id }}" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.25rem; min-width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $batch->id }}">
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#discountModal" onclick="openDiscountModal({{ $batch->id }}, {{ $batch->harga_normal }})"><i class="bi bi-percent"></i> Kasih Diskon</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#hargaModal" onclick="openHargaModal({{ $batch->id }}, {{ $batch->harga_normal }}, {{ $batch->harga_saat_ini }})"><i class="bi bi-arrow-up"></i> Naikkan Harga</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#rusakModal" onclick="setRusakBatch({{ $batch->id }})"><i class="bi bi-exclamation-triangle"></i> Produk Rusak</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editBatchModal" onclick="editBatch({{ $batch->id }}, '{{ $batch->tgl_masuk->format('Y-m-d') }}', '{{ $batch->tgl_kadaluwarsa->format('Y-m-d') }}', {{ $batch->stok }}, '{{ $batch->harga_normal_rp }}', '{{ $batch->harga_saat_ini_rp }}')"><i class="bi bi-pencil"></i> Edit</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete({{ $batch->id }})"><i class="bi bi-trash"></i> Hapus</a>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted">Belum ada batch untuk produk ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <nav aria-label="Batch pagination" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">«</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">»</a>
                    </li>
                </ul>
            </nav>

        </div>

        <!-- Toast Container -->
        <div class="toast-container position-fixed top-0 end-0 p-3">
            @if (session('success'))
                <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>

        <div class="modal fade" id="addBatchModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-2">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Batch Baru</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('produk.batch.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_produk" value="{{ $produk->id }}">

                            <div class="mb-3">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" id="tgl_masuk_add" name="tgl_masuk" class="form-control" value="{{ now()->format('Y-m-d') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Kadaluarsa</label>
                                <input
                                    type="date"
                                    id="tgl_kadaluarsa_add"
                                    name="tgl_kadaluwarsa"
                                    class="form-control"
                                    value="{{ old('tgl_kadaluwarsa', $default_kadaluarsa) }}"
                                >
                                <small class="text-muted">Otomatis berdasarkan tanggal masuk + {{ $produk->estimasi_kadaluwarsa_hari ?? 0 }} hari</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah Stok</label>
                                <input type="number" name="stok" min="1" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Harga Normal</label>
                                <input type="number" name="harga_normal" min="0" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Harga Saat Ini</label>
                                <input type="number" name="harga_saat_ini" min="0" class="form-control" required>
                            </div>

                            <button class="btn btn-success w-100">Tambah Batch</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="editBatchModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-2">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Batch</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editBatchForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="editBatchId" name="id">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" class="form-control" id="editTanggalMasuk" name="tgl_masuk" readonly disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Kadaluarsa</label>
                                <input type="date" class="form-control" id="editTanggalKadaluarsa" name="tgl_kadaluwarsa" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Stok</label>
                                <input type="number" min="1" class="form-control" id="editStok" name="stok" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga Normal (Rp)</label>
                                <input type="number" min="0" class="form-control" id="editHargaNormal" name="harga_normal" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga Saat Ini (Rp)</label>
                                <input type="number" min="0" class="form-control" id="editHargaSaatIni" name="harga_saat_ini" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Update Batch</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteBatchModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deleteBatchForm" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Hapus Batch</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus batch ini? Tindakan ini tidak dapat dibatalkan.</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="discountModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Terapkan Diskon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="discountForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="discountBatchId" name="batch_id">
                            <div class="mb-3">
                                <label class="form-label">Persentase Diskon (%)</label>
                                <input type="number" id="discountPercent" name="diskon_percent" class="form-control" min="0" max="100" step="0.01" required>
                                <small class="text-muted">Masukkan persentase diskon (0-100)</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga Normal</label>
                                <input type="text" id="discountHargaNormal" class="form-control" readonly style="background-color: #f8f9fa;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga Setelah Diskon</label>
                                <input type="text" id="discountHargaHasil" class="form-control fw-bold text-success" readonly style="background-color: #f8f9fa;">
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-warning">Terapkan Diskon</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="hargaModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Naikkan Harga</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="hargaForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Harga Baru (Rp)</label>
                                <input type="number" id="hargaBaru" name="harga_saat_ini" class="form-control" min="0" required>
                                <small class="text-muted">Masukkan harga baru untuk harga saat ini</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga Normal</label>
                                <input type="text" id="hargaHargaNormal" class="form-control" readonly style="background-color: #f8f9fa;">
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Terapkan Harga Baru</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-rusak" id="rusakModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Laporkan Produk Rusak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="rusakForm" action="{{ route('produk.rusak_cacat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_produk" value="{{ $produk->id }}">
                    <input type="hidden" name="id_batch" id="rusakBatchId">

                    <div class="mb-3">
                        <label class="form-label">Jumlah Rusak</label>
                        <input type="number" name="jumlah_rusak" class="form-control" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Ditemukan Rusak</label>
                        <input type="date" name="tgl_rusak" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tingkat Kerusakan</label>
                        <select class="form-select" name="tingkat_rusak" required>
                            <option value="" disabled selected>Pilih tingkat kerusakan</option>
                            <option value="ringan">Ringan</option>
                            <option value="sedang">Sedang</option>
                            <option value="berat">Berat</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bukti Foto</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-danger w-100">Kirim Laporan</button>
                </form>
            </div>
        </div>
    </div>
</div>

        <script>
        function colorizeSingle(badgeEl, text){
            if(!badgeEl || !text) return;
            const colorPairs=[
                {bg:"#BAE6FD",text:"#0369A1"},
                {bg:"#FEF9C3",text:"#A16207"},
                {bg:"#FBCFE8",text:"#9D174D"},
                {bg:"#A7F3D0",text:"#065F46"},
                {bg:"#DDD6FE",text:"#5B21B6"},
                {bg:"#FECACA",text:"#991B1B"},
                {bg:"#FDE68A",text:"#B45309"},
                {bg:"#F5D0FE",text:"#86198F"}
            ];
            let hash=0;
            for(let i=0;i<text.length;i++){
                hash=text.charCodeAt(i)+((hash<<5)-hash);
            }
            const color=colorPairs[Math.abs(hash)%colorPairs.length];
            badgeEl.style.backgroundColor=color.bg;
            badgeEl.style.color=color.text;
        }

        function colorizeBadges(){
            document.querySelectorAll('.badge-supplier, .badge-kategori').forEach(badge=>{
                const text=badge.textContent.trim();
                if(text && text!=='-') colorizeSingle(badge,text.toLowerCase());
            });
        }

        function editBatch(id, tglMasuk, tglExp, stok, hargaNormal, hargaSaat){
            document.getElementById('editBatchForm').action = `/staff_produk/batch/update/${id}`;
            document.getElementById('editTanggalMasuk').value = tglMasuk;
            document.getElementById('editTanggalKadaluarsa').value = tglExp;
            document.getElementById('editStok').value = stok;
            document.getElementById('editHargaNormal').value = hargaNormal.replace(/[^\d]/g,'');
            document.getElementById('editHargaSaatIni').value = hargaSaat.replace(/[^\d]/g,'');
        }

        function confirmDelete(id){
            const form = document.getElementById('deleteBatchForm');
            form.action = `/staff_produk/batch/delete/${id}`;

            new bootstrap.Modal(document.getElementById('deleteBatchModal')).show();
        }

        function openDiscountModal(batchId, hargaNormal) {
            document.getElementById('discountBatchId').value = batchId;
            document.getElementById('discountHargaNormal').value = 'Rp ' + hargaNormal.toLocaleString('id-ID');
            document.getElementById('discountPercent').value = '';
            document.getElementById('discountHargaHasil').value = '';
            document.getElementById('discountForm').action = `/staff_produk/batch/diskon/${batchId}`;
        }

        function openHargaModal(batchId, hargaNormal, hargaSaatIni) {
            document.getElementById('hargaHargaNormal').value = 'Rp ' + hargaNormal.toLocaleString('id-ID');
            document.getElementById('hargaBaru').value = hargaSaatIni;
            document.getElementById('hargaForm').action = `/staff_produk/batch/naik/${batchId}`;
        }

        // Event listener untuk diskon
        document.addEventListener('DOMContentLoaded', function() {
            const discountPercent = document.getElementById('discountPercent');
            if (discountPercent) {
                discountPercent.addEventListener('input', function() {
                    const hargaNormalText = document.getElementById('discountHargaNormal').value;
                    const hargaNormal = parseInt(hargaNormalText.replace(/[^\d]/g, '')) || 0;
                    const percent = parseFloat(this.value) || 0;
                    if (percent >= 0 && percent <= 100 && hargaNormal > 0) {
                        const hargaHasil = hargaNormal - (hargaNormal * percent / 100);
                        document.getElementById('discountHargaHasil').value = 'Rp ' + Math.round(hargaHasil).toLocaleString('id-ID');
                    } else {
                        document.getElementById('discountHargaHasil').value = '';
                    }
                });
            }

            // Initialize toasts if they exist
            @if (session('success'))
                var successToastEl = document.getElementById('successToast');
                var successToast = new bootstrap.Toast(successToastEl);
                successToast.show();
            @endif

            @if (session('error'))
                var errorToastEl = document.getElementById('errorToast');
                var errorToast = new bootstrap.Toast(errorToastEl);
                errorToast.show();
            @endif
        });


        function deleteBatch() {
            const id = document.getElementById('deleteBatchId').value;
            window.location.href = `/staff_produk/batch/delete/${id}`;
        }

        // FIX: Tambahkan fungsi ini agar id_batch bisa diset saat modal dibuka
        function setRusakBatch(id) {
            document.getElementById('rusakBatchId').value = id;
        }

        document.addEventListener('DOMContentLoaded', colorizeBadges);
        </script>

        <script>
        let estimasiHari = {{ $produk->estimasi_kadaluwarsa_hari ?? 0 }};
        estimasiHari = Math.max(1, estimasiHari);
        let isAutoMode = true;

        document.addEventListener('DOMContentLoaded', function() {
            const tglMasukInput = document.getElementById('tgl_masuk_add');
            const tglKadaluarsaInput = document.getElementById('tgl_kadaluarsa_add');

            if (!tglMasukInput || !tglKadaluarsaInput) {
                return;
            }

            function updateKadaluarsa() {
                if (!isAutoMode) {
                    return;
                }

                const masukStr = tglMasukInput.value;
                if (!masukStr) {
                    tglKadaluarsaInput.value = '';
                    return;
                }

                const masukDate = new Date(masukStr);
                const kadaluarsaDate = new Date(masukDate);
                kadaluarsaDate.setDate(masukDate.getDate() + estimasiHari);

                const year = kadaluarsaDate.getFullYear();
                const month = String(kadaluarsaDate.getMonth() + 1).padStart(2, '0');
                const day = String(kadaluarsaDate.getDate()).padStart(2, '0');
                tglKadaluarsaInput.value = `${year}-${month}-${day}`;
            }

            tglMasukInput.addEventListener('change', updateKadaluarsa);
            tglKadaluarsaInput.addEventListener('change', function() {
                if (this.value === '') {
                    isAutoMode = true;
                    updateKadaluarsa();
                } else {
                    isAutoMode = false;
                }
            });

            updateKadaluarsa();
        });


        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        @endsection
    </body>
</html>
