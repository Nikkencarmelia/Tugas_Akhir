<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Stok Produk</title>
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
        .btn-add { background: var(--green-primary); color: var(--white); border: none; border-radius: .5rem; padding: .55rem 1.1rem; font-weight: 500; font-size: .9rem; box-shadow: 0 3px 6px var(--shadow); transition: all .3s ease; }
        .btn-add:hover { background: var(--green-text); }
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
        .product-info { margin-left: .75rem; }
        .product-info span { font-weight: 600; font-size: .95rem; color: var(--text-dark); }
        .product-info small { color: var(--text-muted); display: block; font-size: .8rem; }

        /* Status Badges */
        .badge-status { padding: .3rem .9rem; border-radius: 1rem; font-size: .75rem; font-weight: 600; display: inline-block; margin-right: .25rem; line-height: 1.5; }
        .badge-ditampilkan { background: #DCFCE7; color: #166534; }
        .badge-diarsipkan { background: #E5E7EB; color: #374151; }
        .badge-draft { background: #F3E8FF; color: #7E22CE; }
        /* Status Stok (Lowercased) */
        .badge-menipis { background: #FEF3C7; color: #92400E; }
        .badge-habis { background: #FEE2E2; color: #991B1B; }

        /* Action Buttons */
        .btn-action { border: none; border-radius: .4rem; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: .85rem; margin-right: .25rem; transition: .25s ease; }
        .btn-action:hover { transform: scale(1.1); }
        .btn-detail { background: var(--green-primary); }
        .btn-update-stock { background: #10B981; }

        /* Update Input */
        .stock-input { width: 100px; font-size: .85rem; }

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
        <h1 class="dashboard-title"><i class="bi bi-boxes"></i> Kelola Stok Produk</h1>

        <div class="d-flex gap-2 flex-wrap align-items-center">

            <select id="filter-status-tampil" class="form-select" style="width: 150px;">
                <option value="all">Status Tampil</option>
                <option value="Ditampilkan">Ditampilkan</option>
                <option value="Diarsipkan">Diarsipkan</option>
                <option value="Draft">Draft</option>
            </select>

            <select id="filter-status-stok" class="form-select" style="width: 150px;">
                <option value="all">Status Stok</option>
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

    <p class="text-muted mb-4">Menampilkan produk yang stoknya <strong>menipis atau habis</strong>. Silakan update jika stok sudah tersedia kembali.</p>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Update Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="text-muted small mb-0" id="page-info"></p>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center"></ul>
        </nav>
    </div>

    <div class="text-end mt-3">
        <button id="update-all-button" class="btn btn-success">
            <i class="bi bi-cloud-upload"></i> Update Semua Stok
        </button>
    </div>
</div>

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
                                <p class="mb-1"><strong>Supplier:</strong> <span id="detailSupplier"></span></p>
                                <p class="mb-1"><strong>Satuan:</strong> <span id="detailSatuan"></span></p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><strong>Harga:</strong> <span id="detailHarga" class="fw-bold"></span></p>
                                <p class="mb-1"><strong>Stok:</strong> <span id="detailStok" class="fw-bold"></span></p>
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

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center">
                <i id="toast-icon" class="bi bi-check-circle-fill me-2 fs-5"></i>
                <span id="toast-message">Pesan berhasil</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
// --- KONFIGURASI DAN DATA ---
const tableBody = document.querySelector('tbody');
const pageInfo = document.getElementById('page-info');

// PENTING: Mengambil data dari PHP/Laravel yang disalurkan melalui Blade
const produkData = @json($produk);
const perPage = 5;
let currentPage = 1;

// Elemen filter dan search
const filterStatusTampil = document.getElementById('filter-status-tampil');
const filterStatusStok = document.getElementById('filter-status-stok');
const filterSupplier = document.getElementById('filter-supplier');
const searchInput = document.getElementById('search-input');
const searchForm = document.getElementById('search-form');

let filteredData = [...produkData]; // Data yang sedang aktif ditampilkan

// ----------------------------------------------------------------------
// --- FUNGSI TOAST NOTIFICATION ---
// ----------------------------------------------------------------------
function showToast(message, type = 'success') {
    const toastElement = document.getElementById('liveToast');
    const toastMessage = document.getElementById('toast-message');
    const toastIcon = document.getElementById('toast-icon');

    // Hapus semua kelas warna dan ikon lama
    toastElement.classList.remove('text-bg-success', 'text-bg-danger', 'text-bg-warning');
    toastIcon.classList.remove('bi-check-circle-fill', 'bi-exclamation-triangle-fill', 'bi-x-octagon-fill');

    // Tentukan kelas warna dan ikon baru
    let iconClass;
    if (type === 'danger') {
        iconClass = 'bi-x-octagon-fill';
        toastElement.classList.add('text-bg-danger');
    } else if (type === 'warning') {
        iconClass = 'bi-exclamation-triangle-fill';
        toastElement.classList.add('text-bg-warning');
    } else { // success
        iconClass = 'bi-check-circle-fill';
        toastElement.classList.add('text-bg-success');
    }

    toastIcon.classList.add(iconClass);
    toastMessage.textContent = message;

    const toast = new bootstrap.Toast(toastElement);
    toast.show();
}

// ----------------------------------------------------------------------
// --- FUNGSI UTAMA UNTUK FILTER, SEARCH, DAN RENDER ---
// ----------------------------------------------------------------------

function applyFiltersAndSearch() {
    currentPage = 1;
    let dataToProcess = [...produkData];

    const statusTampilVal = filterStatusTampil.value;
    const statusStokVal = filterStatusStok.value;
    const supplierVal = filterSupplier.value;
    const searchTerm = searchInput.value.toLowerCase().trim();

    // Selalu filter hanya produk dengan status stok Menipis atau Habis
    dataToProcess = dataToProcess.filter(p => p.status_stok === 'Menipis' || p.status_stok === 'Habis');

    dataToProcess = dataToProcess.filter(p => {
        const matchStatusTampil = statusTampilVal === 'all' || p.status_tampil === statusTampilVal;

        const matchStatusStok = statusStokVal === 'all' || p.status_stok === statusStokVal;

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

function renderTable(page = 1) {
    tableBody.innerHTML = '';
    const totalItems = filteredData.length;
    const totalPages = Math.ceil(totalItems / perPage);
    const start = (page - 1) * perPage;
    const end = start + perPage;
    const items = filteredData.slice(start, end);
    const startItem = start + 1;
    const endItem = Math.min(end, totalItems);

    pageInfo.textContent = `Menampilkan ${startItem}–${endItem} dari ${totalItems} produk bermasalah`;

    if (items.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-muted">Tidak ada data produk yang sesuai dengan kriteria filter/pencarian.</td></tr>`;
    }

    items.forEach((p) => {
        const rawHarga = p.harga;

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
            <td>${p.satuan_berat}</td>
            <td>${rawHarga}</td>
            <td class="stok-cell" style="${stockStyle}">${p.stok}</td>
            <td>
                <span class="badge-status badge-${p.status_tampil.toLowerCase().replace(/ /g,'_')}">${p.status_tampil}</span>
                <span class="badge-status badge-${statusStokClass}">${p.status_stok}</span>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm stock-input" placeholder="Stok Baru" min="0" id="new_stock_${p.id}" style="width: 100px;">
            </td>
            <td>
                <button class="btn-action btn-detail" data-id="${p.id}"><i class="bi bi-eye"></i></button>
                <button class="btn btn-sm btn-outline-success" data-id="${p.id}"><i class="bi bi-arrow-clockwise"></i>Update Stok</button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    colorizeBadges();
    renderPagination(totalPages);
}

// ----------------------------------------------------------------------
// --- FUNGSI PENDUKUNG ---
// ----------------------------------------------------------------------

function colorizeBadges() {
    const badges = document.querySelectorAll('.badge-supplier');
    const colorPairs = [
        { bg: "#BAE6FD", text: "#0369A1" }, { bg: "#FEF9C3", text: "#A16207" },
        { bg: "#FBCFE8", text: "#9D174D" }, { bg: "#A7F3D0", text: "#065F46" },
        { bg: "#DDD6FE", text: "#5B21B6" }, { bg: "#FECACA", text: "#991B1B" },
        { bg: "#FDE68A", text: "#B45309" }, { bg: "#F5D0FE", text: "#86198F" }
    ];

    badges.forEach(badge => {
        const text = badge.textContent.trim().toLowerCase();
        let hash = 0;
        for (let i = 0; i < text.length; i++) hash = text.charCodeAt(i) + ((hash << 5) - hash);
        const color = colorPairs[Math.abs(hash) % colorPairs.length];
        badge.style.backgroundColor = color.bg;
        badge.style.color = color.text;
    });
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

// ----------------------------------------------------------------------
// --- FUNGSI UPDATE STOK ---
// ----------------------------------------------------------------------

function handleQuickUpdate(productId) {
    const input = document.getElementById(`new_stock_${productId}`);
    if (!input) return;

    const newStock = input.value.trim();
    if (newStock === "" || isNaN(newStock) || parseInt(newStock) < 0) {
        showToast("Mohon masukkan nilai stok yang valid (angka non-negatif).", 'warning');
        return;
    }

    const row = input.closest('tr');
    const currentStockCell = row.querySelector('.stok-cell');
    const produk = filteredData.find(p => p.id == productId);
    if (!produk) return;

    const productName = produk.nama_produk;

    // --- SIMULASI AJAX KE BACKEND DI SINI ---
    console.log(`[SIMULASI] Mengupdate Produk ID ${productId} menjadi Stok: ${newStock}`);

    // SIMULASI BERHASIL
    currentStockCell.textContent = newStock;
    currentStockCell.style.color = parseInt(newStock) == 0 ? '#991B1B' : '';

    // Kosongkan input dan tampilkan Toast Sukses
    showToast(`Stok ${productName} (${productId}) berhasil diupdate menjadi ${newStock}.`, 'success');
    input.value = '';

    // Refresh table untuk update status jika diperlukan
    applyFiltersAndSearch();
}

function handleUpdateAll() {
    const stockInputs = document.querySelectorAll('input.stock-input');
    const stockUpdates = [];

    stockInputs.forEach(input => {
        const newStockValue = input.value.trim();
        if (newStockValue !== "" && !isNaN(newStockValue) && parseInt(newStockValue) >= 0) {
            const productId = input.id.replace('new_stock_', '');
            const row = input.closest('tr');
            const currentStockEl = row.querySelector('.stok-cell');
            stockUpdates.push({
                id: productId,
                new_stock: parseInt(newStockValue),
                input: input,
                currentStockEl: currentStockEl
            });
        }
    });

    if (stockUpdates.length === 0) {
        showToast("Tidak ada stok baru yang valid untuk di-update.", 'warning');
        return;
    }

    if (!confirm(`Anda yakin ingin mengupdate ${stockUpdates.length} produk sekaligus?`)) {
        return;
    }

    // --- LOGIKA PENGIRIMAN DATA KE SERVER DENGAN AJAX/FETCH ---
    console.log("Data yang akan dikirim:", stockUpdates.map(u => ({ id: u.id, new_stock: u.new_stock })));

    // SIMULASI BERHASIL:
    stockUpdates.forEach(update => {
        update.currentStockEl.textContent = update.new_stock;
        update.currentStockEl.style.color = parseInt(update.new_stock) == 0 ? '#991B1B' : '';
        update.input.value = ''; // Kosongkan input
    });

    showToast(`Berhasil mengupdate ${stockUpdates.length} produk!`, 'success');

    // Refresh table
    applyFiltersAndSearch();
}

// ----------------------------------------------------------------------
// --- EVENT LISTENERS ---
// ----------------------------------------------------------------------

document.addEventListener('DOMContentLoaded', function() {
    // 1. Inisialisasi Supplier Filter
    populateSupplierFilter();

    // 2. Event Listeners untuk Filter dan Search
    filterStatusTampil.addEventListener('change', applyFiltersAndSearch);
    filterStatusStok.addEventListener('change', applyFiltersAndSearch);
    filterSupplier.addEventListener('change', applyFiltersAndSearch);

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        applyFiltersAndSearch();
    });

    // 3. Event listener untuk tombol update all
    document.getElementById('update-all-button').addEventListener('click', handleUpdateAll);

    // 4. Inisialisasi Render Awal
    applyFiltersAndSearch();
});

// Event listener tombol detail (Modal)
tableBody.addEventListener('click', function(e){
    const btn = e.target.closest('.btn-detail');
    if(btn){
        const productId = btn.dataset.id;
        const produk = filteredData.find(p => p.id == productId);
        if (!produk) return;

        // Isi data Modal
        document.getElementById('detailGambar').src = produk.gambar;
        document.getElementById('detailNama').textContent = produk.nama_produk;
        document.getElementById('detailDeskripsi').textContent = produk.deskripsi;

        document.getElementById('detailSupplier').textContent = produk.supplier ?? 'Tidak ada';

        document.getElementById('detailSatuan').textContent = produk.satuan_berat;
        document.getElementById('detailHarga').textContent = produk.harga;

        const detailStokEl = document.getElementById('detailStok');
        detailStokEl.textContent = produk.stok;
        detailStokEl.style.color = produk.stok == 0 ? '#991B1B' : '';

        // Status Tampil
        const statusTampilEl = document.getElementById('detailStatusTampil');
        statusTampilEl.textContent = produk.status_tampil;
        statusTampilEl.className = 'badge-status badge-' + produk.status_tampil.toLowerCase().replace(/ /g,'_');

        // Status Stok
        const statusStokEl = document.getElementById('detailStatusStok');
        statusStokEl.textContent = produk.status_stok;
        statusStokEl.className = 'badge-status badge-' + produk.status_stok.toLowerCase().replace(/_/g,'-').replace(/ /g,'-');

        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
    }
});

// Event listener untuk tombol update stok single
tableBody.addEventListener('click', function(e){
    const btn = e.target.closest('.btn-update-stock');
    if(btn){
        const productId = btn.dataset.id;
        handleQuickUpdate(productId);
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
</body>
</html>
