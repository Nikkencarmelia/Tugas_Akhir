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
        .search-wrapper .form-control, .search-wrapper .input-group-text { border: none; box-shadow: none !important; }
        .input-group-text { cursor: pointer; }
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
        .badge-total-rusak { background: #FEE2E2; color: #991B1B; font-weight: 600; padding: .25rem .5rem; border-radius: .5rem; font-size: .8rem; }
        .btn-action { border: none; border-radius: .4rem; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: .85rem; margin-right: .25rem; transition: .25s ease; }
        .btn-action:hover { transform: scale(1.1); }
        .btn-batch { background: #10B981; }
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
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="dashboard-title"><i class="bi bi-exclamation-triangle"></i> Produk Rusak/Cacat</h1>
        <div class="d-flex gap-2 flex-wrap align-items-center filters-vertical">
            <select id="filter-kategori" class="form-select" style="width: 150px;">
                <option value="all">Semua Kategori</option>
            </select>
            <select id="filter-supplier" class="form-select" style="width: 150px;">
                <option value="all">Semua Supplier</option>
            </select>
            <div class="input-group search-wrapper" style="width: 300px;">
                <input type="text" id="search-input" class="form-control" placeholder="Cari Kode Produk, nama, deskripsi, satuan...">
                <button class="input-group-text border-start-0" type="button">
                    <i class="bi bi-search text-muted"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Kode Produk</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Total Rusak</th>
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
    const detailUrl = "{{ route('produk.rusak_cacat.show', ':id') }}";

    const produkData = @json($produkAll);
    const perPage = 10;
    let currentPage = 1;
    let filteredData = [...produkData];

    const tableBody = document.querySelector('tbody');
    const pagination = document.querySelector('.pagination');
    const filterKategori = document.getElementById('filter-kategori');
    const filterSupplier = document.getElementById('filter-supplier');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.querySelector('.input-group-text');

    function getStringValue(obj, fallback = '-') {
        if (typeof obj === 'string') return obj;
        if (obj && typeof obj === 'object') {
            return obj.nama_kategori || obj.nama_supplier || obj.nama_satuan || obj.name || obj.nama || fallback;
        }
        return fallback;
    }

    function populateFilters() {
        const kategoris = [...new Set(produkData.map(p => getStringValue(p.kategori)))].filter(k => k !== '-').sort();
        filterKategori.innerHTML = '<option value="all">Semua Kategori</option>';
        kategoris.forEach(k => {
            const opt = document.createElement('option');
            opt.value = k;
            opt.textContent = k;
            filterKategori.appendChild(opt);
        });

        const suppliers = [...new Set(produkData.map(p => getStringValue(p.supplier)))].filter(s => s !== '-').sort();
        filterSupplier.innerHTML = '<option value="all">Semua Supplier</option>';
        suppliers.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s;
            opt.textContent = s;
            filterSupplier.appendChild(opt);
        });
    }

    function colorizeSingle(badgeEl, text) {
        if (!badgeEl || !text) return;
        const colors = [
            { bg: "#BAE6FD", text: "#0369A1" }, { bg: "#FEF9C3", text: "#A16207" },
            { bg: "#FBCFE8", text: "#9D174D" }, { bg: "#A7F3D0", text: "#065F46" },
            { bg: "#DDD6FE", text: "#5B21B6" }, { bg: "#FECACA", text: "#991B1B" },
            { bg: "#FDE68A", text: "#B45309" }, { bg: "#F5D0FE", text: "#86198F" }
        ];
        let hash = 0;
        for (let i = 0; i < text.length; i++) hash = text.charCodeAt(i) + ((hash << 5) - hash);
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

    function applyFiltersAndSearch() {
        currentPage = 1;
        let data = [...produkData];

        const kategoriVal = filterKategori.value.toLowerCase();
        const supplierVal = filterSupplier.value.toLowerCase();
        const searchTerm = searchInput.value.toLowerCase().trim();

        data = data.filter(p => {
            const kategoriStr = getStringValue(p.kategori).toLowerCase();
            const supplierStr = getStringValue(p.supplier).toLowerCase();
            const satuanLengkap = `${p.jumlah_satuan || 1} ${getStringValue(p.satuan).toLowerCase()}`;
            const totalRusak = p.rusak && p.rusak[0] ? p.rusak[0].total_rusak : 0;

            const matchKategori = kategoriVal === 'all' || kategoriStr === kategoriVal;
            const matchSupplier = supplierVal === 'all' || supplierStr === supplierVal;

            if (!searchTerm) return matchKategori && matchSupplier;

            const matches = [
                (p.kode_produk || '').toLowerCase().includes(searchTerm),
                p.id.toString().includes(searchTerm),
                p.nama_produk.toLowerCase().includes(searchTerm),
                (p.deskripsi || '').toLowerCase().includes(searchTerm),
                kategoriStr.includes(searchTerm),
                supplierStr.includes(searchTerm),
                getStringValue(p.satuan).toLowerCase().includes(searchTerm),
                (p.jumlah_satuan || '').toString().includes(searchTerm),
                satuanLengkap.includes(searchTerm),
                totalRusak.toString().includes(searchTerm)
            ];

            return matchKategori && matchSupplier && matches.some(m => m);
        });

        filteredData = data;
        renderTable();
    }

    function renderTable() {
        tableBody.innerHTML = '';
        const start = (currentPage - 1) * perPage;
        const end = start + perPage;
        const items = filteredData.slice(start, end);

        if (items.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted">
                <i class="bi bi-exclamation-triangle" style="font-size:2rem;"></i>
                <p class="mt-2 mb-0">Tidak ada data produk rusak/cacat yang ditemukan.</p>
            </td></tr>`;
            pagination.innerHTML = '';
            return;
        }

        items.forEach(p => {
            const totalRusak = p.rusak && p.rusak[0] ? p.rusak[0].total_rusak : 0;
            const supplierStr = getStringValue(p.supplier);
            const kategoriStr = getStringValue(p.kategori);
            const satuanDisplay = p.satuan_berat ?? `${p.jumlah_satuan || 1} ${getStringValue(p.satuan)}`;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${p.kode_produk || '-'}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="img-container">
                            <img src="{{ asset('storage') }}/${p.gambar}" alt="${p.nama_produk}">
                            <span class="badge-supplier">${supplierStr}</span>
                        </div>
                        <div class="product-info">
                            <span>${p.nama_produk}</span>
                            <small>${(p.deskripsi || '').substring(0,40)}${(p.deskripsi || '').length > 40 ? '...' : ''}</small>
                        </div>
                    </div>
                </td>
                <td><span class="badge-kategori">${kategoriStr}</span></td>
                <td>${satuanDisplay}</td>
                <td><span class="badge-total-rusak">${totalRusak} unit</span></td>
                <td>
                    <a href="${detailUrl.replace(':id', p.id)}" class="btn-action btn-batch">
                        <i class="bi bi-layers"></i>
                    </a>
                </td>
            `;
            tableBody.appendChild(row);
        });

        colorizeBadges();
        renderPagination(Math.ceil(filteredData.length / perPage));
    }

    function renderPagination(totalPages) {
        pagination.innerHTML = '';
        if (totalPages <= 1) return;

        const prev = document.createElement('li');
        prev.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prev.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>`;
        pagination.appendChild(prev);

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === currentPage ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
            pagination.appendChild(li);
        }

        const next = document.createElement('li');
        next.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        next.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>`;
        pagination.appendChild(next);

        pagination.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                const page = parseInt(e.target.dataset.page);
                if (page) {
                    currentPage = page;
                    renderTable();
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        populateFilters();

        filterKategori.addEventListener('change', applyFiltersAndSearch);
        filterSupplier.addEventListener('change', applyFiltersAndSearch);
        searchInput.addEventListener('input', applyFiltersAndSearch);
        searchButton.addEventListener('click', applyFiltersAndSearch);

        applyFiltersAndSearch();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
</body>
</html>
