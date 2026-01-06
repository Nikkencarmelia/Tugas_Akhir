<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Produk</title>
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
        .btn-edit { background: #3B82F6; }
        .btn-delete { background: #EF4444; }
        .btn-batch { background: #10B981; }
        .pagination .page-link { color: #198754; }
        .pagination .page-item.active .page-link { background-color: #198754; border-color: #198754; color: #fff; }
        .filters-vertical { flex-direction: column !important; align-items: stretch !important; gap: 1rem !important; }
        .filters-vertical .form-select, .filters-vertical .search-wrapper { width: 100% !important; max-width: 300px; }
        @media (min-width: 768px) {
            .filters-vertical { flex-direction: row !important; align-items: center !important; }
            .filters-vertical .form-select, .filters-vertical .search-wrapper { width: auto !important; max-width: none; }
        }
    </style>
</head>
<body>
@extends('Components.staff_produk')

@section('content')
<div class="dashboard-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="dashboard-title"><i class="bi bi-box-seam"></i> Data Produk</h1>
        <div class="d-flex gap-2 flex-wrap align-items-center filters-vertical">
            <select id="filter-status-tampil" class="form-select" style="width: 150px;">
                <option value="all">Status Tampil</option>
                <option value="Ditampilkan">Ditampilkan</option>
                <option value="Diarsipkan">Diarsipkan</option>
                <option value="Draft">Draft</option>
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
            <div class="input-group search-wrapper" style="width: 300px;">
                <input type="text" id="search-input" class="form-control" placeholder="Cari nama, deskripsi, kategori, supplier, stok...">
                <button class="input-group-text border-start-0" type="button">
                    <i class="bi bi-search text-muted"></i>
                </button>
            </div>
            <a href="{{ route('produk.tambah') }}" class="btn-add">
                <i class="bi bi-plus-circle"></i> Tambah Produk
            </a>
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
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Diisi oleh JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center mt-3"></ul>
    </nav>
</div>

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
    @if (session('success'))
        <div class="toast align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">{{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="toast align-items-center text-white bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">{{ session('error') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif
</div>

<!-- Modal Detail Produk -->
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
                        <p class="mb-1"><strong>Status Tampil:</strong> <span id="detailStatusTampil" class="badge-status"></span></p>
                        <p class="mb-1"><strong>Status Stok:</strong> <span id="detailStatusStok" class="badge-status"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan menghapus produk <strong id="produkNama"></strong> secara permanen. Lanjutkan?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Peringatan Batch -->
<div class="modal fade" id="batchWarningModal" tabindex="-1" aria-labelledby="batchWarningLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="batchWarningLabel">Peringatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda masih memiliki batch. Hapus batch terlebih dahulu sebelum menghapus produk.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const editUrl   = "{{ route('produk.edit', ':id') }}";
    const batchUrl  = "{{ route('produk.batch.index', ':id') }}";
    const deleteUrl = "{{ route('produk.destroy', ':id') }}";

    const produkData = @json($produkAll);
    const perPage = 10;
    let currentPage = 1;
    let filteredData = [...produkData];

    const tableBody = document.querySelector('tbody');
    const pagination = document.querySelector('.pagination');
    const filterStatusTampil = document.getElementById('filter-status-tampil');
    const filterStatusStok = document.getElementById('filter-status-stok');
    const filterSupplier = document.getElementById('filter-supplier');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.querySelector('.input-group-text');

    let deleteModalInstance = null;
    let currentDeleteId = null;

    function showToast(message, type = 'success') {
        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center text-white bg-${type} border-0`;
        toastEl.setAttribute('role', 'alert');
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        document.querySelector('.toast-container').appendChild(toastEl);
        new bootstrap.Toast(toastEl, { delay: 5000 }).show();
    }

    function getStringValue(obj, fallback = '-') {
        if (typeof obj === 'string') return obj;
        if (obj && typeof obj === 'object') {
            return obj.nama_kategori || obj.nama_supplier || obj.nama_satuan || obj.name || obj.nama || fallback;
        }
        return fallback;
    }

    function populateSupplierFilter() {
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

        const statusTampilVal = filterStatusTampil.value;
        const statusStokVal = filterStatusStok.value;
        const supplierVal = filterSupplier.value;
        const searchTerm = searchInput.value.toLowerCase().trim();

        data = data.filter(p => {
            const matchStatusTampil = statusTampilVal === 'all' || (p.status_tampil || 'Draft') === statusTampilVal;

            const totalStok = p.batch ? p.batch.reduce((sum, b) => sum + (b.stok || 0), 0) : 0;
            let stokStatus = totalStok > 10 ? 'Tersedia' : totalStok > 0 ? 'Menipis' : 'Habis';
            const matchStatusStok = statusStokVal === 'all' || stokStatus === statusStokVal;

            const supplierStr = getStringValue(p.supplier).toLowerCase();
            const matchSupplier = supplierVal === 'all' || supplierStr === supplierVal.toLowerCase();

            if (!searchTerm) return matchStatusTampil && matchStatusStok && matchSupplier;

            const satuanLengkap = `${p.jumlah_satuan || 1} ${getStringValue(p.satuan).toLowerCase()}`;
            const matches = [
                (p.kode_produk || '').toLowerCase().includes(searchTerm),
                p.id.toString().includes(searchTerm),
                p.nama_produk.toLowerCase().includes(searchTerm),
                (p.deskripsi || '').toLowerCase().includes(searchTerm),
                getStringValue(p.kategori).toLowerCase().includes(searchTerm),
                supplierStr.includes(searchTerm),
                getStringValue(p.satuan).toLowerCase().includes(searchTerm),
                (p.jumlah_satuan || '').toString().includes(searchTerm),
                satuanLengkap.includes(searchTerm),
                (p.status_tampil || 'draft').toLowerCase().includes(searchTerm),
                stokStatus.toLowerCase().includes(searchTerm),
                totalStok.toString().includes(searchTerm)
            ];

            return matchStatusTampil && matchStatusStok && matchSupplier && matches.some(m => m);
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
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada data produk yang sesuai dengan kriteria filter/pencarian.</td></tr>`;
            pagination.innerHTML = '';
            return;
        }

        items.forEach(p => {
            const totalStok = p.batch ? p.batch.reduce((sum, b) => sum + (b.stok || 0), 0) : 0;
            const stokStatus = totalStok > 10 ? 'Tersedia' : totalStok > 0 ? 'Menipis' : 'Habis';
            const stokClass = stokStatus.toLowerCase();
            const statusTampilClass = (p.status_tampil || 'Draft').toLowerCase().replace(/ /g, '_');
            const supplierStr = getStringValue(p.supplier);
            const kategoriStr = getStringValue(p.kategori);
            const satuanDisplay = `${p.jumlah_satuan || 1} ${getStringValue(p.satuan)}`;
            const batchCount = p.batch ? p.batch.length : 0;

            // FIX: Dynamic href untuk batch dengan ?from= + query current
            const baseBatchUrl = batchUrl.replace(':id', p.id);
            let batchHref = baseBatchUrl + '?from=produk.data';  // Tambah from=route_name
            const currentQuery = new URLSearchParams(window.location.search).toString();  // Ambil query current (page, search, dll.)
            if (currentQuery) {
                batchHref += '&' + currentQuery;
            }

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${p.kode_produk || '-'}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="img-container">
                            <img src="{{ asset('storage') }}/${p.gambar || 'images/default-produk.png'}"
                                alt="${p.nama_produk}"
                                onerror="this.src='{{ asset('images/default-produk.png') }}'">
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
                    <span class="badge-status badge-${statusTampilClass}">${p.status_tampil || 'Draft'}</span>
                    <span class="badge-status badge-${stokClass}">${stokStatus}</span>
                </td>
                <td>
                    <button class="btn-action btn-detail" data-id="${p.id}"><i class="bi bi-eye"></i></button>
                    <a href="${editUrl.replace(':id', p.id)}" class="btn-action btn-edit"><i class="bi bi-pencil"></i></a>
                    <button class="btn-action btn-delete" data-id="${p.id}" data-name="${p.nama_produk.replace(/"/g, '&quot;')}" data-batch="${batchCount}"><i class="bi bi-trash"></i></button>
                    <a href="${batchHref}" class="btn-action btn-batch"><i class="bi bi-layers"></i></a>  <!-- Ganti href ke dynamic -->
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
                if (page && page > 0 && page <= totalPages) {
                    currentPage = page;
                    renderTable();
                }
            });
        });
    }

    // Event: Detail Modal
    tableBody.addEventListener('click', e => {
        const btn = e.target.closest('.btn-detail');
        if (!btn) return;

        const id = btn.dataset.id;
        const p = produkData.find(x => x.id == id);
        if (!p) return;

        document.getElementById('detailGambar').src = '{{ asset('storage') }}/' + (p.gambar || 'images/default-produk.png');
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

        document.getElementById('detailStatusTampil').textContent = p.status_tampil || 'Draft';
        document.getElementById('detailStatusTampil').className = `badge-status badge-${(p.status_tampil || 'draft').toLowerCase().replace(/ /g, '_')}`;

        document.getElementById('detailStatusStok').textContent = stokStatus;
        document.getElementById('detailStatusStok').className = `badge-status badge-${stokStatus.toLowerCase()}`;

        new bootstrap.Modal(document.getElementById('detailModal')).show();
    });

    // Event: Tombol Delete
    tableBody.addEventListener('click', e => {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const id = parseInt(btn.dataset.id);
        const name = btn.dataset.name;
        const batchCount = parseInt(btn.dataset.batch);

        if (batchCount > 0) {
            new bootstrap.Modal(document.getElementById('batchWarningModal')).show();
            return;
        }

        document.getElementById('produkNama').textContent = name;

        if (!deleteModalInstance) {
            deleteModalInstance = new bootstrap.Modal(document.getElementById('deleteModal'));
        }
        currentDeleteId = id;
        deleteModalInstance.show();
    });

    // PERBAIKAN UTAMA: Konfirmasi Hapus
    document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
        if (!currentDeleteId) return;

        const url = deleteUrl.replace(':id', currentDeleteId);

        try {
            const res = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const responseText = await res.text();

            let json;
            try {
                json = JSON.parse(responseText);
            } catch (e) {
                console.error('Response bukan JSON:', responseText);
                showToast('Respons server tidak valid. Mungkin session habis atau error lain.', 'danger');
                return;
            }

            if (res.ok && json.success === true) {
                // Hapus dari data lokal
                produkData.splice(produkData.findIndex(p => p.id === currentDeleteId), 1);
                filteredData = filteredData.filter(p => p.id !== currentDeleteId);

                applyFiltersAndSearch();

                showToast(json.message || 'Produk berhasil dihapus!', 'success');
            } else {
                showToast(json.message || 'Gagal menghapus produk.', 'danger');
            }
        } catch (err) {
            console.error('Fetch error:', err);
            showToast('Tidak dapat terhubung ke server.', 'danger');
        } finally {
            if (deleteModalInstance) deleteModalInstance.hide();
            currentDeleteId = null;
        }
    });

    // Init
    document.addEventListener('DOMContentLoaded', () => {
        populateSupplierFilter();

        filterStatusTampil.addEventListener('change', applyFiltersAndSearch);
        filterStatusStok.addEventListener('change', applyFiltersAndSearch);
        filterSupplier.addEventListener('change', applyFiltersAndSearch);
        searchInput.addEventListener('input', applyFiltersAndSearch);
        searchButton.addEventListener('click', applyFiltersAndSearch);

        applyFiltersAndSearch();

        // Tampilkan toast session
        document.querySelectorAll('.toast').forEach(toastEl => {
            new bootstrap.Toast(toastEl, { delay: 5000 }).show();
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
</body>
</html>
