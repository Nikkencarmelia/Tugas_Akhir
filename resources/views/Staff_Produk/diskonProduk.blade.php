<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Diskon Produk</title>
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
        .pagination .page-link { color: #198754; }
        .pagination .page-item.active .page-link { background-color: #198754; border-color: #198754; color: #fff; }
        .pagination .page-link:hover { background-color: #157347; color: #fff; border-color: #198754; }
    </style>
</head>
<body>
@extends('Components.staff_produk')
@section('content')
<div class="dashboard-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="dashboard-title"><i class="bi bi-percent"></i> Diskon Produk</h1>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <select id="filter-status-tampil" class="form-select" style="width: 150px;">
                <option value="all">Status Tampil</option>
                <option value="Ditampilkan">Ditampilkan</option>
                <option value="Diarsipkan">Diarsipkan</option>
            </select>
            <select id="filter-status-stok" class="form-select" style="width: 150px;">
                <option value="all">Status Stok</option>
                <option value="Tersedia">Tersedia</option>
                <option value="Menipis">Menipis</option>
                <option value="Habis">Habis</option>
            </select>
            <select id="filter-supplier" class="form-select" style="width: 150px;">
                <option value="all">Semua Supplier</option>
            </select>
            <form id="search-form" class="d-flex" role="search" style="width: 300px;">
                <div class="input-group search-wrapper w-100">
                    <input type="text" id="search-input" class="form-control" placeholder="Cari ID, nama, deskripsi..." aria-label="Search">
                    <button class="input-group-text border-start-0" type="submit">
                        <i class="bi bi-search text-muted"></i>
                    </button>
                </div>
            </form>
            <!-- Tombol Tambah Produk dihapus -->
        </div>
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
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center mt-3"></ul>
    </nav>
</div>

<!-- Modal Detail tetap sama -->
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
                                <p class="mb-1"><strong>Supplier:</strong> <span id="detailSupplier" class="badge-status"></span></p>
                                <p class="mb-1"><strong>Satuan:</strong> <span id="detailSatuan"></span></p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><strong>Total Stok:</strong> <span id="detailStok" class="fw-bold"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-1"><strong>Kategori:</strong> <span id="detailKategori" class="badge-kategori"></span></p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><strong>Jumlah Batch:</strong> <span id="detailJumlahBatch" class="fw-bold text-primary"></span></p>
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
// Script tetap sama, hanya bagian renderTable yang diubah
const tableBody = document.querySelector('tbody');
const produkData = @json($produk);
const perPage = 5;
let currentPage = 1;
const filterStatusTampil = document.getElementById('filter-status-tampil');
const filterStatusStok = document.getElementById('filter-status-stok');
const filterSupplier = document.getElementById('filter-supplier');
const searchInput = document.getElementById('search-input');
const searchForm = document.getElementById('search-form');
let filteredData = [...produkData];

function applyFiltersAndSearch() {
    currentPage = 1;
    let dataToProcess = [...produkData];
    const statusTampilVal = filterStatusTampil.value;
    const statusStokVal = filterStatusStok.value;
    const supplierVal = filterSupplier.value;
    const searchTerm = searchInput.value.toLowerCase().trim();

    dataToProcess = dataToProcess.filter(p => {
        const matchStatusTampil = statusTampilVal === 'all' || p.status_tampil === statusTampilVal;
        const matchStatusStok = statusStokVal === 'all' || p.status_stok.toLowerCase() === statusStokVal.toLowerCase();
        const matchSupplier = supplierVal === 'all' || p.supplier === supplierVal;
        const matchSearch = p.id.toString().includes(searchTerm) ||
                            p.nama_produk.toLowerCase().includes(searchTerm) ||
                            p.deskripsi.toLowerCase().includes(searchTerm);
        return matchStatusTampil && matchStatusStok && matchSupplier && matchSearch;
    });
    filteredData = dataToProcess;
    renderTable(currentPage);
}

function populateSupplierFilter() {
    const suppliers = [...new Set(produkData.map(p => p.supplier))].sort();
    filterSupplier.innerHTML = '<option value="all">Semua Supplier</option>';
    suppliers.forEach(supplier => {
        if (supplier) {
            const option = document.createElement('option');
            option.value = supplier;
            option.textContent = supplier;
            filterSupplier.appendChild(option);
        }
    });
}

function colorizeSingle(badgeEl, text) {
    if (!badgeEl || !text) return;
    const colorPairs = [
        { bg: "#BAE6FD", text: "#0369A1" }, { bg: "#FEF9C3", text: "#A16207" },
        { bg: "#FBCFE8", text: "#9D174D" }, { bg: "#A7F3D0", text: "#065F46" },
        { bg: "#DDD6FE", text: "#5B21B6" }, { bg: "#FECACA", text: "#991B1B" },
        { bg: "#FDE68A", text: "#B45309" }, { bg: "#F5D0FE", text: "#86198F" }
    ];
    let hash = 0;
    for (let i = 0; i < text.length; i++) {
        hash = text.charCodeAt(i) + ((hash << 5) - hash);
    }
    const color = colorPairs[Math.abs(hash) % colorPairs.length];
    badgeEl.style.backgroundColor = color.bg;
    badgeEl.style.color = color.text;
}

function colorizeBadges() {
    document.querySelectorAll('.badge-supplier, .badge-kategori').forEach(badge => {
        const text = badge.textContent.trim().toLowerCase();
        colorizeSingle(badge, text);
    });
}

function renderTable(page = 1) {
    tableBody.innerHTML = '';
    const totalItems = filteredData.length;
    const totalPages = Math.ceil(totalItems / perPage);
    const start = (page - 1) * perPage;
    const end = start + perPage;
    const items = filteredData.slice(start, end);

    if (items.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada data produk yang sesuai dengan kriteria filter/pencarian.</td></tr>`;
        renderPagination(totalPages);
        return;
    }

    items.forEach(p => {
        const statusStokClass = p.status_stok.toLowerCase().replace(/_/g,'-').replace(/ /g,'-');
        const stockStyle = p.stok == 0 ? 'font-weight: 700; color: #991B1B;' : '';

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${p.id}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="img-container">
                        <img src="${p.gambar}" alt="${p.nama_produk}">
                        <span class="badge-supplier">${p.supplier}</span>
                    </div>
                    <div class="product-info">
                        <span>${p.nama_produk}</span>
                        <small>${p.deskripsi.substring(0, 40)}${p.deskripsi.length > 40 ? '...' : ''}</small>
                    </div>
                </div>
            </td>
            <td><span class="badge-kategori">${p.kategori}</span></td>
            <td>${p.satuan_berat}</td>
            <td style="${stockStyle}">${p.stok}</td>
            <td>
                <span class="badge-status badge-${p.status_tampil.toLowerCase().replace(/ /g,'_')}">${p.status_tampil}</span>
                <span class="badge-status badge-${statusStokClass}">${p.status_stok}</span>
            </td>
            <td>
                <button class="btn-action btn-detail" data-id="${p.id}"><i class="bi bi-eye"></i></button>
                <a href="/detail_diskon" class="btn-action btn-batch"><i class="bi bi-layers"></i></a>
            </td>
        `;
        tableBody.appendChild(row);
    });

    colorizeBadges();
    renderPagination(totalPages);
}

// Pagination & event listeners tetap sama
function renderPagination(totalPages) { /* ... sama seperti sebelumnya ... */ }
// (copy-paste fungsi renderPagination dari kode awal kamu)

document.addEventListener('DOMContentLoaded', function() {
    populateSupplierFilter();
    filterStatusTampil.addEventListener('change', applyFiltersAndSearch);
    filterStatusStok.addEventListener('change', applyFiltersAndSearch);
    filterSupplier.addEventListener('change', applyFiltersAndSearch);
    searchForm.addEventListener('submit', e => { e.preventDefault(); applyFiltersAndSearch(); });
    applyFiltersAndSearch();
});

// Event detail & delete modal tetap sama
tableBody.addEventListener('click', function(e){
    // Detail dan Delete tetap seperti kode asli
    // (bisa copy dari kode lama kamu)
});

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
</body>
</html>
