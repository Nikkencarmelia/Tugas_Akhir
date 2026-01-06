<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Arsip Produk</title>
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
        .dashboard-title { font-size: 1.6rem; font-weight: 700; color: var(--text-dark); display: flex; align-items: center; gap: .5rem; }
        .dashboard-title i { color: #808080; }
        .search-wrapper { border: 1px solid #ced4da; border-radius: 0.375rem; transition: all 0.2s ease; }
        .search-wrapper:focus-within { border-color: #6B7280; box-shadow: 0 0 0 0.25rem rgba(107, 114, 128, .25); }
        .search-wrapper .form-control, .search-wrapper .input-group-text { border: none; box-shadow: none !important; }
        .input-group-text { cursor: pointer; }
        .form-select { font-size: .9rem; color: var(--text-dark); border-color: #ced4da; box-shadow: none !important; }
        .table-card { background: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); overflow: hidden; }
        .table th { background: #F3F4F6; color: var(--text-muted); font-weight: 600; font-size: .85rem; text-transform: uppercase; }
        .table td { vertical-align: middle; font-size: .9rem; }
        .table tbody tr:hover { background-color: #F8F8F8; }
        .img-container { position: relative; width: 75px; height: 75px; }
        .img-container img { width: 75px; height: 75px; border-radius: .5rem; object-fit: cover; border: 1px solid var(--border-color); }
        .badge-supplier { position: absolute; top: 5px; right: 5px; font-size: .7rem; font-weight: 600; padding: .3rem .55rem; border-radius: .4rem; line-height: 1; }
        .badge-kategori { font-size: .7rem; font-weight: 600; padding: .3rem .55rem; border-radius: .4rem; line-height: 1; display: inline-block; }
        .product-info { margin-left: .75rem; }
        .product-info span { font-weight: 600; font-size: .95rem; color: var(--text-dark); }
        .product-info small { color: var(--text-muted); display: block; font-size: .8rem; }
        .badge-status { padding: .3rem .9rem; border-radius: 1rem; font-size: .75rem; font-weight: 600; display: inline-block; margin-right: .25rem; line-height: 1.5; }
        .badge-diarsipkan { background: #E5E7EB; color: #374151; }
        .badge-tersedia { background: #DBEAFE; color: #1E40AF; }
        .badge-menipis { background: #FEF3C7; color: #92400E; }
        .badge-habis { background: #FEE2E2; color: #991B1B; }
        .btn-action { border: none; border-radius: .4rem; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: .85rem; margin-right: .25rem; transition: .25s ease; text-decoration: none; }
        .btn-action:hover { transform: scale(1.1); }
        .btn-detail { background: var(--green-primary); }
        .btn-batch { background: #10B981; }
        .action-bar { margin-top: 1rem; padding: 1rem; background-color: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); display: flex; justify-content: space-between; align-items: center; }
        .btn-restore-selected { background-color: var(--green-primary); color: var(--white); font-weight: 600; }
        .btn-restore-selected:hover { background-color: var(--green-text); }
        .btn-restore-all { background-color: #3B82F6; color: var(--white); font-weight: 600; }
        .btn-restore-all:hover { background-color: #2563EB; }
        .pagination .page-link { color: #6B7280; }
        .pagination .page-item.active .page-link { background-color: #6B7280; border-color: #6B7280; color: #fff; }
        .pagination .page-link:hover { background-color: #4B5563; color: #fff; border-color: #6B7280; }
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
        <h1 class="dashboard-title"><i class="bi bi-archive-fill"></i> Arsip Produk</h1>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <p class="mb-0 fw-bold text-muted d-flex align-items-center me-2">
                Status Tampil: <span class="badge-status badge-diarsipkan ms-2">Diarsipkan</span>
            </p>
            <div class="d-flex gap-2 flex-wrap align-items-center filters-vertical">
                <select id="filter-supplier" class="form-select" style="width: 150px;">
                    <option value="all">Semua Supplier</option>
                </select>
                <select id="filter-kategori" class="form-select" style="width: 150px;">
                    <option value="all">Semua Kategori</option>
                </select>
                <div class="input-group search-wrapper" style="width: 300px;">
                    <input type="text" id="search-input" class="form-control" placeholder="Cari ID, nama, deskripsi, satuan...">
                    <button class="input-group-text border-start-0" type="button">
                        <i class="bi bi-search text-muted"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <p class="text-muted mb-4">Produk yang tercantum di sini tidak ditampilkan di halaman utama. Gunakan <strong>tombol Tampilkan Arsip</strong> untuk mengembalikannya.</p>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" id="check-all-products"></th>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Diisi oleh JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="action-bar">
        <div id="selection-status" class="text-muted fw-bold">0 Produk dipilih</div>
        <div class="d-flex gap-3">
            <button id="btn-restore-selected" class="btn btn-restore-selected" disabled>
                <i class="bi bi-arrow-clockwise"></i> Tampilkan yang Dipilih
            </button>
            <button id="btn-restore-all" class="btn btn-restore-all">
                <i class="bi bi-upload"></i> Tampilkan Semua Arsip (<span id="total-arsip">0</span>)
            </button>
        </div>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center mt-3"></ul>
    </nav>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        <div id="restoreToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="restoreToastMessage">
                    Produk berhasil ditampilkan kembali!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="errorToastMessage">
                    Terjadi kesalahan!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
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
                                <p class="mb-1"><strong>Supplier:</strong> <span id="detailSupplier" class="badge-kategori"></span></p>
                                <p class="mb-1"><strong>Satuan:</strong> <span id="detailSatuan"></span></p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><strong>Kategori:</strong> <span id="detailKategori" class="badge-kategori"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-1"><strong>Jumlah Batch:</strong> <span id="detailJumlahBatch" class="fw-bold text-primary"></span></p>
                            </div>
                        </div>
                        <hr>
                        <p class="mb-1"><strong>Status Tampil:</strong> <span class="badge-status badge-diarsipkan">Diarsipkan</span></p>
                        <p class="mb-1"><strong>Status Stok:</strong> <span id="detailStatusStok" class="badge-status"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage">Apakah Anda yakin?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="confirmYes">Ya, Tampilkan</button>
            </div>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const batchUrl = "{{ route('produk.batch.index', ':id') }}";
    const restoreSingleUrl = "{{ url('arsip-produk/restore') }}/";
    const restoreSelectedUrl = "{{ url('arsip-produk/restore-selected') }}";
    const restoreAllUrl = "{{ url('arsip-produk/restore-all') }}";

    const produkData = @json($produkAll);
    const perPage = 10;
    let currentPage = 1;
    let filteredData = [...produkData];

    const tableBody = document.querySelector('tbody');
    const pagination = document.querySelector('.pagination');
    const filterSupplier = document.getElementById('filter-supplier');
    const filterKategori = document.getElementById('filter-kategori');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.querySelector('.input-group-text');
    const checkAll = document.getElementById('check-all-products');
    const btnRestoreSelected = document.getElementById('btn-restore-selected');
    const btnRestoreAll = document.getElementById('btn-restore-all');
    const selectionStatus = document.getElementById('selection-status');
    const totalArsipSpan = document.getElementById('total-arsip');

    let selectedProductIds = new Set();
    let confirmModalInstance = null;
    let confirmCallback = null;

    function getStringValue(obj, fallback = '-') {
        if (typeof obj === 'string') return obj;
        if (obj && typeof obj === 'object') {
            return obj.nama_kategori || obj.nama_supplier || obj.nama_satuan || obj.name || obj.nama || fallback;
        }
        return fallback;
    }

    function populateFilters() {
        const suppliers = [...new Set(produkData.map(p => getStringValue(p.supplier)))].filter(s => s !== '-').sort();
        filterSupplier.innerHTML = '<option value="all">Semua Supplier</option>';
        suppliers.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s;
            opt.textContent = s;
            filterSupplier.appendChild(opt);
        });

        const kategoris = [...new Set(produkData.map(p => getStringValue(p.kategori)))].filter(k => k !== '-').sort();
        filterKategori.innerHTML = '<option value="all">Semua Kategori</option>';
        kategoris.forEach(k => {
            const opt = document.createElement('option');
            opt.value = k;
            opt.textContent = k;
            filterKategori.appendChild(opt);
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

        const supplierVal = filterSupplier.value.toLowerCase();
        const kategoriVal = filterKategori.value.toLowerCase();
        const searchTerm = searchInput.value.toLowerCase().trim();

        data = data.filter(p => {
            const supplierStr = getStringValue(p.supplier).toLowerCase();
            const kategoriStr = getStringValue(p.kategori).toLowerCase();
            const satuanLengkap = `${p.jumlah_satuan || 1} ${getStringValue(p.satuan).toLowerCase()}`;
            const totalStok = p.batch ? p.batch.reduce((sum, b) => sum + (b.stok || 0), 0) : 0;
            const stokStatus = totalStok > 10 ? 'Tersedia' : totalStok > 0 ? 'Menipis' : 'Habis';

            const matchSupplier = supplierVal === 'all' || supplierStr === supplierVal;
            const matchKategori = kategoriVal === 'all' || kategoriStr === kategoriVal;

            if (!searchTerm) return matchSupplier && matchKategori;

            const matches = [
                p.id.toString().includes(searchTerm),
                p.nama_produk.toLowerCase().includes(searchTerm),
                (p.deskripsi || '').toLowerCase().includes(searchTerm),
                supplierStr.includes(searchTerm),
                kategoriStr.includes(searchTerm),
                getStringValue(p.satuan).toLowerCase().includes(searchTerm),
                (p.jumlah_satuan || '').toString().includes(searchTerm),
                satuanLengkap.includes(searchTerm),
                stokStatus.toLowerCase().includes(searchTerm),
                totalStok.toString().includes(searchTerm)
            ];

            return matchSupplier && matchKategori && matches.some(m => m);
        });

        filteredData = data;
        renderTable();
    }

    function renderTable() {
        tableBody.innerHTML = '';
        selectedProductIds.clear();

        const start = (currentPage - 1) * perPage;
        const end = start + perPage;
        const items = filteredData.slice(start, end);

        if (items.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada produk arsip yang sesuai dengan filter.</td></tr>`;
            pagination.innerHTML = '';
            updateActionBar();
            return;
        }

        items.forEach(p => {
            const supplierStr = getStringValue(p.supplier);
            const kategoriStr = getStringValue(p.kategori);
            const satuanDisplay = `${p.jumlah_satuan || 1} ${getStringValue(p.satuan)}`;

            // FIX: Dynamic href untuk batch dengan ?from= + query current
            const baseBatchUrl = batchUrl.replace(':id', p.id);
            let batchHref = baseBatchUrl + '?from=produk.arsip';  // Tambah from=route_name (sesuain 'produk.arsip')
            const currentQuery = new URLSearchParams(window.location.search).toString();
            if (currentQuery) {
                batchHref += '&' + currentQuery;
            }

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="text-center"><input type="checkbox" class="product-checkbox" data-id="${p.id}"></td>
                <td>${p.id}</td>
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
                <td>
                    <button class="btn-action btn-detail" data-id="${p.id}"><i class="bi bi-eye"></i></button>
                    <a href="${batchHref}" class="btn-action btn-batch"><i class="bi bi-layers"></i></a>  <!-- Ganti href ke dynamic -->
                    <button class="btn btn-sm btn-outline-success btn-pulihkan" data-id="${p.id}" data-name="${p.nama_produk.replace(/"/g, '&quot;')}">
                        <i class="bi bi-upload"></i> Tampilkan Arsip
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        colorizeBadges();
        renderPagination(Math.ceil(filteredData.length / perPage));
        updateActionBar();
        syncCheckAll();
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

    function updateActionBar() {
        const count = selectedProductIds.size;
        selectionStatus.textContent = `${count} Produk dipilih`;
        btnRestoreSelected.disabled = count === 0;
        totalArsipSpan.textContent = filteredData.length;
    }

    function syncCheckAll() {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        const checked = Array.from(checkboxes).filter(cb => cb.checked);
        checkAll.checked = checked.length === checkboxes.length && checkboxes.length > 0;
    }

    async function restoreAction(url, data = null) {
        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: data ? JSON.stringify(data) : null
            });
            const json = await res.json();

            if (json.success) {
                document.getElementById('restoreToastMessage').textContent = json.message;
                const toast = new bootstrap.Toast(document.getElementById('restoreToast'));
                toast.show();

                if (data && data.ids) {
                    filteredData = filteredData.filter(p => !data.ids.includes(p.id));
                    selectedProductIds.clear();
                } else if (url === restoreAllUrl) {
                    filteredData = [];
                    selectedProductIds.clear();
                } else {
                    const id = parseInt(url.split('/').pop());
                    filteredData = filteredData.filter(p => p.id !== id);
                    selectedProductIds.delete(id);
                }

                renderTable();
            } else {
                document.getElementById('errorToastMessage').textContent = json.message || 'Gagal memulihkan produk.';
                const toast = new bootstrap.Toast(document.getElementById('errorToast'));
                toast.show();
            }
        } catch (err) {
            document.getElementById('errorToastMessage').textContent = 'Gagal terhubung ke server.';
            const toast = new bootstrap.Toast(document.getElementById('errorToast'));
            toast.show();
        }
    }

    function confirmAction(message, callback) {
        document.getElementById('confirmMessage').textContent = message;
        confirmCallback = callback;

        if (!confirmModalInstance) {
            confirmModalInstance = new bootstrap.Modal(document.getElementById('confirmModal'));
        }
        confirmModalInstance.show();
    }

    document.getElementById('confirmYes').addEventListener('click', () => {
        if (confirmCallback) {
            confirmCallback();
        }
        if (confirmModalInstance) {
            confirmModalInstance.hide();
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        populateFilters();

        filterSupplier.addEventListener('change', applyFiltersAndSearch);
        filterKategori.addEventListener('change', applyFiltersAndSearch);
        searchInput.addEventListener('input', applyFiltersAndSearch);
        searchButton.addEventListener('click', applyFiltersAndSearch);

        checkAll.addEventListener('change', () => {
            const checked = checkAll.checked;
            document.querySelectorAll('.product-checkbox').forEach(cb => {
                cb.checked = checked;
                const id = parseInt(cb.dataset.id);
                if (checked) selectedProductIds.add(id);
                else selectedProductIds.delete(id);
            });
            updateActionBar();
        });

        tableBody.addEventListener('change', e => {
            if (e.target.classList.contains('product-checkbox')) {
                const id = parseInt(e.target.dataset.id);
                if (e.target.checked) selectedProductIds.add(id);
                else selectedProductIds.delete(id);
                updateActionBar();
                syncCheckAll();
            }
        });

        tableBody.addEventListener('click', e => {
            const btn = e.target.closest('.btn-detail');
            if (btn) {
                const id = btn.dataset.id;
                const p = produkData.find(x => x.id == id);
                if (!p) return;

                document.getElementById('detailGambar').src = '{{ asset('storage') }}/' + p.gambar;
                document.getElementById('detailNama').textContent = p.nama_produk;
                document.getElementById('detailDeskripsi').textContent = p.deskripsi || '-';

                const supplierBadge = document.getElementById('detailSupplier');
                supplierBadge.textContent = getStringValue(p.supplier);
                colorizeSingle(supplierBadge, getStringValue(p.supplier).toLowerCase());

                document.getElementById('detailSatuan').textContent = `${p.jumlah_satuan || 1} ${getStringValue(p.satuan)}`;

                const kategoriBadge = document.getElementById('detailKategori');
                kategoriBadge.textContent = getStringValue(p.kategori);
                colorizeSingle(kategoriBadge, getStringValue(p.kategori).toLowerCase());

                document.getElementById('detailJumlahBatch').textContent = p.batch ? p.batch.length : 0;

                const totalStok = p.batch ? p.batch.reduce((s, b) => s + (b.stok || 0), 0) : 0;
                const stokStatus = totalStok > 10 ? 'Tersedia' : totalStok > 0 ? 'Menipis' : 'Habis';
                document.getElementById('detailStatusStok').textContent = stokStatus;
                document.getElementById('detailStatusStok').className = `badge-status badge-${stokStatus.toLowerCase()}`;

                new bootstrap.Modal(document.getElementById('detailModal')).show();
                setTimeout(colorizeBadges, 50);
            }

            const restoreBtn = e.target.closest('.btn-pulihkan');
            if (restoreBtn) {
                const id = restoreBtn.dataset.id;
                const name = restoreBtn.dataset.name;
                confirmAction(`Pulihkan produk "${name}" ke status Ditampilkan?`, () => {
                    restoreAction(restoreSingleUrl + id);
                });
            }
        });

        btnRestoreSelected.onclick = () => {
            if (selectedProductIds.size === 0) return;
            confirmAction(`Tampilkan ${selectedProductIds.size} produk terpilih?`, () => {
                restoreAction(restoreSelectedUrl, { ids: Array.from(selectedProductIds) });
            });
        };

        btnRestoreAll.onclick = () => {
            const total = filteredData.length;
            if (total === 0) return;
            confirmAction(`Tampilkan SEMUA ${total} produk arsip?`, () => {
                restoreAction(restoreAllUrl);
            });
        };

        applyFiltersAndSearch();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
</body>
</html>
