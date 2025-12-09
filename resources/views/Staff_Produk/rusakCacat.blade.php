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
        /* Styling Search & Filter */
        .search-wrapper { border: 1px solid #ced4da; border-radius: 0.375rem; transition: all 0.2s ease; }
        .search-wrapper:focus-within { border-color: #198754; box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, .25); }
        .search-wrapper .form-control, .search-wrapper .input-group-text { border: none; box-shadow: none !important; background-color: var(--bs-body-bg); }
        .input-group-text { cursor: pointer; transition: all 0.2s ease; }
        .form-select { font-size: .9rem; color: var(--text-dark); border-color: #ced4da; box-shadow: none !important; }
        /* Table Styling */
        .table-card { background: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); overflow: hidden; }
        .table th { background: var(--green-soft); color: var(--green-text); font-weight: 600; font-size: .85rem; text-transform: uppercase; border-bottom: 2px solid var(--border-color); }
        .table td { vertical-align: middle; font-size: .9rem; border-top: 1px solid var(--border-color); color: var(--text-dark); }
        .table tbody tr:hover { background-color: #F3F4F6; }
        /* Product Info */
        .img-container { position: relative; width: 75px; height: 75px; }
        .img-container img { width: 75px; height: 75px; border-radius: .5rem; object-fit: cover; border: 1px solid var(--border-color); }
        .badge-supplier { position: absolute; top: 5px; right: 5px; font-size: .7rem; font-weight: 600; padding: .3rem .55rem; border-radius: .4rem; line-height: 1; }
        .badge-kategori { font-size: .7rem; font-weight: 600; padding: .3rem .55rem; border-radius: .4rem; line-height: 1; display: inline-block; }
        .product-info { margin-left: .75rem; }
        .product-info span { font-weight: 600; font-size: .95rem; color: var(--text-dark); }
        .product-info small { color: var(--text-muted); display: block; font-size: .8rem; }
        /* Status Badges */
        .badge-status { padding: .3rem .9rem; border-radius: 1rem; font-size: .75rem; font-weight: 600; display: inline-block; margin-right: .25rem; line-height: 1.5; }
        .badge-ditampilkan { background: #DCFCE7; color: #166534; }
        .badge-diarsipkan { background: #E5E7EB; color: #374151; }
        .badge-draft { background: #F3E8FF; color: #7E22CE; }
        /* Action Buttons */
        .btn-action { border: none; border-radius: .4rem; padding: .4rem .8rem; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: .85rem; margin-right: .25rem; transition: .25s ease; text-decoration: none; background: #EF4444; }
        .btn-action:hover { transform: scale(1.05); background: #DC2626; }
        .btn-detail-rusak { background: #EF4444; } /* Red for damaged batch detail */
        /* Pagination */
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
        <h1 class="dashboard-title"><i class="bi bi-exclamation-triangle"></i> Produk Rusak/Cacat</h1>
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
                        <th>Harga Normal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center mt-3"></ul>
    </nav>
</div>

<script>
// --- KONFIGURASI DAN DATA ---
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

// --- FUNGSI UTAMA UNTUK FILTER, SEARCH, DAN RENDER ---
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
        const matchSearch = p.id.toString().toLowerCase().includes(searchTerm) ||
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
    const badges = document.querySelectorAll('.badge-supplier, .badge-kategori');
    badges.forEach(badge => {
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
        tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada data produk yang sesuai dengan kriteria filter/pencarian.</td></tr>`;
    }
    items.forEach((p) => {
        const rawHarga = p.harga;
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
            <td>${rawHarga}</td>
            <td>
                <a href="/detail_rusak" class="btn-action btn-detail-rusak">Lihat Detail Produk Rusak/Cacat</a>
            </td>
        `;
        tableBody.appendChild(row);
    });
    colorizeBadges();
    renderPagination(totalPages);
}
function renderPagination(totalPages) {
    const pagination = document.querySelector('.pagination');
    pagination.innerHTML = '';
    const prev = document.createElement('li');
    prev.className = 'page-item' + (currentPage === 1 ? ' disabled' : '');
    prev.innerHTML = `<a class="page-link" href="#" aria-label="Previous">«</a>`;
    prev.addEventListener('click', e => {
        e.preventDefault();
        if(currentPage > 1) {
            currentPage--;
            renderTable(currentPage);
            window.scrollTo(0, 0);
        }
    });
    pagination.appendChild(prev);
    for(let i = 1; i <= totalPages; i++){
        const li = document.createElement('li');
        li.className = 'page-item' + (i === currentPage ? ' active' : '');
        li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        li.addEventListener('click', e => {
            e.preventDefault();
            currentPage = i;
            renderTable(currentPage);
            window.scrollTo(0, 0);
        });
        pagination.appendChild(li);
    }
    const next = document.createElement('li');
    next.className = 'page-item' + (currentPage === totalPages ? ' disabled' : '');
    next.innerHTML = `<a class="page-link" href="#" aria-label="Next">»</a>`;
    next.addEventListener('click', e => {
        e.preventDefault();
        if(currentPage < totalPages) {
            currentPage++;
            renderTable(currentPage);
            window.scrollTo(0, 0);
        }
    });
    pagination.appendChild(next);
}
// --- EVENT LISTENERS ---
document.addEventListener('DOMContentLoaded', function() {
    populateSupplierFilter();
    filterStatusTampil.addEventListener('change', applyFiltersAndSearch);
    filterStatusStok.addEventListener('change', applyFiltersAndSearch);
    filterSupplier.addEventListener('change', applyFiltersAndSearch);
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        applyFiltersAndSearch();
    });
    applyFiltersAndSearch();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
</body>
</html>
