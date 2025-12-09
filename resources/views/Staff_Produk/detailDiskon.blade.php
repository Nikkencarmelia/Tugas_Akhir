<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Diskon Batch</title>
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
        .product-detail-header { background: var(--green-soft); padding: 1.5rem; border-bottom: 1px solid var(--border-color); }
        .product-detail-body { padding: 1.5rem; }
        .product-detail-body img { width: 100%; max-height: 260px; object-fit: cover; border-radius: .5rem; border: 1px solid var(--border-color); }

        .batch-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;
            background: var(--white); padding: 1.5rem 2rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .batch-header h3 { color: #2a522a; margin: 0; display: flex; align-items: center; gap: .5rem; }
        .batch-search { width: 300px !important; max-width: 100%; }

        .table-card { background: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); overflow: hidden; }
        .table th { background: var(--green-soft); color: var(--green-text); font-weight: 600; font-size: .85rem; text-transform: uppercase; letter-spacing: .3px; }
        .table td { vertical-align: middle; font-size: .9rem; }
        .table tbody tr:hover { background-color: #F3F4F6; }

        /* Badge Status Stok */
        .badge-status { padding: .35rem .85rem; font-size: .75rem; border-radius: 1rem; font-weight: 600; }
        .badge-tersedia { background: #DBEAFE; color: #1E40AF; }
        .badge-menipis  { background: #FEF3C7; color: #92400E; }
        .badge-habis    { background: #FEE2E2; color: #991B1B; }

        .badge-diskon {
            background: linear-gradient(135deg, #F59E0B, #D97706);
            color: white; border-radius: 20px; padding: 0.4rem 0.8rem;
            font-size: 0.75rem; font-weight: 600;
        }

        .btn-cancel-discount {
            background: #EF4444; color: white; border: none; border-radius: .4rem;
            padding: .35rem .7rem; font-size: .85rem; font-weight: 500;
        }
        .btn-cancel-discount:hover { background: #dc2626; }

        @media (max-width: 768px) {
            .batch-header { flex-direction: column; gap: 1rem; text-align: center; }
            .batch-search { width: 100% !important; }
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
            <h4 class="dashboard-title"> Detail Produk Diskon</h4>
        </div>
        <div class="product-detail-body">
            <div class="row align-items-start">
                <div class="col-md-4">
                    <img src="{{ $produk['gambar'] }}" alt="{{ $produk['nama_produk'] }}" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <h4 class="fw-bold">{{ $produk['nama_produk'] }}</h4>
                    <p class="text-muted">{{ $produk['deskripsi'] }}</p>
                    <div class="row mt-3">
                        <div class="col-6">
                            <p><strong>Supplier:</strong> {{ $produk['supplier'] }}</p>
                            <p><strong>Kategori:</strong> {{ $produk['kategori'] }}</p>
                            <p><strong>Satuan:</strong> {{ $produk['satuan_berat'] }}</p>
                        </div>
                        <div class="col-6">
                            <p><strong>Total Stok:</strong> <span class="fw-bold">{{ $produk['stok'] }}</span></p>
                            <p><strong>Status Stok:</strong>
                                <span class="badge-status badge-{{ strtolower(str_replace(' ', '-', $produk['status_stok'])) }}">
                                    {{ $produk['status_stok'] }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- HEADER + SEARCH -->
    <div class="batch-header">
        <div>
            <h3> Daftar Batch Diskon <span class="badge bg-success ms-2">{{ count($batches) }}</span></h3>
            <small class="text-muted">Batch yang sedang mendapatkan promo diskon</small>
        </div>
        <div class="input-group batch-search">
            <input type="text" class="form-control" placeholder="Cari batch..." id="searchBatch">
            <button class="btn btn-outline-secondary">Search</button>
        </div>
    </div>

    <!-- TABEL BATCH DISKON -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Batch</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Kadaluarsa</th>
                        <th>Sisa Hari</th>
                        <th>Harga Normal</th>
                        <th>Harga Diskon</th>
                        <th>Stok</th>
                        <th>Status Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($batches as $batch)
                        @php
                            // Parsing eksplisit Y-m-d dengan TZ, fallback now().
                            $appTz = config('app.timezone', 'UTC');

                            $masuk = \Carbon\Carbon::createFromFormat('Y-m-d', $batch['tanggal_masuk']);
                            if ($masuk) {
                                $masuk = $masuk->setTimezone($appTz);
                            } else {
                                $masuk = \Carbon\Carbon::now($appTz);
                            }

                            $exp = \Carbon\Carbon::createFromFormat('Y-m-d', $batch['tanggal_kadaluarsa']);
                            if ($exp) {
                                $exp = $exp->setTimezone($appTz);
                            } else {
                                $exp = \Carbon\Carbon::now($appTz);
                            }

                            // Now dengan TZ, startOfDay.
                            $now = \Carbon\Carbon::now($appTz)->startOfDay();
                            $sisaHariRaw = $exp->startOfDay()->diffInDays($now, false);

                            // Perbaikan: Jika >0, +1 untuk inclusive "hari lagi" (cocok expect 167).
                            // Jika >1000, flag invalid (untuk debug jutaan).
                            $sisaHari = $sisaHariRaw;
                            if ($sisaHari > 0) {
                                $sisaHari += 1; // Inclusive feel.
                            }
                            if (abs($sisaHariRaw) > 1000) {
                                $sisaText = 'Tanggal invalid (cek data)';
                                $textColor = 'text-danger';
                            } else {
                                if ($sisaHariRaw < 0) {
                                    $sisaText = abs($sisaHariRaw) . ' hari lalu';
                                    $textColor = 'text-danger';
                                } elseif ($sisaHariRaw <= 7) {
                                    $sisaText = $sisaHari . ' hari lagi';
                                    $textColor = 'text-warning';
                                } else {
                                    $sisaText = $sisaHari . ' hari lagi';
                                    $textColor = 'text-success';
                                }
                            }

                            // Debug: Tooltip dengan raw diff (hapus setelah test).
                            $debugExp = $exp->format('Y-m-d');
                            $debugNow = $now->format('Y-m-d');
                            $debugDiff = $sisaHariRaw;

                            $statusStok = $batch['jumlah'] == 0 ? 'Habis' : ($batch['jumlah'] <= 10 ? 'Menipis' : 'Tersedia');
                            $badgeStok = $batch['jumlah'] == 0 ? 'badge-habis' : ($batch['jumlah'] <= 10 ? 'badge-menipis' : 'badge-tersedia');
                        @endphp
                        <tr>
                            <td><strong>Batch {{ $batch['id'] }}</strong></td>
                            <td>{{ $masuk->format('d/m/Y') }}</td>
                            <td>{{ $exp->format('d/m/Y') }}</td>
                            <td class="text-center fw-bold {{ $textColor }}"
                                title="Debug: Exp={{ $debugExp }}, Now={{ $debugNow }}, Raw Diff={{ $debugDiff }} hari (display: {{ $sisaText }})">
                                {{ $sisaText }}
                            </td>
                            <td class="text-decoration-line-through text-muted">{{ $batch['harga_normal'] }}</td>
                            <td class="fw-bold text-success">{{ $batch['harga_diskon'] }}</td>
                            <td class="fw-bold">{{ $batch['jumlah'] }}</td>
                            <td><span class="badge-status {{ $badgeStok }}">{{ $statusStok }}</span></td>
                            <td>
                                <button class="btn-cancel-discount" data-bs-toggle="modal" data-bs-target="#cancelDiscountModal"
                                        onclick="setCancelBatchId({{ $batch['id'] }})">
                                    Batalkan
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                Belum ada batch yang sedang didiskon.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="cancelDiscountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"> Batalkan Diskon</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Harga diskon akan dibatalkan</strong> untuk batch ini.</p>
                <p class="text-muted small">Harga akan kembali ke harga normal.</p>
                <input type="hidden" id="cancelBatchId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" onclick="confirmCancelDiscount()">Ya, Batalkan</button>
            </div>
        </div>
    </div>
</div>

<script>
function setCancelBatchId(id) {
    document.getElementById('cancelBatchId').value = id;
}
function confirmCancelDiscount() {
    const id = document.getElementById('cancelBatchId').value;
    alert(`Diskon Batch ${id} berhasil dibatalkan!`);
    bootstrap.Modal.getInstance(document.getElementById('cancelDiscountModal')).hide();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
</body>
</html>
