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
        .btn-action { border: none; border-radius: .4rem; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: .85rem; margin-right: .25rem; transition: .25s ease; }
        .btn-action:hover { transform: scale(1.1); }
        .btn-detail { background: var(--green-primary); }
        .btn-batch { background: #10B981; }
        .pagination .page-link { color: #198754; }
        .pagination .page-item.active .page-link { background-color: #198754; border-color: #198754; color: #fff; }
        .pagination .page-link:hover { background-color: #157347; color: #fff; border-color: #198754; }

        /* Fix layout modal: Tambah spacing untuk label dan badge */
        .modal .detail-label {
            display: inline-block;
            margin-right: 0.5rem;
            min-width: 80px; /* Pastikan label punya lebar minimal biar align */
        }
        .modal .badge-supplier, .modal .badge-kategori {
            position: static !important; /* Override absolute positioning dari tabel */
            margin-left: 0.25rem;
            display: inline-block;
            vertical-align: middle;
            top: auto !important;
            right: auto !important;
        }
        .modal p.mb-1 {
            word-break: normal;
            white-space: nowrap; /* Hindari wrap aneh di label */
        }
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
            <select id="filter-kategori" class="form-select" style="width: 150px;">
                <option value="all">Semua Kategori</option>
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
                        <th>Stok Diskon</th>
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

<!-- Modal Detail: Pastikan tampil lengkap detail produk -->
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
// Script untuk halaman Diskon Produk - dengan pencarian lengkap
const tableBody = document.querySelector('tbody');
const produkData = @json($produkDiskon);
const perPage = 10; // Sesuaikan dengan paginate di controller (10)
let currentPage = 1;

const filterStatusTampil = document.getElementById('filter-status-tampil');
const filterKategori = document.getElementById('filter-kategori');
const filterSupplier = document.getElementById('filter-supplier');
const searchInput = document.getElementById('search-input');
const searchForm = document.getElementById('search-form');

let filteredData = [...produkData];

// Helper: ambil string dari object (kategori/supplier bisa berupa string atau object)
function getStringValue(obj, fallback = '-') {
    if (typeof obj === 'string') return obj;
    if (obj && typeof obj === 'object') {
        return obj.nama_kategori || obj.nama_supplier || obj.name || obj.nama || obj.toString() || fallback;
    }
    return obj ?? fallback;
}

// Filter + Search utama
function applyFiltersAndSearch() {
    currentPage = 1;
    let dataToProcess = [...produkData];

    const statusTampilVal = filterStatusTampil.value;
    const kategoriVal = filterKategori.value;
    const supplierVal = filterSupplier.value;
    const searchTerm = searchInput.value.toLowerCase().trim();

    dataToProcess = dataToProcess.filter(p => {
        // Filter Status Tampil
        const matchStatusTampil = statusTampilVal === 'all' || p.status_tampil === statusTampilVal;

        // Filter Kategori
        const kategoriStr = getStringValue(p.kategori).toLowerCase();
        const matchKategori = kategoriVal === 'all' || kategoriStr === kategoriVal.toLowerCase();

        // Filter Supplier
        const supplierStr = getStringValue(p.supplier).toLowerCase();
        const matchSupplier = supplierVal === 'all' || supplierStr === supplierVal.toLowerCase();

        // SEARCH LOGIC
        if (searchTerm === '') {
            return matchStatusTampil && matchKategori && matchSupplier;
        }

        const searchNum = parseFloat(searchTerm);
        const isNumberSearch = !isNaN(searchNum);

        const matches = [
            p.id.toString().includes(searchTerm),
            p.nama_produk.toLowerCase().includes(searchTerm),
            p.deskripsi.toLowerCase().includes(searchTerm),
            kategoriStr.includes(searchTerm),
            supplierStr.includes(searchTerm),
            (p.nama_satuan || '').toLowerCase().includes(searchTerm),
            (p.jumlah_satuan || '').toString().includes(searchTerm),
            p.status_tampil.toLowerCase().includes(searchTerm),
            (p.status_stok || '').toLowerCase().includes(searchTerm), // Habis, Menipis, Tersedia
            p.stok.toString().includes(searchTerm), // Stok diskon
        ];

        // Jika pencarian angka, pastikan stok juga dicek (partial match)
        if (isNumberSearch) {
            matches.push(p.stok.toString().includes(searchTerm));
        }

        const matchSearch = matches.some(m => m);

        return matchStatusTampil && matchKategori && matchSupplier && matchSearch;
    });

    filteredData = dataToProcess;
    renderTable(currentPage);
}

// Populate filter kategori
function populateKategoriFilter() {
    const kategoris = [...new Set(produkData.map(p => getStringValue(p.kategori)))]
        .filter(k => k && k !== '-')
        .sort();

    filterKategori.innerHTML = '<option value="all">Semua Kategori</option>';
    kategoris.forEach(kat => {
        const opt = document.createElement('option');
        opt.value = kat;
        opt.textContent = kat;
        filterKategori.appendChild(opt);
    });
}

// Populate filter supplier
function populateSupplierFilter() {
    const suppliers = [...new Set(produkData.map(p => getStringValue(p.supplier)))]
        .filter(s => s && s !== '-')
        .sort();

    filterSupplier.innerHTML = '<option value="all">Semua Supplier</option>';
    suppliers.forEach(sup => {
        const opt = document.createElement('option');
        opt.value = sup;
        opt.textContent = sup;
        filterSupplier.appendChild(opt);
    });
}

// Warna badge kategori & supplier (konsisten)
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

// Render tabel
function renderTable(page = 1) {
    tableBody.innerHTML = '';
    const totalItems = filteredData.length;
    const totalPages = Math.ceil(totalItems / perPage);
    const start = (page - 1) * perPage;
    const end = start + perPage;
    const items = filteredData.slice(start, end);

    if (items.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada data produk yang sesuai dengan kriteria filter/pencarian.</td></tr>`;
        renderPagination(0);
        return;
    }

    items.forEach(p => {
        const stockStyle = p.stok == 0 ? 'font-weight: 700; color: #991B1B;' : '';
        const satuanDisplay = `${p.jumlah_satuan || 1} ${p.nama_satuan || 'Pcs'}`;
        const supplierStr = getStringValue(p.supplier);
        const kategoriStr = getStringValue(p.kategori);

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${p.id}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="img-container">
                        <img src="${p.gambar}" alt="${p.nama_produk}">
                        <span class="badge-supplier">${supplierStr}</span>
                    </div>
                    <div class="product-info">
                        <span>${p.nama_produk}</span>
                        <small>${p.deskripsi.substring(0, 40)}${p.deskripsi.length > 40 ? '...' : ''}</small>
                    </div>
                </div>
            </td>
            <td><span class="badge-kategori">${kategoriStr}</span></td>
            <td>${satuanDisplay}</td>
            <td style="${stockStyle}">${p.stok}</td>
            <td>
                <span class="badge-status badge-${p.status_tampil.toLowerCase().replace(/ /g,'_')}">${p.status_tampil}</span>
            </td>
            <td>
                <button class="btn-action btn-detail" data-id="${p.id}"><i class="bi bi-eye"></i></button>
                <a href="/staff_produk/detail_diskon/${p.id}" class="btn-action btn-batch">
                    <i class="bi bi-layers"></i>
                </a>
            </td>
        `;
        tableBody.appendChild(row);
    });

    colorizeBadges();
    renderPagination(totalPages);
}

// Pagination
function renderPagination(totalPages) {
    const pagination = document.querySelector('.pagination');
    pagination.innerHTML = '';

    if (totalPages <= 1) return;

    // Previous
    const prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>`;
    pagination.appendChild(prevLi);

    // Pages
    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
        pagination.appendChild(li);
    }

    // Next
    const nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>`;
    pagination.appendChild(nextLi);

    // Event klik pagination
    pagination.querySelectorAll('.page-link').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const page = parseInt(e.target.dataset.page);
            if (page && page !== currentPage) {
                currentPage = page;
                renderTable(currentPage);
            }
        });
    });
}

