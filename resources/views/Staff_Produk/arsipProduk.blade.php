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

                <form method="GET" id="filter-form" class="d-flex gap-2">
                    <select name="supplier" id="filter-supplier" class="form-select" style="width: 150px;">
                        <option value="all">Semua Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier }}" {{ request('supplier') == $supplier ? 'selected' : '' }}>{{ $supplier }}</option>
                        @endforeach
                    </select>

                    <select name="kategori" id="filter-kategori" class="form-select" style="width: 150px;">
                        <option value="all">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                        @endforeach
                    </select>

                    <div class="input-group search-wrapper" style="width: 300px;">
                        <input type="text" name="search" id="search-input" class="form-control" placeholder="Cari ID, nama, deskripsi..." value="{{ request('search') }}" aria-label="Search">
                        <button class="input-group-text border-start-0" type="submit">
                            <i class="bi bi-search text-muted"></i>
                        </button>
                    </div>
                </form>
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
                        @forelse($produk as $p)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="product-checkbox" data-id="{{ $p->id }}">
                                </td>
                                <td>{{ $p->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="img-container">
                                            <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_produk }}">
                                            <span class="badge-supplier">{{ $p->supplier->nama_supplier ?? '-' }}</span>
                                        </div>
                                        <div class="product-info">
                                            <span>{{ $p->nama_produk }}</span>
                                            <small>{{ Str::limit($p->deskripsi, 40) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge-kategori">{{ $p->kategori->nama_kategori ?? '-' }}</span></td>
                                <td>
                                    {{ $p->jumlah_satuan ?? '-' }} {{ $p->satuan->nama_satuan ?? '' }}
                                </td>
                                <td>
                                    <button class="btn-action btn-detail" data-bs-toggle="modal" data-bs-target="#detailModal"
                                            data-produk='@json($p)' title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="{{ route('produk.batch.index', $p->id) }}" class="btn-action btn-batch" title="Kelola Batch">
                                        <i class="bi bi-layers"></i>
                                    </a>
                                    <button class="btn-pulihkan btn btn-sm btn-outline-success" data-id="{{ $p->id }}" data-name="{{ $p->nama_produk }}" title="Pulihkan Produk ke Ditampilkan">
                                        <i class="bi bi-upload"></i> Tampilkan Arsip
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Tidak ada produk diarsipkan yang sesuai dengan kriteria filter/pencarian.</td>
                            </tr>
                        @endforelse
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
                    <i class="bi bi-upload"></i> Tampilkan Semua Arsip ({{ $produk->total() }})
                </button>
            </div>
        </div>

        <nav aria-label="Page navigation example">
            <div class="d-flex justify-content-center mt-3">
                {{ $produk->appends(request()->query())->links() }}
            </div>
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

    {{-- MODAL KONFIRMASI --}}
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Aksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmMessage">Apakah Anda yakin?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="confirmYes">Tampilkan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Elemen
    const checkAll = document.getElementById('check-all-products');
    const btnRestoreSelected = document.getElementById('btn-restore-selected');
    const btnRestoreAll = document.getElementById('btn-restore-all');
    const selectionStatus = document.getElementById('selection-status');
    const tableBody = document.getElementById('product-table-body');
    const filterForm = document.getElementById('filter-form');
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    const confirmMessageEl = document.getElementById('confirmMessage');
    const confirmYesBtn = document.getElementById('confirmYes');

    let selectedProductIds = new Set();
    let currentConfirmCallback = null;

    // Live search debounce
    let searchTimeout;
    const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterForm.submit();
        }, 500); // Debounce 500ms
    });

    // Fungsi colorize badges dinamis
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

    // Update action bar
    function updateActionBar() {
        const count = selectedProductIds.size;
        selectionStatus.textContent = `${count} Produk dipilih`;
        btnRestoreSelected.disabled = count === 0;
        btnRestoreAll.innerHTML = `<i class="bi bi-upload"></i> Tampilkan Semua Arsip ({{ $produk->total() }})`;
    }

    // Checkbox handlers
    function handleCheckboxChange(e) {
        const id = parseInt(e.target.dataset.id);
        if (e.target.checked) selectedProductIds.add(id);
        else selectedProductIds.delete(id);
        updateActionBar();
        syncCheckAll();
    }

    function handleCheckAllChange(e) {
        const isChecked = e.target.checked;
        document.querySelectorAll('.product-checkbox').forEach(cb => {
            cb.checked = isChecked;
            const id = parseInt(cb.dataset.id);
            if (isChecked) selectedProductIds.add(id);
            else selectedProductIds.delete(id);
        });
        updateActionBar();
    }

    function syncCheckAll() {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkAll.checked = allChecked && checkboxes.length > 0;
    }

    // Fetch helper
    async function sendRestoreRequest(url, data = null) {
        try {
            const options = {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: data ? JSON.stringify(data) : null
            };
            const response = await fetch(url, options);
            if (!response.ok) throw new Error('Gagal');
            const result = await response.json();
            if (result.success) {
                location.reload();
                return true;
            } else {
                alert(result.message || 'Gagal memulihkan.');
                return false;
            }
        } catch (error) {
            alert('Kesalahan koneksi.');
            return false;
        }
    }

    // Fungsi konfirmasi modal
    function showConfirmModal(message, callback) {
        confirmMessageEl.textContent = message;
        currentConfirmCallback = callback;
        confirmModal.show();
    }

    // Event listener untuk tombol konfirmasi
    confirmYesBtn.addEventListener('click', () => {
        if (currentConfirmCallback) {
            currentConfirmCallback();
        }
        confirmModal.hide();
        currentConfirmCallback = null;
    });

    // Restore actions dengan modal
    async function restoreSelectedProducts() {
        const ids = Array.from(selectedProductIds);
        if (ids.length === 0) return;
        showConfirmModal(`Anda akan memulihkan ${ids.length} produk terpilih ke status 'Ditampilkan'. Lanjutkan?`, async () => {
            await sendRestoreRequest('/arsip-produk/restore-selected', { ids });
        });
    }

    async function restoreAllProducts() {
        const total = {{ $produk->total() }};
        showConfirmModal(`Anda akan memulihkan SEMUA ${total} produk di arsip ke status 'Ditampilkan'. Lanjutkan?`, async () => {
            const ids = @json($produk->pluck('id')->toArray());
            await sendRestoreRequest('/arsip-produk/restore-all', { ids });
        });
    }

    async function handleRestore(id, name) {
        showConfirmModal(`Apakah anda yakin produk "${name}" akan dikembalikan ke status 'Ditampilkan'?`, async () => {
            await sendRestoreRequest(`/arsip-produk/restore/${id}`);
        });
    }

    /* ================= DETAIL MODAL ================= */
    const detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const produkData = JSON.parse(button.getAttribute('data-produk'));

        document.getElementById('detailGambar').src =
            produkData.gambar ? `/storage/${produkData.gambar}` : '';
        document.getElementById('detailNama').textContent =
            produkData.nama_produk ?? '-';
        document.getElementById('detailDeskripsi').textContent =
            produkData.deskripsi ?? '-';

        const supplierEl = document.getElementById('detailSupplier');
        supplierEl.textContent = produkData.supplier?.nama_supplier ?? 'Tidak ada';
        colorizeSingle(supplierEl, (produkData.supplier?.nama_supplier ?? '').toLowerCase());

        document.getElementById('detailSatuan').textContent =
            (produkData.jumlah_satuan || 0) + ' ' + (produkData.satuan?.nama_satuan ?? '-');

        const kategoriEl = document.getElementById('detailKategori');
        kategoriEl.textContent =
            produkData.kategori?.nama_kategori ?? '-';

        if (produkData.kategori?.nama_kategori) {
            colorizeSingle(
                kategoriEl,
                produkData.kategori.nama_kategori.toLowerCase()
            );
        }

        document.getElementById('detailJumlahBatch').textContent =
            produkData.batch ? produkData.batch.length : 0;

        const statusTampilEl = document.getElementById('detailStatusTampil');
        statusTampilEl.textContent = produkData.status_tampil ?? '-';
        statusTampilEl.className =
            'badge-status badge-' +
            (produkData.status_tampil ?? '')
            .toLowerCase().replace(/ /g, '_');

        const statusStokEl = document.getElementById('detailStatusStok');
        statusStokEl.textContent = produkData.status_stok ?? '-';
        statusStokEl.className =
            'badge-status badge-' +
            (produkData.status_stok ?? '')
            .toLowerCase().replace(/_| /g, '-');
    });

    // Event listeners
    document.addEventListener('DOMContentLoaded', () => {
        colorizeBadges(); // Colorize badges awal
        updateActionBar();
        checkAll.addEventListener('change', handleCheckAllChange);
        btnRestoreSelected.addEventListener('click', restoreSelectedProducts);
        btnRestoreAll.addEventListener('click', restoreAllProducts);
        tableBody.addEventListener('change', e => {
            if (e.target.classList.contains('product-checkbox')) handleCheckboxChange(e);
        });
        tableBody.addEventListener('click', e => {
            const restoreBtn = e.target.closest('.btn-pulihkan');
            if (restoreBtn) {
                const id = parseInt(restoreBtn.dataset.id);
                const name = restoreBtn.dataset.name;
                handleRestore(id, name);
            }
        });
        syncCheckAll();
    });
    </script>
    @endsection
    </body>
</html>
