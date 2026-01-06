@extends('Components.staff_produk')
@section('content')
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
        .search-wrapper .form-control, .search-wrapper .input-group-text { border: none; box-shadow: none !important; }
        .input-group-text { cursor: pointer; }
        .btn-add { background: var(--green-primary); color: var(--white); border: none; border-radius: .5rem; padding: .55rem 1.1rem; font-weight: 500; font-size: .9rem; box-shadow: 0 3px 6px var(--shadow); transition: all .3s ease; }
        .btn-add:hover { background: var(--green-text); }
        .form-select { font-size: .9rem; color: var(--text-dark); border-color: #ced4da; box-shadow: none !important; }
        .table-card { background: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); overflow: hidden; }
        .table th { background: var(--green-soft); color: var(--green-text); font-weight: 600; font-size: .85rem; text-transform: uppercase; }
        .table td { vertical-align: middle; font-size: .9rem; }
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
        .pagination .page-link { color: #198754; }
        .pagination .page-item.active .page-link { background-color: #198754; border-color: #198754; color: #fff; }
        .filters-vertical { flex-direction: column !important; align-items: stretch !important; gap: 1rem !important; }
        .filters-vertical .form-select, .filters-vertical .search-wrapper { width: 100% !important; max-width: 300px; }
        @media (min-width: 768px) {
            .filters-vertical { flex-direction: row !important; align-items: center !important; }
            .filters-vertical .form-select, .filters-vertical .search-wrapper { width: auto !important; max-width: none; }
        }

        /* Fix layout modal: Tambah spacing untuk label dan badge */
        .modal .detail-label {
            display: inline-block;
            margin-right: 0.5rem;
            min-width: 80px;
        }
        .modal .badge-supplier, .modal .badge-kategori {
            position: static !important;
            margin-left: 0.25rem;
            display: inline-block;
            vertical-align: middle;
            top: auto !important;
            right: auto !important;
        }
        .modal p.mb-1 {
            word-break: normal;
            white-space: nowrap;
        }
    </style>
<div class="dashboard-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="dashboard-title"><i class="bi bi-percent"></i> Diskon Produk</h1>
        
        <form action="{{ route('produk.diskon') }}" method="GET" id="search-form" class="d-flex gap-2 flex-wrap align-items-center filters-vertical">
            <!-- Filter Status Tampil -->
            <select name="status_tampil" class="form-select" style="width: 150px;" onchange="this.form.submit()">
                <option value="">Status Tampil</option>
                <option value="Ditampilkan" {{ request('status_tampil') == 'Ditampilkan' ? 'selected' : '' }}>Ditampilkan</option>
                <option value="Diarsipkan" {{ request('status_tampil') == 'Diarsipkan' ? 'selected' : '' }}>Diarsipkan</option>
            </select>
            
            <!-- Filter Kategori -->
            <select name="kategori" class="form-select" style="width: 150px;" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\Kategori::all() as $kat)
                    <option value="{{ $kat->nama_kategori }}" {{ request('kategori') == $kat->nama_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
            
            <!-- Filter Supplier -->
            <select name="supplier" class="form-select" style="width: 150px;" onchange="this.form.submit()">
                <option value="">Semua Supplier</option>
                @foreach(\App\Models\Supplier::all() as $sup)
                    <option value="{{ $sup->nama_supplier }}" {{ request('supplier') == $sup->nama_supplier ? 'selected' : '' }}>{{ $sup->nama_supplier }}</option>
                @endforeach
            </select>

            <!-- Search Input -->
            <div class="input-group search-wrapper" style="width: 300px;">
                <input type="text" name="search" class="form-control" placeholder="Cari ID, nama, deskripsi..." value="{{ request('search') }}">
                <button class="input-group-text border-start-0" type="submit">
                    <i class="bi bi-search text-muted"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Stok Diskon</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produkDiskon as $p)
                        @php
                            $stockStyle = $p->stok == 0 ? 'font-weight: 700; color: #991B1B;' : '';
                            $satuanDisplay = ($p->jumlah_satuan ?? 1) . ' ' . ($p->nama_satuan ?? 'Pcs');
                            $supplierStr = $p->supplier;
                            $kategoriStr = $p->kategori;
                        @endphp
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="img-container">
                                        <img src="{{ $p->gambar }}" alt="{{ $p->nama_produk }}">
                                        <span class="badge-supplier">{{ $supplierStr }}</span>
                                    </div>
                                    <div class="product-info">
                                        <span>{{ $p->nama_produk }}</span>
                                        <small>{{ Str::limit($p->deskripsi, 40) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-kategori">{{ $kategoriStr }}</span></td>
                            <td>{{ $satuanDisplay }}</td>
                            <td style="{{ $stockStyle }}">{{ $p->stok }}</td>
                            <td>
                                <span class="badge-status badge-{{ strtolower(str_replace(' ', '_', $p->status_tampil)) }}">{{ $p->status_tampil }}</span>
                            </td>
                            <td>
                                <button class="btn-action btn-detail" 
                                    data-gambar="{{ $p->gambar }}"
                                    data-nama="{{ $p->nama_produk }}"
                                    data-deskripsi="{{ $p->deskripsi }}"
                                    data-supplier="{{ $supplierStr }}"
                                    data-satuan="{{ $satuanDisplay }}"
                                    data-stok="{{ $p->stok }}"
                                    data-kategori="{{ $kategoriStr }}"
                                    data-jumlah-batch="{{ $p->jumlah_batch }}"
                                    data-status="{{ $p->status_tampil }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a href="{{ route('produk.batch.diskon', $p->id) }}" class="btn-action btn-batch">
                                    <i class="bi bi-layers"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Tidak ada data produk yang sesuai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <nav aria-label="Page navigation example" class="mt-4">
        {{ $produkDiskon->links('pagination::bootstrap-5') }}
    </nav>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Produk</h5>
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
                                <p class="mb-1"><strong><span class="detail-label">Supplier:</span></strong> <span id="detailSupplier" class="badge-supplier"></span></p>
                                <p class="mb-1"><strong><span class="detail-label">Satuan:</span></strong> <span id="detailSatuan"></span></p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><strong><span class="detail-label">Jumlah Stok Diskon:</span></strong> <span id="detailStok" class="fw-bold"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-1"><strong><span class="detail-label">Kategori:</span></strong> <span id="detailKategori" class="badge-kategori"></span></p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><strong><span class="detail-label">Jumlah Batch Diskon:</span></strong> <span id="detailJumlahBatch" class="fw-bold text-primary"></span></p>
                            </div>
                        </div>
                        <hr>
                        <p class="mb-1">
                            <strong><span class="detail-label">Status Tampil:</span></strong> <span id="detailStatusTampil" class="badge-status"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Logic Badge Colors
function colorizeSingle(badgeEl, text) {
    if (!badgeEl || !text) return;
    const colors = [
        { bg: "#BAE6FD", text: "#0369A1" },
        { bg: "#FEF9C3", text: "#A16207" },
        { bg: "#FBCFE8", text: "#9D174D" },
        { bg: "#A7F3D0", text: "#065F46" },
        { bg: "#DDD6FE", text: "#5B21B6" },
        { bg: "#FECACA", text: "#991B1B" },
        { bg: "#FDE68A", text: "#B45309" },
        { bg: "#F5D0FE", text: "#86198F" }
    ];
    let hash = 0;
    for (let i = 0; i < text.length; i++) {
        hash = text.charCodeAt(i) + ((hash << 5) - hash);
    }
    const color = colors[Math.abs(hash) % colors.length];
    badgeEl.style.backgroundColor = color.bg;
    badgeEl.style.color = color.text;
}

function colorizeBadges() {
    document.querySelectorAll('.badge-supplier, .badge-kategori').forEach(badge => {
        const text = badge.textContent.trim().toLowerCase();
        colorizeSingle(badge, text);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    colorizeBadges();

    // Modal Event Listener
    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
    document.querySelectorAll('.btn-detail').forEach(btn => {
        btn.addEventListener('click', function() {
            const d = this.dataset;
            document.getElementById('detailGambar').src = d.gambar;
            document.getElementById('detailNama').textContent = d.nama;
            document.getElementById('detailDeskripsi').textContent = d.deskripsi;
            document.getElementById('detailSupplier').textContent = d.supplier;
            document.getElementById('detailSatuan').textContent = d.satuan;
            document.getElementById('detailStok').textContent = d.stok;
            document.getElementById('detailKategori').textContent = d.kategori;
            document.getElementById('detailJumlahBatch').textContent = d.jumlahBatch;
            
            const statusBadge = document.getElementById('detailStatusTampil');
            statusBadge.textContent = d.status;
            statusBadge.className = `badge-status badge-${d.status.toLowerCase().replace(/ /g,'_')}`;

            detailModal.show();
            setTimeout(() => {
                colorizeSingle(document.getElementById('detailSupplier'), d.supplier);
                colorizeSingle(document.getElementById('detailKategori'), d.kategori);
            }, 50);
        });
    });
});
</script>
@endsection
