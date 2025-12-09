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

        /* Detail Produk */
        .product-detail-card { background: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); overflow: hidden; margin-bottom: 2rem; }
        .product-detail-header { background: var(--green-soft); padding: 1.5rem; border-bottom: 1px solid var(--border-color); position: relative; }
        .btn-add-top { position: absolute; right: 1.5rem; top: 1.4rem; background: var(--green-primary); color: white; border-radius: .5rem; padding: .45rem .9rem; font-weight: 600; border: none; }
        .btn-add-top:hover { background: var(--green-text); }

        .product-detail-body { padding: 1.5rem; }
        .product-detail-body img { width: 100%; border-radius: .5rem; border: 1px solid var(--border-color); }

        .badge-kategori, .badge-supplier {
            font-size: .8rem; padding: .4rem .7rem; border-radius: .5rem; font-weight: 600;
        }

        /* Batch Header */
        .batch-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: var(--white); padding: 1.5rem 2rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .batch-header h3 { color: #2a522a; margin: 0; display: flex; align-items: center; gap: .5rem; }
        .batch-search {
    width: 500px !important; /* Atau 180px, jangan 10px ya, biar nggak sempit banget */
    max-width: 500px !important;
}

        /* Table - Perbaikan Tampilan */
        .table-card { background: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); overflow: hidden; }
        .table { table-layout: fixed; } /* Fixed layout untuk distribusi kolom merata */
        .table th, .table td { font-size: .8rem; padding: .5rem .25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; } /* Compact padding, ellipsis untuk overflow */
        .table th { background: var(--green-soft); color: var(--green-text); font-weight: 600; font-size: .75rem; text-transform: uppercase; border-bottom: 2px solid var(--border-color); }
        .table td { vertical-align: middle; border-top: 1px solid var(--border-color); color: var(--text-dark); }
        .table tbody tr:hover { background-color: #F3F4F6; }
        .harga-normal { font-weight: 600; color: var(--text-dark); font-size: .8rem; }
        /* Kolom spesifik width */
        .col-batch { width: 8%; }
        .col-tgl-masuk { width: 10%; }
        .col-tgl-exp { width: 10%; }
        .col-sisa-hari { width: 8%; text-align: center; }
        .col-harga-normal { width: 9%; }
        .col-harga-saat { width: 9%; }
        .col-tgl-perubahan { width: 10%; }
        .col-ket-harga { width: 12%; } /* Lebih lebar untuk keterangan, tapi ellipsis */
        .col-stok { width: 6%; text-align: center; }
        .col-status-stok { width: 8%; }
        .col-aksi { width: 10%; position: relative; } /* Tambah relative untuk dropdown */

        .btn-table-action { border: none; border-radius: .4rem; padding: .35rem .7rem; font-size: .85rem; font-weight: 500; transition: all .3s ease; margin-right: .25rem; white-space: nowrap; }
        .btn-table-warning { background: #F59E0B; color: white; }
        .btn-table-warning:hover { background: #d97706; }
        .btn-table-primary { background: var(--green-primary); color: white; }
        .btn-table-primary:hover { background: var(--green-text); }
        .btn-table-danger { background: #EF4444; color: white; }
        .btn-table-danger:hover { background: #dc2626; }

        .dropdown-menu { min-width: 140px; z-index: 1070 !important; position: absolute; } /* Naikkan z-index lebih tinggi, absolute untuk positioning */
        .dropdown-item { padding: .5rem .75rem; font-size: .85rem; }
        .dropdown-item:hover { background-color: #f8f9fa; }
        .dropdown-divider { margin: 0; }

        /* Status Badges */
        .badge-status { padding: .25rem .6rem; font-size: .7rem; border-radius: 1rem; font-weight: 600; display: inline-block; margin-right: .25rem; line-height: 1.5; }
        .badge-tersedia { background: #DBEAFE; color: #1E40AF; }
        .badge-menipis { background: #FEF3C7; color: #92400E; }
        .badge-habis { background: #FEE2E2; color: #991B1B; }

        /* Prettier Badges for Harga Keterangan - Compact */
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

        /* Modal Rusak */
        .modal-rusak .form-control { border-radius: .5rem; }
        .modal-rusak .form-label { font-weight: 600; }
        .modal-rusak input[type="file"] { border: 1px solid var(--border-color); border-radius: .5rem; padding: .5rem; }

        /* Fix dropdown di table-responsive */
        .table-responsive { overflow: visible; } /* Ubah overflow agar dropdown bisa keluar */
        .col-aksi .dropdown-menu { margin-top: 0; } /* Hilangkan margin atas */

        @media (max-width: 768px) {
            .batch-header { flex-direction: column; gap: 1rem; text-align: center; }
            .batch-search {
                width: 100% !important;
            }
            .table th, .table td { font-size: .75rem; padding: .4rem .2rem; }
            .dropdown-menu { min-width: 100px; }
            .badge-harga-normal, .badge-harga-diskon, .badge-harga-naik { max-width: 80px; font-size: .6rem; }
            .product-detail-body .row { flex-direction: column; }
        }
    </style>
</head>
<body>
@extends('Components.staff_produk')
@section('content')

<div class="dashboard-container">

    <!-- DETAIL PRODUK -->
    <div class="product-detail-card">
        <div class="product-detail-header">
            <h4 class="dashboard-title"><i class="bi bi-box-seam"></i> Detail Produk</h4>
            <button class="btn btn-add-top" data-bs-toggle="modal" data-bs-target="#addBatchModal">
                <i class="bi bi-plus-circle"></i> Tambah Batch
            </button>
        </div>

        <div class="product-detail-body">
            <div class="row align-items-start">
                <div class="col-md-4">
                    <img src="{{ $produk['gambar'] }}" alt="Produk">
                </div>
                <div class="col-md-8">
                    <h4 class="fw-bold">{{ $produk['nama_produk'] }}</h4>
                    <p class="text-muted">{{ $produk['deskripsi'] }}</p>

                    <div class="row mt-3">
                        <div class="col-6">
                            <p><strong>Supplier:</strong> <span class="badge-supplier">{{ $produk['supplier'] }}</span></p>
                            <p><strong>Kategori:</strong> <span class="badge-kategori">{{ $produk['kategori'] }}</span></p>
                            <p><strong>Satuan:</strong> {{ $produk['satuan_berat'] }}</p>
                        </div>
                        <div class="col-6">
                            <p><strong>Total Stok:</strong> <span class="fw-bold">{{ $produk['stok'] }}</span></p>
                            <p><strong>Status:</strong>
                                <span class="badge-status badge-{{ strtolower(str_replace(' ', '-', $produk['status_tampil'])) }}">{{ $produk['status_tampil'] }}</span>
                                <span class="badge-status badge-{{ strtolower(str_replace([' ', '_'], '-', $produk['status_stok'])) }}">{{ $produk['status_stok'] }}</span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- LIST BATCH -->
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
            <table class="table align-middle table-sm" id="batchTable"> <!-- Tambah table-sm untuk compact -->
                <thead>
                    <tr>
                        <th class="col-batch">Batch</th>
                        <th class="col-tgl-masuk">Tgl. Masuk</th> <!-- Singkatkan header -->
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
                        @php
                            $masuk = \Carbon\Carbon::createFromFormat('Y-m-d', $batch['tanggal_masuk']);
                            $exp = \Carbon\Carbon::createFromFormat('Y-m-d', $batch['tanggal_kadaluarsa']);
                            $now = \Carbon\Carbon::now()->startOfDay();
                            $sisaHariRaw = $exp->startOfDay()->diffInDays($now, false);
                            $sisaHari = $sisaHariRaw;
                            if ($sisaHari > 0) {
                                $sisaHari += 1; // Inclusive untuk "hari lagi"
                            }
                            if (abs($sisaHariRaw) > 1000) {
                                $sisaText = 'Invalid';
                                $textColor = 'text-danger';
                            } else {
                                if ($sisaHariRaw < 0) {
                                    $sisaText = abs($sisaHariRaw) . ' lalu';
                                    $textColor = 'text-danger';
                                } elseif ($sisaHariRaw <= 7) {
                                    $sisaText = $sisaHari . ' lagi';
                                    $textColor = 'text-warning';
                                } else {
                                    $sisaText = $sisaHari . ' lagi';
                                    $textColor = 'text-success';
                                }
                            }

                            $normal_num = (int)str_replace(['Rp ', '.'], '', $batch['harga_normal']);
                            $saat_ini_num = (int)str_replace(['Rp ', '.'], '', $batch['harga_saat_ini']);
                            $is_diskon = $saat_ini_num < $normal_num && $batch['diskon'] > 0;
                            $is_naik = $saat_ini_num > $normal_num;
                            $keterangan = $is_diskon ? 'Diskon ' . $batch['diskon'] . '%' : ($is_naik ? 'Naik ' . round((($saat_ini_num - $normal_num) / $normal_num) * 100) . '%' : 'Normal'); // Singkatkan teks

                            $statusStok = $batch['jumlah'] == 0 ? 'Habis' : ($batch['jumlah'] <= 10 ? 'Menipis' : 'Tersedia');
                            $badgeStok = $batch['jumlah'] == 0 ? 'badge-habis' : ($batch['jumlah'] <= 10 ? 'badge-menipis' : 'badge-tersedia');
                        @endphp
                        <tr>
                            <td class="col-batch">Batch {{ $batch['id'] }}</td>
                            <td class="col-tgl-masuk">{{ $masuk->format('d/m/Y') }}</td>
                            <td class="col-tgl-exp">{{ $exp->format('d/m/Y') }}</td>
                            <td class="col-sisa-hari fw-bold {{ $textColor }}">{{ $sisaText }}</td>
                            <td class="col-harga-normal {{ $is_diskon ? 'text-decoration-line-through text-muted' : '' }}">{{ $batch['harga_normal'] }}</td>
                            <td class="col-harga-saat fw-bold {{ $is_diskon ? 'text-success' : ($is_naik ? 'text-danger' : '') }}">{{ $batch['harga_saat_ini'] }}</td>
                            <td class="col-tgl-perubahan">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $batch['tanggal_perubahan_harga'])->format('d/m/Y') }}</td>
                            <td class="col-ket-harga" title="{{ $keterangan }}"> <!-- Tooltip untuk full teks -->
                                @if($is_diskon)
                                    <span class="badge-harga-diskon">{{ $keterangan }}</span>
                                @elseif($is_naik)
                                    <span class="badge-harga-naik">{{ $keterangan }}</span>
                                @else
                                    <span class="badge-harga-normal">{{ $keterangan }}</span>
                                @endif
                            </td>
                            <td class="col-stok">{{ $batch['jumlah'] }}</td>
                            <td class="col-status-stok"><span class="badge-status {{ $badgeStok }}">{{ $statusStok }}</span></td>
                            <td class="col-aksi">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $batch['id'] }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $batch['id'] }}">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#discountModal"><i class="bi bi-percent"></i> Kasih Diskon</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#hargaModal"><i class="bi bi-arrow-up"></i> Naikkan Harga</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#rusakModal"><i class="bi bi-exclamation-triangle"></i> Produk Rusak</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editBatchModal" onclick="editBatch({{ $batch['id'] }}, '{{ $batch['tanggal_masuk'] }}', '{{ $batch['tanggal_kadaluarsa'] }}', {{ $batch['jumlah'] }}, '{{ $batch['harga_normal'] }}', '{{ $batch['harga_saat_ini'] }}')"><i class="bi bi-pencil"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete({{ $batch['id'] }})"><i class="bi bi-trash"></i> Hapus</a></li>
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

    <!-- Pagination -->
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

<!-- MODAL TAMBAH BATCH -->
<div class="modal fade" id="addBatchModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Batch Baru</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="addBatchForm">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Stok</label>
                        <input type="number" min="1" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Normal (Rp)</label>
                        <input type="number" min="0" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Saat Ini (Rp)</label>
                        <input type="number" min="0" class="form-control">
                    </div>

                    <button class="btn btn-success w-100">Tambah Batch</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- MODAL EDIT BATCH -->
<div class="modal fade" id="editBatchModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title">Edit Batch</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="editBatchForm">
                    <input type="hidden" id="editBatchId" name="id">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="editTanggalMasuk" name="tanggal_masuk">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" class="form-control" id="editTanggalKadaluarsa" name="tanggal_kadaluarsa">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Stok</label>
                        <input type="number" min="1" class="form-control" id="editJumlah" name="jumlah">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Normal (Rp)</label>
                        <input type="number" min="0" class="form-control" id="editHargaNormal" name="harga_normal">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Saat Ini (Rp)</label>
                        <input type="number" min="0" class="form-control" id="editHargaSaatIni" name="harga_saat_ini">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Batch</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- MODAL HAPUS BATCH -->
<div class="modal fade" id="deleteBatchModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Batch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus batch ini? Tindakan ini tidak dapat dibatalkan.</p>
                <input type="hidden" id="deleteBatchId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="deleteBatch()">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Diskon -->
<div class="modal fade" id="discountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terapkan Diskon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="discountForm">
                    <div class="mb-3">
                        <label class="form-label">Diskon % untuk Seluruh Batch</label>
                        <input type="number" class="form-control" min="0" max="100">
                    </div>
                    <button type="submit" class="btn btn-warning">Terapkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Naikkan Harga -->
<div class="modal fade" id="hargaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Naikkan Harga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="hargaForm">
                    <div class="mb-3">
                        <label class="form-label">Harga Baru (Rp)</label>
                        <input type="number" class="form-control" min="0">
                    </div>
                    <button type="submit" class="btn btn-primary">Terapkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Laporkan Rusak -->
<div class="modal fade modal-rusak" id="rusakModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Laporkan Produk Rusak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="rusakForm" action="/produk_rusak" method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label">Jumlah Rusak</label>
                        <input type="number" name="jumlah_rusak" class="form-control" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Ditemukan Rusak</label>
                        <input type="date" name="tanggal_rusak" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tingkat Kerusakan</label>
                        <select class="form-select" name="tingkat_kerusakan" required>
                            <option value="" selected disabled>Pilih tingkat kerusakan</option>
                            <option value="Ringan">Ringan</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Berat">Berat</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bukti Foto</label>
                        <input type="file" name="bukti_foto" class="form-control" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-danger w-100">Kirim Laporan</button>
                </form>
            </div>

        </div>
    </div>
</div>


<script>
function editBatch(id, tanggalMasuk, tanggalKadaluarsa, jumlah, hargaNormal, hargaSaatIni) {
    document.getElementById('editBatchId').value = id;
    document.getElementById('editTanggalMasuk').value = tanggalMasuk;
    document.getElementById('editTanggalKadaluarsa').value = tanggalKadaluarsa;
    document.getElementById('editJumlah').value = jumlah;
    document.getElementById('editHargaNormal').value = hargaNormal.replace('Rp ', '').replace('.', '');
    document.getElementById('editHargaSaatIni').value = hargaSaatIni.replace('Rp ', '').replace('.', '');
}

function confirmDelete(id) {
    document.getElementById('deleteBatchId').value = id;
    new bootstrap.Modal(document.getElementById('deleteBatchModal')).show();
}

function deleteBatch() {
    const id = document.getElementById('deleteBatchId').value;
    alert(`Batch ${id} dihapus! (Simulasi)`);
    bootstrap.Modal.getInstance(document.getElementById('deleteBatchModal')).hide();
    location.reload(); // Reload to simulate deletion
}

// Existing scripts for forms (simulasi)
document.addEventListener('DOMContentLoaded', function() {
    // Add Batch Form
    document.getElementById('addBatchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Batch ditambahkan! (Simulasi)');
        bootstrap.Modal.getInstance(document.getElementById('addBatchModal')).hide();
        location.reload();
    });

    // Edit Batch Form
    document.getElementById('editBatchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Batch diupdate! (Simulasi)');
        bootstrap.Modal.getInstance(document.getElementById('editBatchModal')).hide();
        location.reload();
    });

    // Discount Form
    document.getElementById('discountForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Diskon diterapkan! (Simulasi)');
        bootstrap.Modal.getInstance(document.getElementById('discountModal')).hide();
    });

    // Harga Form
    document.getElementById('hargaForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Harga diupdate! (Simulasi)');
        bootstrap.Modal.getInstance(document.getElementById('hargaModal')).hide();
    });

    // Rusak Form
    document.getElementById('rusakForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Laporan rusak dikirim! (Simulasi)');
        bootstrap.Modal.getInstance(document.getElementById('rusakModal')).hide();
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
</body>
</html>
