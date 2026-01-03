{{-- resources/views/Staff_Produk/detailDiskon.blade.php --}}
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
        .product-detail-header { background: var(--green-soft); padding: 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
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
        .badge-menipis { background: #FEF3C7; color: #92400E; }
        .badge-habis { background: #FEE2E2; color: #991B1B; }

        /* Badge Supplier & Kategori (mirip halaman sebelumnya) */
        .badge-supplier, .badge-kategori { font-size: .7rem; font-weight: 600; padding: .3rem .55rem; border-radius: .4rem; line-height: 1; display: inline-block; }

        .badge-diskon {
            background: linear-gradient(135deg, #F59E0B, #D97706);
            color: white; border-radius: 20px; padding: 0.4rem 0.8rem;
            font-size: 0.75rem; font-weight: 600;
        }

        .btn-back { background: transparent; border: none; color: var(--text-muted); font-size: 1.2rem; padding: 0; }
        .btn-back:hover { color: var(--text-dark); }

        .btn-cancel-discount {
            background: #EF4444; color: white; border: none; border-radius: .4rem;
            padding: .35rem .7rem; font-size: .85rem; font-weight: 500;
        }
        .btn-cancel-discount:hover { background: #dc2626; }

        @media (max-width: 768px) {
            .batch-header { flex-direction: column; gap: 1rem; text-align: center; }
            .batch-search { width: 100% !important; }
            .product-detail-header { flex-direction: column; gap: 1rem; text-align: left; }
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
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('produk.diskon') }}" class="btn-back">
                    <i class="bi bi-chevron-left"></i>
                </a>
                <h4 class="dashboard-title mb-0">Detail Produk Diskon</h4>
            </div>
        </div>
        <div class="product-detail-body">
            <div class="row align-items-start">
                <div class="col-md-4">
                    <img src="{{ $produk->gambar }}" alt="{{ $produk->nama_produk }}" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <h4 class="fw-bold">{{ $produk->nama_produk }}</h4>
                    <p class="text-muted">{{ $produk->deskripsi }}</p>
                    <div class="row mt-3">
                        <div class="col-6">
                            <p><strong>Supplier:</strong> <span class="badge-supplier">{{ $produk->supplier }}</span></p>
                            <p><strong>Kategori:</strong> <span class="badge-kategori">{{ $produk->kategori }}</span></p>
                            <p><strong>Satuan:</strong> {{ $produk->jumlah_satuan ?? 1 }} {{ $produk->nama_satuan ?? 'Pcs' }}</p>
                        </div>
                        <div class="col-6">
                            <p><strong>Total Stok:</strong> <span class="fw-bold">{{ $produk->stok }}</span></p>
                            <p><strong>Status Stok:</strong>
                                <span class="badge-status badge-{{ strtolower(str_replace(' ', '-', $produk->status_stok)) }}">
                                    {{ $produk->status_stok }}
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
            <h3> Daftar Batch Diskon <span class="badge bg-success ms-2">{{ $batches->count() }}</span></h3>
            <small class="text-muted">Batch yang sedang mendapatkan promo diskon</small>
        </div>
        <div class="input-group batch-search">
            <input type="text" class="form-control" placeholder="Cari batch..." id="searchBatch">
            <button class="btn btn-outline-secondary" type="button" onclick="applyBatchSearch()">Search</button>
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
                    </tr>
                </thead>
                <tbody id="batchTableBody">
                    @forelse($batches as $batch)
                        <tr>
                            <td><strong>Batch {{ $batch->id }}</strong></td>
                            <td>{{ $batch->tgl_masuk_format }}</td>
                            <td>{{ $batch->tgl_kadaluarsa_format }}</td>
                            <td class="text-center fw-bold {{ $batch->sisa_color }}" title="Debug: Raw Diff={{ $batch->diff ?? 'N/A' }} hari">
                                {{ $batch->sisa_text }}
                            </td>
                            <td class="text-decoration-line-through text-muted">{{ $batch->harga_normal_rp }}</td>
                            <td class="fw-bold text-success">{{ $batch->harga_saat_ini_rp }}</td>
                            <td class="fw-bold">{{ $batch->stok }}</td>
                            <td><span class="badge-status {{ $batch->status_stok_badge }}">{{ $batch->status_stok_text }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                Belum ada batch yang sedang didiskon.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function applyBatchSearch() {
    // Implementasi JS filter jika diperlukan, tapi sementara kosong
    console.log('Search applied');
}

// Colorize badges supplier & kategori (mirip halaman sebelumnya)
function colorizeBadges() {
    const colorPairs = [
        { bg: "#BAE6FD", text: "#0369A1" }, { bg: "#FEF9C3", text: "#A16207" },
        { bg: "#FBCFE8", text: "#9D174D" }, { bg: "#A7F3D0", text: "#065F46" },
        { bg: "#DDD6FE", text: "#5B21B6" }, { bg: "#FECACA", text: "#991B1B" },
        { bg: "#FDE68A", text: "#B45309" }, { bg: "#F5D0FE", text: "#86198F" }
    ];
    function colorizeSingle(badgeEl, text) {
        if (!badgeEl || !text) return;
        let hash = 0;
        for (let i = 0; i < text.length; i++) {
            hash = text.charCodeAt(i) + ((hash << 5) - hash);
        }
        const color = colorPairs[Math.abs(hash) % colorPairs.length];
        badgeEl.style.backgroundColor = color.bg;
        badgeEl.style.color = color.text;
    }
    document.querySelectorAll('.badge-supplier, .badge-kategori').forEach(badge => {
        const text = badge.textContent.trim().toLowerCase();
        colorizeSingle(badge, text);
    });
}
document.addEventListener('DOMContentLoaded', function() {
    colorizeBadges();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
</body>
</html>