// Modal Detail
let detailModal;
function initModalEvent() {
    if (detailModal) return;
    const modalEl = document.getElementById('detailModal');
    if (!modalEl) return;
    detailModal = new bootstrap.Modal(modalEl);

    tableBody.addEventListener('click', e => {
        const btn = e.target.closest('.btn-detail');
        if (!btn) return;

        const id = btn.dataset.id;
        const produk = produkData.find(p => p.id == id);
        if (!produk) return;

        document.getElementById('detailGambar').src = produk.gambar;
        document.getElementById('detailNama').textContent = produk.nama_produk;
        document.getElementById('detailDeskripsi').textContent = produk.deskripsi;
        document.getElementById('detailSupplier').textContent = getStringValue(produk.supplier);
        document.getElementById('detailSatuan').textContent = `${produk.jumlah_satuan || 1} ${produk.nama_satuan || 'Pcs'}`;
        document.getElementById('detailStok').textContent = produk.stok;
        document.getElementById('detailKategori').textContent = getStringValue(produk.kategori);
        document.getElementById('detailJumlahBatch').textContent = produk.jumlah_batch || 0;
        const statusBadge = document.getElementById('detailStatusTampil');
        statusBadge.textContent = produk.status_tampil;
        statusBadge.className = `badge-status badge-${produk.status_tampil.toLowerCase().replace(/ /g,'_')}`;

        detailModal.show();
        setTimeout(colorizeBadges, 50);
    });
}

// Init saat DOM ready
document.addEventListener('DOMContentLoaded', () => {
    populateKategoriFilter();
    populateSupplierFilter();

    // Event listeners
    filterStatusTampil.addEventListener('change', applyFiltersAndSearch);
    filterKategori.addEventListener('change', applyFiltersAndSearch);
    filterSupplier.addEventListener('change', applyFiltersAndSearch);
    searchForm.addEventListener('submit', e => {
        e.preventDefault();
        applyFiltersAndSearch();
    });
    searchInput.addEventListener('input', applyFiltersAndSearch); // live search optional

    // Render pertama
    applyFiltersAndSearch();

    // Init modal
    setTimeout(initModalEvent, 100);
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
</body>
</html>
