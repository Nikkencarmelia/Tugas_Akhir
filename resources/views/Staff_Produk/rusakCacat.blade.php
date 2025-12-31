<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produk Rusak/Cacat</title>
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
        .search-wrapper { border: 1px solid #ced4da; border-radius: 0.375rem; transition: all 0.2s ease; }
        .search-wrapper:focus-within { border-color: #198754; box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, .25); }
        .search-wrapper .form-control, .search-wrapper .input-group-text { border: none; box-shadow: none !important; background-color: var(--bs-body-bg); }
        .input-group-text { cursor: pointer; transition: all 0.2s ease; }
        .form-select { font-size: .9rem; color: var(--text-dark); border-color: #ced4da; box-shadow: none !important; }
        .table-card { background: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); overflow: hidden; }
        .table th { background: var(--green-soft); color: var(--green-text); font-weight: 600; font-size: .85rem; text-transform: uppercase; border-bottom: 2px solid var(--border-color); }
        .table td { vertical-align: middle; font-size: .9rem; border-top: 1px solid var(--border-color); color: var(--text-dark); }
        .table tbody tr:hover { background-color: #F3F4F6; }
        .img-container { position: relative; width: 75px; height: 75px; }
        .img-container img { width: 75px; height: 75px; border-radius: .5rem; object-fit: cover; border: 1px solid var(--border-color); }
        .badge-supplier { position: absolute; top: 5px; right: 5px; font-size: .7rem; font-weight: 600; padding: .3rem .55rem; border-radius: .4rem; line-height: 1; }
        .badge-kategori { font-size: .7rem; font-weight: 600; padding: .3rem .55rem; border-radius: .4rem; line-height: 1; display: inline-block; }
        .product-info { margin-left: .75rem; }
        .product-info span { font-weight: 600; font-size: .95rem; color: var(--text-dark); }
        .product-info small { color: var(--text-muted); display: block; font-size: .8rem; }
        .badge-status { padding: .3rem .9rem; border-radius: 1rem; font-size: .75rem; font-weight: 600; display: inline-block; margin-right: .25rem; line-height: 1.5; }
        .badge-ditampilkan { background: #DCFCE7; color: #166534; }
        .badge-diarsipkan { background: #E5E7EB; color: #374151; }
        .badge-draft { background: #F3E8FF; color: #7E22CE; }
        .badge-tersedia { background: #DBEAFE; color: #1E40AF; }
        .badge-menipis { background: #FEF3C7; color: #92400E; }
        .badge-habis { background: #FEE2E2; color: #991B1B; }
        .btn-action { border: none; border-radius: .4rem; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: .85rem; margin-right: .25rem; transition: .25s ease; }
        .btn-action:hover { transform: scale(1.1); }
        .btn-detail { background: var(--green-primary); }
        .btn-batch { background: #10B981; }
        .badge-total-rusak { background: #FEE2E2; color: #991B1B; font-weight: 600; padding: .25rem .5rem; border-radius: .5rem; font-size: .8rem; }
        .pagination .page-link { color: #198754; }
        .pagination .page-item.active .page-link { background-color: #198754; border-color: #198754; color: #fff; }
        .pagination .page-link:hover { background-color: #157347; color: #fff; border-color: #198754; }
        .filters-vertical { flex-direction: column !important; align-items: stretch !important; gap: 1rem !important; }
        .filters-vertical .form-select, .filters-vertical .search-wrapper { width: 100% !important; max-width: 300px; }
        @media (min-width: 768px) { .filters-vertical { flex-direction: row !important; align-items: center !important; } .filters-vertical .form-select, .filters-vertical .search-wrapper { width: auto !important; max-width: none; } }
    </style>
</head>
<body>
    @extends('Components.staff_produk')
    @section('content')
        <div class="dashboard-container">
            <form method="GET" action="{{ route('produk.rusak_cacat.index') }}" id="filter-form">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h1 class="dashboard-title">
                        <i class="bi bi-exclamation-triangle"></i> Produk Rusak/Cacat
                    </h1>
                    <div class="d-flex gap-2 flex-wrap align-items-center filters-vertical">
                        <select id="filter-status-tampil" name="status_tampil" class="form-select" style="width: 150px;" onchange="document.getElementById('filter-form').submit()">
                            <option value="all">Status Tampil</option>
                            <option value="Ditampilkan" {{ request('status_tampil') == 'Ditampilkan' ? 'selected' : '' }}>Ditampilkan</option>
                            <option value="Diarsipkan" {{ request('status_tampil') == 'Diarsipkan' ? 'selected' : '' }}>Diarsipkan</option>
                        </select>
                        <select id="filter-status-stok" name="status_stok" class="form-select" style="width: 150px;" onchange="document.getElementById('filter-form').submit()">
                            <option value="all">Status Stok</option>
                            <option value="Tersedia" {{ request('status_stok') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Menipis" {{ request('status_stok') == 'Menipis' ? 'selected' : '' }}>Menipis</option>
                            <option value="Habis" {{ request('status_stok') == 'Habis' ? 'selected' : '' }}>Habis</option>
                        </select>
                        <select id="filter-supplier" name="supplier" class="form-select" style="width:150px" onchange="document.getElementById('filter-form').submit()">
                            <option value="all">Semua Supplier</option>
                            @foreach ($supplier as $sp)
                                <option value="{{ $sp->id }}" {{ request('supplier') == $sp->id ? 'selected' : '' }}>
                                    {{ $sp->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                        <div class="input-group search-wrapper" style="width: 300px;">
                            <input type="text" id="search-input" name="search" class="form-control" placeholder="Cari ID, nama, deskripsi..." aria-label="Search" value="{{ request('search') }}">
                            <button class="input-group-text border-start-0" type="submit">
                                <i class="bi bi-search text-muted"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th>Harga Normal</th>
                                <th>Total Rusak</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($produk->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="bi bi-exclamation-triangle" style="font-size:2rem;"></i>
                                        <p class="mt-2 mb-0">Tidak ada data produk rusak/cacat yang ditemukan.</p>
                                    </td>
                                </tr>
                            @else
                                @foreach($produk as $p)
                                    @php
                                        $statusStokClass = strtolower(str_replace(['_', ' '], '-', $p->status_stok ?? 'tersedia'));
                                        $statusTampilClass = strtolower(str_replace([' ', '_'], '_', $p->status_tampil ?? 'draft'));
                                        $totalRusak = $p->rusak->first()?->total_rusak ?? 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $p->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="img-container">
                                                    <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_produk }}">
                                                    <span class="badge-supplier">{{ $p->supplier->nama_supplier ?? 'N/A' }}</span>
                                                </div>
                                                <div class="product-info">
                                                    <span>{{ $p->nama_produk }}</span>
                                                    <small>{{ Str::limit($p->deskripsi ?? 'Tidak ada deskripsi.', 40) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge-kategori">{{ $p->kategori->nama_kategori ?? '-' }}</span></td>
                                        <td>{{ $p->satuan_berat ?? ($p->jumlah_satuan . ' ' . ($p->satuan->nama_satuan ?? '-')) }}</td>
                                        <td>Rp {{ number_format($p->harga ?? 0, 0, ',', '.') }}</td>
                                        <td><span class="badge-total-rusak">{{ $totalRusak }} unit</span></td>
                                        <td>
                                            <span class="badge-status badge-{{ $statusTampilClass }}">{{ $p->status_tampil }}</span>
                                            <span class="badge-status badge-{{ $statusStokClass }}">{{ $p->status_stok }}</span>
                                        </td>
                                        <td>
                                            <button class="btn-action btn-detail" data-id="{{ $p->id }}" data-bs-toggle="modal" data-bs-target="#detailModal" data-produk='{{ json_encode($p) }}'>
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <a href="{{ route('produk.rusak_cacat.show', $p->id) }}" class="btn-action btn-batch">
                                                <i class="bi bi-layers"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <nav aria-label="Page navigation example">
                <div class="d-flex justify-content-center mt-3">
                    {{ $produk->appends(request()->query())->links() }}
                </div>
            </nav>
        </div>

        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Produk Rusak/Cacat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img id="detailGambar" src="" class="img-fluid rounded" alt="Produk" style="max-height: 300px; object-fit: cover; width: 100%;">
                            </div>
                            <div class="col-md-8">
                                <h4 id="detailNama" class="mb-3"></h4>
                                <p id="detailDeskripsi" class="text-muted"></p>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="mb-1"><strong>Supplier:</strong> <span id="detailSupplier" class="badge-kategori"></span></p>
                                        <p class="mb-1"><strong>Satuan:</strong> <span id="detailSatuan"></span></p>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-1"><strong>Kategori:</strong> <span id="detailKategori" class="badge-kategori"></span></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="mb-1"><strong>Total Rusak:</strong> <span id="detailTotalRusak" class="fw-bold text-danger"></span></p>
                                    </div>
                                </div>
                                <hr>
                                <p class="mb-1">
                                    <strong>Status Tampil:</strong> <span id="detailStatusTampil" class="badge-status"></span>
                                </p>
                                <p>
                                    <strong>Status Stok:</strong> <span id="detailStatusStok" class="badge-status"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
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
            const detailModal=document.getElementById('detailModal');
            detailModal.addEventListener('show.bs.modal',function(event){
                const button=event.relatedTarget;
                const produkData=JSON.parse(button.getAttribute('data-produk'));
                document.getElementById('detailGambar').src=produkData.gambar ? `/storage/${produkData.gambar}` : '';
                document.getElementById('detailNama').textContent=produkData.nama_produk ?? '-';
                document.getElementById('detailDeskripsi').textContent=produkData.deskripsi ?? '-';
                const supplierEl = document.getElementById('detailSupplier');
                supplierEl.textContent = produkData.supplier?.nama_supplier ?? 'Tidak ada';
                colorizeSingle(supplierEl, (produkData.supplier?.nama_supplier ?? '').toLowerCase());
                document.getElementById('detailSatuan').textContent = produkData.satuan_berat ?? '-';
                const kategoriEl=document.getElementById('detailKategori');
                kategoriEl.textContent=produkData.kategori?.nama_kategori ?? '-';
                if(produkData.kategori?.nama_kategori){ colorizeSingle(kategoriEl, produkData.kategori.nama_kategori.toLowerCase()); }
                document.getElementById('detailTotalRusak').textContent=(produkData.total_rusak || 0) + ' unit';
                const statusTampilEl=document.getElementById('detailStatusTampil');
                statusTampilEl.textContent=produkData.status_tampil ?? '-';
                statusTampilEl.className='badge-status badge-'+(produkData.status_tampil ?? '').toLowerCase().replace(/ /g,'_');
                const statusStokEl=document.getElementById('detailStatusStok');
                statusStokEl.textContent=produkData.status_stok ?? '-';
                statusStokEl.className='badge-status badge-'+(produkData.status_stok ?? '').toLowerCase().replace(/_| /g,'-');
            });
            document.addEventListener('DOMContentLoaded',colorizeBadges);
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
</body>
</html>
