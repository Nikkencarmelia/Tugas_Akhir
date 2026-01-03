<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Produk Rusak/Cacat</title>
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
        .product-detail-header { background: var(--green-soft); padding: 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; }
        .btn-back { background: transparent; border: none; color: var(--text-muted); font-size: 1.2rem; padding: 0; cursor: pointer; }
        .btn-back:hover { color: var(--text-dark); }

        .product-detail-body { padding: 1.5rem; }
        .product-detail-body img { width: 100%; max-width: 300px; border-radius: .5rem; border: 1px solid var(--border-color); }

        .badge-kategori, .badge-supplier {
            font-size: .8rem; padding: .4rem .7rem; border-radius: .5rem; font-weight: 600;
        }

        /* Batch Header */
        .batch-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: var(--white); padding: 1.5rem 2rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .batch-header h3 { color: #2a522a; margin: 0; display: flex; align-items: center; gap: .5rem; }
        .batch-search {
            width: 500px !important;
            max-width: 500px !important;
        }

        /* Table */
        .table-card { background: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); overflow: hidden; }
        .table th { background: var(--green-soft); color: var(--green-text); font-weight: 600; font-size: .85rem; text-transform: uppercase; border-bottom: 2px solid var(--border-color); }
        .table td { vertical-align: middle; font-size: .9rem; border-top: 1px solid var(--border-color); color: var(--text-dark); }
        .table tbody tr:hover { background-color: #F3F4F6; }
        .harga-normal { font-weight: 600; color: var(--text-dark); }

        .btn-bukti {
            border: none;
            background: #EF4444;
            color: white;
            padding: .25rem .5rem;
            border-radius: .25rem;
            cursor: pointer;
            transition: all .2s ease;
            font-size: .8rem;
        }
        .btn-bukti:hover {
            background: #DC2626;
            transform: scale(1.05);
        }

        /* Status Badges for Tingkat Kerusakan - FIXED: Solid colors without opacity */
        .badge-ringan {
            background-color: #6c757d !important;
            color: #ffffff !important;
            font-weight: 600;
            padding: .3rem .6rem;
            border-radius: .5rem;
        }
        .badge-sedang {
            background-color: #ffc107 !important;
            color: #000000 !important;
            font-weight: 600;
            padding: .3rem .6rem;
            border-radius: .5rem;
        }
        .badge-berat {
            background-color: #dc3545 !important;
            color: #ffffff !important;
            font-weight: 600;
            padding: .3rem .6rem;
            border-radius: .5rem;
        }

        @media (max-width: 768px) {
            .batch-header { flex-direction: column; gap: 1rem; text-align: center; }
            .batch-search { width: 100% !important; }
            .product-detail-body .row { flex-direction: column; }
        }
    </style>
</head>
<body>
    @extends('Components.staff_produk')
    @section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="dashboard-container">

        <!-- DETAIL PRODUK - FIXED: Akses sebagai model Eloquent -->
        <div class="product-detail-card">
            <div class="product-detail-header">
                <!-- FIXED: Add back button -->
                <div class="d-flex align-items-center gap-2">
                    <button class="btn-back" onclick="window.history.back()">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <h4 class="dashboard-title mb-0"><i class="bi bi-box-seam"></i> Detail Produk Rusak/Cacat</h4>
                </div>
            </div>

            <div class="product-detail-body">
                <div class="row align-items-start">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . ($produk->gambar ?? 'default/no_image.jpg')) }}" alt="Produk">
                    </div>
                    <div class="col-md-8">
                        <h4 class="fw-bold">{{ $produk->nama_produk ?? '-' }}</h4>
                        <p class="text-muted">{{ $produk->deskripsi ?? '-' }}</p>

                        <div class="row mt-3">
                            <div class="col-6">
                                <p><strong>Supplier:</strong> <span class="badge-supplier">{{ $produk->supplier->nama_supplier ?? '-' }}</span></p>
                                <p><strong>Kategori:</strong> <span class="badge-kategori">{{ $produk->kategori->nama_kategori ?? '-' }}</span></p>
                                <p><strong>Satuan:</strong> {{ $produk->satuan_berat ?? ($produk->jumlah_satuan . ' ' . ($produk->satuan->nama_satuan ?? '-')) }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- LIST BATCH RUSAK -->
        <div class="batch-header">
            <div>
                <h3><i class="bi bi-exclamation-triangle"></i> Daftar Batch Rusak <span class="badge bg-danger ms-2">{{ $totalDamaged }}</span></h3>
                <small class="text-muted">Riwayat batch produk yang rusak/cacat</small>
            </div>

            <div class="input-group batch-search">
                <input type="text" class="form-control" id="batchSearch" placeholder="Cari batch rusak...">
                <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
            </div>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle" id="batchTable">
                    <thead>
                        <tr>
                            <th>Batch</th>
                            <th>Tanggal Masuk</th>
                            <th>Harga saat ini</th>
                            <th>Jumlah Rusak</th>
                            <th>Keterangan</th>
                            <th>Tanggal Ditemukan Rusak</th>
                            <th>Tingkat Kerusakan</th>
                            <th>Bukti Gambar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($damaged_batches as $batch)
                        <tr>
                            <td>Batch {{ $batch['batch_id'] }}</td>
                            <td>{{ $batch['tanggal_masuk'] }}</td>
                            <td class="harga-normal">{{ $batch['harga_normal'] }}</td>
                            <td>{{ $batch['jumlah_rusak'] ?? 0 }} unit</td>
                            <td>{{ $batch['keterangan'] }}</td>
                            <td>{{ $batch['tanggal_ditemukan'] }}</td> <!-- FIXED: Fallback dari controller -->
                            <td><span class="badge badge-{{ strtolower($batch['tingkat_kerusakan']) }}">{{ $batch['tingkat_kerusakan'] ?? 'Sedang' }}</span></td>
                            <td>
                                <button class="btn-bukti" data-bs-toggle="modal" data-bs-target="#buktiModal{{ $batch['batch_id'] }}">
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada batch rusak untuk produk ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FIXED: Dynamic Pagination -->
        <nav aria-label="Batch pagination" class="mt-4">
            {{ $damaged_batches->appends(request()->query())->links() }}
        </nav>

    </div>

    @forelse($damaged_batches as $batch)
    <!-- Modal Bukti Gambar per Batch - FIXED: Image size not too big -->
    <div class="modal fade" id="buktiModal{{ $batch['batch_id'] }}">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bukti Rusak - Batch {{ $batch['batch_id'] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ $batch['bukti_foto'] ?? asset('images/no_photo.jpg') }}" class="img-fluid rounded" alt="Bukti Rusak" style="max-width: 100%; max-height: 400px; object-fit: contain;">
                    <p class="mt-3 text-muted">{{ $batch['keterangan'] }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @empty
    @endforelse

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // FIXED: JS Search Fungsional
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('batchSearch');
            const tableRows = document.querySelectorAll('#batchTable tbody tr');
            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase();
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });

            // FIXED: Colorize badges for supplier & kategori (same as previous badges)
            function colorizeSingle(badgeEl, text){
                if(!badgeEl || !text) return;
                const colorPairs=[{bg:"#BAE6FD",text:"#0369A1"},{bg:"#FEF9C3",text:"#A16207"},{bg:"#FBCFE8",text:"#9D174D"},{bg:"#A7F3D0",text:"#065F46"},{bg:"#DDD6FE",text:"#5B21B6"},{bg:"#FECACA",text:"#991B1B"},{bg:"#FDE68A",text:"#B45309"},{bg:"#F5D0FE",text:"#86198F"}];
                let hash=0;
                for(let i=0;i<text.length;i++){ hash=text.charCodeAt(i)+((hash<<5)-hash); }
                const color=colorPairs[Math.abs(hash)%colorPairs.length];
                badgeEl.style.backgroundColor=color.bg;
                badgeEl.style.color=color.text;
            }
            function colorizeBadges(){
                document.querySelectorAll('.badge-supplier, .badge-kategori').forEach(badge=>{ const text=badge.textContent.trim(); if(text && text!=='-') colorizeSingle(badge,text.toLowerCase()); });
            }
            colorizeBadges();
        });
    </script>

    @endsection
</body>
</html>
