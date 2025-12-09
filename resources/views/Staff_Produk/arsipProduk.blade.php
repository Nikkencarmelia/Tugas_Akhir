<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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

            /* Styling Search & Filter */
            .search-wrapper { border: 1px solid #ced4da; border-radius: 0.375rem; transition: all 0.2s ease; }
            .search-wrapper:focus-within { border-color: #6B7280; box-shadow: 0 0 0 0.25rem rgba(107, 114, 128, .25); }
            .search-wrapper .form-control, .search-wrapper .input-group-text { border: none; box-shadow: none !important; background-color: var(--bs-body-bg); }
            .input-group-text { cursor: pointer; transition: all 0.2s ease; }
            .btn-add { background: #6B7280; color: var(--white); border: none; border-radius: .5rem; padding: .55rem 1.1rem; font-weight: 500; font-size: .9rem; box-shadow: 0 3px 6px var(--shadow); transition: all .3s ease; }
            .btn-add:hover { background: #4B5563; }
            .form-select { font-size: .9rem; color: var(--text-dark); border-color: #ced4da; box-shadow: none !important; }

            /* Table Styling */
            .table-card { background: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); overflow: hidden; }
            .table th { background: #F3F4F6; color: var(--text-muted); font-weight: 600; font-size: .85rem; text-transform: uppercase; border-bottom: 2px solid var(--border-color); }
            .table td { vertical-align: middle; font-size: .9rem; border-top: 1px solid var(--border-color); color: var(--text-dark); }
            .table tbody tr:hover { background-color: #F8F8F8; }

            /* Checkbox Styling */
            .table th:first-child, .table td:first-child { width: 40px; text-align: center; }

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
            .badge-tersedia { background: #DBEAFE; color: #1E40AF; }
            .badge-menipis { background: #FEF3C7; color: #92400E; }
            .badge-habis { background: #FEE2E2; color: #991B1B; }

            /* Action Buttons */
            .btn-action { border: none; border-radius: .4rem; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: .85rem; margin-right: .25rem; transition: .25s ease; text-decoration: none; }
            .btn-action:hover { transform: scale(1.1); }
            .btn-detail { background: var(--green-primary); }
            .btn-batch { background: #10B981; }

            /* Action Bar Bawah */
            .action-bar { margin-top: 1rem; padding: 1rem; background-color: var(--white); border-radius: .8rem; border: 1px solid var(--border-color); box-shadow: 0 2px 8px var(--shadow); display: flex; justify-content: space-between; align-items: center; }
            .btn-restore-selected { background-color: var(--green-primary); color: var(--white); font-weight: 600; }
            .btn-restore-selected:hover { background-color: var(--green-text); color: var(--white); }
            .btn-restore-all { background-color: #3B82F6; color: var(--white); font-weight: 600; }
            .btn-restore-all:hover { background-color: #2563EB; color: var(--white); }

            /* Pagination */
            .pagination .page-link { color: #6B7280; }
            .pagination .page-item.active .page-link { background-color: #6B7280; border-color: #6B7280; color: #fff; }
            .pagination .page-link:hover { background-color: #4B5563; color: #fff; border-color: #6B7280; }
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

                <select id="filter-supplier" class="form-select" style="width: 150px;">
                    <option value="all">Semua Supplier</option>
                    {{-- Opsi akan diisi oleh JavaScript dari data produk --}}
                </select>

                <select id="filter-kategori" class="form-select" style="width: 150px;">
                    <option value="all">Semua Kategori</option>
                    {{-- Opsi akan diisi oleh JavaScript dari data produk --}}
                </select>

                <form id="search-form" class="d-flex" role="search" style="width: 300px;">
                    <div class="input-group search-wrapper w-100">
                        <input type="text" id="search-input" class="form-control" placeholder="Cari ID, nama, deskripsi..." aria-label="Search">
                        <button class="input-group-text border-start-0" type="submit">
                            <i class="bi bi-search text-muted"></i>
                        </button>
                    </div>
                </form>

                <a href="/data_produk" class="btn-add" title="Kembali ke Daftar Produk Aktif">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <p class="text-muted mb-4">Produk yang tercantum di sini tidak ditampilkan di halaman utama. Gunakan tombol **Tampilkan Produk** untuk mengembalikannya.</p>

        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <input type="checkbox" id="check-all-products" title="Pilih semua di halaman ini">
                            </th>
                            <th>ID</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="product-table-body">
                        {{-- Konten diisi oleh JavaScript --}}
                    </tbody>
                </table>
            </div>
        </div>

        <div class="action-bar d-flex justify-content-between align-items-center">
            <div id="selection-status" class="text-muted fw-bold">
                0 Produk dipilih
            </div>
            <div class="d-flex gap-3">
                <button id="btn-restore-selected" class="btn btn-restore-selected" disabled>
                    <i class="bi bi-arrow-clockwise"></i> Tampilkan yang Dipilih
                </button>
                <button id="btn-restore-all" class="btn btn-restore-all">
                    <i class="bi bi-upload"></i> Tampilkan Semua Arsip
                </button>
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center mt-3"></ul>
        </nav>
    </div>

    {{-- MODAL DETAIL --}}
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
                                    <p class="mb-1"><strong>Kategori:</strong> <span id="detailKategori" class="badge-kategori"></span></p>
                                </div>
                            </div>
                            <hr>
                            <p class="mb-1">
                                <strong>Status Tampil:</strong> <span id="detailStatusTampil" class="badge-status"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // --- KONFIGURASI DAN DATA ---
    const tableBody = document.getElementById('product-table-body');

    // PENTING: Mengambil data dari PHP/Laravel yang disalurkan melalui Blade
    // Pastikan variabel '$produk' dikirim dari Controller/web.php
    const produkData = @json($produk);
    const perPage = 5;
    let currentPage = 1;

    // Elemen aksi massal baru
    const checkAll = document.getElementById('check-all-products');
    const btnRestoreSelected = document.getElementById('btn-restore-selected');
    const btnRestoreAll = document.getElementById('btn-restore-all');
    const selectionStatus = document.getElementById('selection-status');

    // Variabel untuk menyimpan ID produk yang dipilih (di seluruh halaman)
    let selectedProductIds = new Set();

    // Elemen filter dan search
    const filterSupplier = document.getElementById('filter-supplier');
    const filterKategori = document.getElementById('filter-kategori');
    const searchInput = document.getElementById('search-input');
    const searchForm = document.getElementById('search-form');

    let filteredData = [];

    // ----------------------------------------------------------------------
    // --- FUNGSI UTAMA UNTUK FILTER, SEARCH, DAN RENDER ---
    // ----------------------------------------------------------------------

    function applyFiltersAndSearch() {
        currentPage = 1;
        // 1. Filter default: Hanya produk yang status_tampil = 'Diarsipkan'
        let dataToProcess = produkData.filter(p => p.status_tampil === 'Diarsipkan');

        const supplierVal = filterSupplier.value;
        const kategoriVal = filterKategori.value;
        const searchTerm = searchInput.value.toLowerCase().trim();

        dataToProcess = dataToProcess.filter(p => {
            const matchSupplier = supplierVal === 'all' || p.supplier === supplierVal;
            const matchKategori = kategoriVal === 'all' || p.kategori === kategoriVal;

            const matchSearch = p.id.toString().toLowerCase().includes(searchTerm) ||
                                p.nama_produk.toLowerCase().includes(searchTerm) ||
                                p.deskripsi.toLowerCase().includes(searchTerm);

            return matchSupplier && matchKategori && matchSearch;
        });

        filteredData = dataToProcess;
        renderTable(currentPage);
        updateActionBar();
    }

    function populateSupplierFilter() {
        // Ambil semua supplier dari SEMUA data
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

    function populateKategoriFilter() {
        // Ambil semua kategori dari SEMUA data
        const categories = [...new Set(produkData.map(p => p.kategori))].sort();
        filterKategori.innerHTML = '<option value="all">Semua Kategori</option>';

        categories.forEach(kategori => {
            if (kategori) {
                const option = document.createElement('option');
                option.value = kategori;
                option.textContent = kategori;
                filterKategori.appendChild(option);
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
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada produk diarsipkan yang sesuai dengan kriteria filter/pencarian.</td></tr>`;
        }

        items.forEach((p) => {
            const isChecked = selectedProductIds.has(p.id);

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="text-center">
                    <input type="checkbox" class="product-checkbox" data-id="${p.id}" ${isChecked ? 'checked' : ''}>
                </td>
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
                <td>
                    <button class="btn-action btn-detail" data-id="${p.id}" title="Lihat Detail"><i class="bi bi-eye"></i></button>
                    <a href="/batch_stok" class="btn-action btn-batch"><i class="bi bi-layers"></i></a>
                    <button class="btn-pulihkan btn btn-sm btn-outline-success" data-id="${p.id}" data-name="${p.nama_produk}" title="Pulihkan Produk ke Ditampilkan">
                        <i class="bi bi-upload"></i> Tampilkan Arsip
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        colorizeBadges();
        renderPagination(totalPages);

        // Sinkronisasi status 'Pilih Semua'
        const displayedIds = items.map(p => p.id);
        const allChecked = displayedIds.length > 0 && displayedIds.every(id => selectedProductIds.has(id));
        checkAll.checked = allChecked;

        updateActionBar();
    }

    // ----------------------------------------------------------------------
    // --- FUNGSI SELEKSI & AKSI MASSAL BARU ---
    // ----------------------------------------------------------------------

    function updateActionBar() {
        const count = selectedProductIds.size;
        selectionStatus.textContent = `${count} Produk dipilih`;
        btnRestoreSelected.disabled = count === 0;

        // Tampilkan jumlah total produk diarsipkan di tombol "Tampilkan Semua"
        btnRestoreAll.innerHTML = `<i class="bi bi-upload"></i> Tampilkan Semua Arsip (${filteredData.length})`;
    }

    // Handler untuk checkbox individu
    function handleCheckboxChange(e) {
        const id = parseInt(e.target.dataset.id);
        if (e.target.checked) {
            selectedProductIds.add(id);
        } else {
            selectedProductIds.delete(id);
        }
        updateActionBar();

        // Perbarui status 'Pilih Semua' di header
        const displayedIds = filteredData.slice((currentPage - 1) * perPage, currentPage * perPage).map(p => p.id);
        const allChecked = displayedIds.length > 0 && displayedIds.every(id => selectedProductIds.has(id));
        checkAll.checked = allChecked;
    }

    // Handler untuk checkbox 'Pilih Semua' di header
    function handleCheckAllChange(e) {
        const isChecked = e.target.checked;
        const checkboxes = document.querySelectorAll('.product-checkbox');

        checkboxes.forEach(cb => {
            cb.checked = isChecked;
            const id = parseInt(cb.dataset.id);
            if (isChecked) {
                selectedProductIds.add(id);
            } else {
                selectedProductIds.delete(id);
            }
        });
        updateActionBar();
    }


    // Aksi Massal: Tampilkan Produk yang Dipilih
    function restoreSelectedProducts() {
        const ids = Array.from(selectedProductIds);
        if (ids.length === 0) return;

        if (confirm(`SIMULASI: Anda akan memulihkan ${ids.length} produk terpilih ke status 'Ditampilkan'. Lanjutkan?`)) {
            console.log(`[SIMULASI] Mengirim permintaan PULIHKAN massal untuk ID: ${ids.join(', ')}`);

            // SIMULASI BERHASIL: Ubah status di data lokal
            ids.forEach(id => {
                const produk = produkData.find(p => p.id === id);
                if (produk) {
                    produk.status_tampil = 'Ditampilkan';
                }
            });

            // Kosongkan seleksi dan refresh
            selectedProductIds.clear();
            checkAll.checked = false;
            applyFiltersAndSearch();
            alert(`${ids.length} produk berhasil dipulihkan dan kini Ditampilkan.`);
        }
    }

    // Aksi Massal: Tampilkan Semua Produk Arsip
    function restoreAllProducts() {
        const totalCount = filteredData.length;
        if (totalCount === 0) return;

        if (confirm(`SIMULASI: Anda akan memulihkan SEMUA ${totalCount} produk di arsip ke status 'Ditampilkan'. Lanjutkan?`)) {
            console.log(`[SIMULASI] Mengirim permintaan PULIHKAN SEMUA (${totalCount}) produk arsip.`);

            // SIMULASI BERHASIL: Ubah status di data lokal
            filteredData.forEach(p => {
                const produk = produkData.find(item => item.id === p.id);
                if (produk) {
                    produk.status_tampil = 'Ditampilkan';
                }
            });

            // Kosongkan seleksi dan refresh
            selectedProductIds.clear();
            checkAll.checked = false;
            applyFiltersAndSearch();
            alert(`${totalCount} produk berhasil dipulihkan semua dan kini Ditampilkan.`);
        }
    }

    // ----------------------------------------------------------------------
    // --- LOGIKA PENDUKUNG (COLORIZE & PAGINATION) ---
    // ----------------------------------------------------------------------

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

    function handleRestore(productId, productName) {
        if (confirm(`SIMULASI: Pulihkan produk "${productName}" (ID: ${productId}) dan kembalikan ke status 'Ditampilkan'?`)) {
            console.log(`[SIMULASI] Mengirim permintaan PULIHKAN produk ID: ${productId}`);

            const index = produkData.findIndex(p => p.id == productId);
            if (index !== -1) {
                produkData[index].status_tampil = 'Ditampilkan';
                selectedProductIds.delete(productId);
            }

            applyFiltersAndSearch();
            alert(`Produk "${productName}" berhasil dipulihkan dan kini Ditampilkan.`);
        }
    }


    // ----------------------------------------------------------------------
    // --- EVENT LISTENERS (FINAL) ---
    // ----------------------------------------------------------------------

    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inisialisasi Filter & Render Awal
        populateSupplierFilter();
        populateKategoriFilter();
        filterSupplier.addEventListener('change', applyFiltersAndSearch);
        filterKategori.addEventListener('change', applyFiltersAndSearch);
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            applyFiltersAndSearch();
        });
        applyFiltersAndSearch();

        // 2. Event Listener untuk Checkbox di Header
        checkAll.addEventListener('change', handleCheckAllChange);

        // 3. Event Listener untuk Aksi Massal
        btnRestoreSelected.addEventListener('click', restoreSelectedProducts);
        btnRestoreAll.addEventListener('click', restoreAllProducts);
    });


    // Event listener untuk tombol Aksi di tabel (Detail, Pulihkan Individu, Checkbox)
    tableBody.addEventListener('click', function(e){
        const restoreBtn = e.target.closest('.btn-pulihkan');
        const detailBtn = e.target.closest('.btn-detail');
        const checkbox = e.target.closest('.product-checkbox');

        if (restoreBtn) {
            const productId = parseInt(restoreBtn.dataset.id);
            const productName = restoreBtn.dataset.name;
            handleRestore(productId, productName);
        } else if (checkbox) {
            handleCheckboxChange(e);
        } else if (detailBtn) {
            const productId = detailBtn.dataset.id;
            const produk = produkData.find(p => p.id == productId);
            if (!produk) return;

            // Isi data Modal
            document.getElementById('detailGambar').src = produk.gambar;
            document.getElementById('detailNama').textContent = produk.nama_produk;
            document.getElementById('detailDeskripsi').textContent = produk.deskripsi;
            document.getElementById('detailSupplier').textContent = produk.supplier ?? 'Tidak ada';
            document.getElementById('detailSatuan').textContent = produk.satuan_berat;

            const detailKategoriEl = document.getElementById('detailKategori');
            detailKategoriEl.textContent = produk.kategori;
            colorizeSingle(detailKategoriEl, produk.kategori.toLowerCase());

            const statusTampilEl = document.getElementById('detailStatusTampil');
            statusTampilEl.textContent = produk.status_tampil;
            statusTampilEl.className = 'badge-status badge-' + produk.status_tampil.toLowerCase().replace(/ /g,'_');

            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }
    });
    </script>
    @endsection
    </body>
</html>
