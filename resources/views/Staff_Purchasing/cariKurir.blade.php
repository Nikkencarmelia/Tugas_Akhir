<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cari Kurir - purchasing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f5f7fa; color: #333; }
        .orders-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .orders-header h3 { color: #2a522a; font-weight: 700; margin: 0; display: flex; align-items: center; gap: .5rem; }
        .orders-header h3 i { color: #198754; }
        
        .order-card { background: white; border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.06); transition: .3s; border: 1px solid #f1f3f4; position: relative;}
        .order-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .order-card.hidden { display: none !important; }
        .order-card.selected { border: 2px solid #198754; background-color: #f0fdf4; }

        .order-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef; }
        .order-meta { display: flex; flex-direction: column; font-size: 14px; color: #6c757d; gap: 4px; }
        .order-meta .alamat { background: #e8f5e9; color: #1b5e20; padding: 3px 8px; border-radius: 6px; font-size: 13px; display: inline-block; }
        .order-meta .metode { background: #e3f2fd; color: #0d47a1; padding: 3px 8px; border-radius: 6px; font-size: 13px; display: inline-block; }
        
        /* Unified Delivery & Method Badges */
        .badge-metode { background: #e3f2fd; color: #0d47a1; padding: 4px 10px; border-radius: 8px; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; }
        .badge-alamat { background: #e8f5e9; color: #1b5e20; padding: 4px 10px; border-radius: 8px; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; }
        .badge-kendaraan { background: #fef9c3; color: #854d0e; padding: 4px 10px; border-radius: 8px; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #fde68a; }
        .order-number { font-weight: 600; color: #495057; }

        .order-product { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 12px; }
        .img-container { position: relative; width: 80px; height: 80px; flex-shrink: 0; }
        .img-container img { width: 100%; height: 100%; object-fit: cover; border-radius: 12px; border: 1px solid #dee2e6; }
        .badge-supplier { position: absolute; top: 5px; right: 5px; font-size: .7rem; font-weight: 600; padding: .3rem .55rem; border-radius: .4rem; line-height: 1; z-index: 2; }
        
        .order-product-details h6 { margin-bottom: 0.25rem; font-weight: 600; color: #212529; }
        .produk-lain { font-size: 12px; color: #6c757d; font-style: italic; margin-top: 0.5rem; }

        .order-actions { display: flex; gap: 0.5rem; margin-top: 1rem; flex-wrap: wrap; }
        .select-controls { margin-bottom: 1.5rem; background: #fff; padding: 1rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); }

        .order-status { 
            display: flex; 
            align-items: center; 
            gap: .5rem; 
            padding: 6px 12px; 
            border-radius: 20px; 
            font-size: 13px; 
            font-weight: 500; 
            width: fit-content; 
            margin-bottom: 1rem; 
        }

        /* Status Colors - Synchronized with User History */
        .status-menunggu_konfirmasi { background: #f1f3f5; color: #495057; }
        .status-menunggu_pembayaran { background: #fff4e6; color: #d9480f; }
        .status-diproses { background: #fef9c3; color: #854d0e; }
        .status-dikirim { background: #e0f2fe; color: #0369a1; }
        .status-selesai { background: #dcfce7; color: #166534; }
        .status-dibatalkan { background: #fee2e2; color: #991b1b; }
        .status-verif { background: #fff7ed; color: #9a3412; }
        .status-siap_diambil { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .status-pesanan_telah_diambil { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .status-menunggu_konfirmasi_kurir { background: #fef9c3; color: #854d0e; }

        /* Custom Tab Buttons Style */
        .orders-tabs{display:flex;gap:1rem;align-items:center;flex-wrap:wrap;}
        .orders-tab{padding:8px 16px;border-radius:20px;background:#ffffff;text-decoration:none;color:#6c757d;font-weight:500;border:1px solid #e9ecef;transition:all .3s ease;}
        .orders-tab.active{background:#198754;color:white;border-color:#198754;}
        .orders-tab.active .badge { color: white !important; }
        .orders-tab:hover{background:#e9ecef;color:#495057;}
        .tab-panel{display:none;}
        .tab-panel.active{display:block;}

        /* Modal & Table Styles updated to match User/profil.blade.php */
        .modal-content { border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden; }
        .modal-header { background: #198754; color: white; border-bottom: none; padding: 1.5rem; border-radius: 12px 12px 0 0 !important; }
        .modal-header .btn-close { filter: invert(1); opacity: 0.8; }
        .modal-body { max-height: 70vh; overflow-y: auto; padding: 1.5rem; background: #fafbfc; }
        .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid #dee2e6; background: #f8f9fa; border-radius: 0 0 12px 12px; }
        
        .table { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }
        
        /* Badge Styles from Super_Admin/manajemenKurir.blade.php */
        .badge-online-aktif { background-color: var(--bs-success-bg-subtle) !important; color: var(--bs-success-text-emphasis) !important; padding: 0.5em 0.75em; border-radius: 0.375rem; font-size: 0.75em; font-weight: 500; }
        .badge-online-tidak-aktif { background-color: var(--bs-danger-bg-subtle) !important; color: var(--bs-danger-text-emphasis) !important; padding: 0.5em 0.75em; border-radius: 0.375rem; font-size: 0.75em; font-weight: 500; }
        /* Antar Status Badges - Prominent Solid Colors */
        .badge-antar-siap { background-color: #198754 !important; color: white !important; padding: 0.5em 0.85em; border-radius: 50px; font-size: 0.75em; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-antar-sedang-antar { background-color: #f59e0b !important; color: white !important; padding: 0.5em 0.85em; border-radius: 50px; font-size: 0.75em; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-antar-- { background-color: #6c757d !important; color: white !important; padding: 0.5em 0.85em; border-radius: 50px; font-size: 0.75em; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }

        @media(max-width: 768px) {
            .orders-header, .order-header { flex-direction: column; gap: 1rem; text-align: center; }
            .order-header { align-items: center; }
            .order-product { flex-direction: column; text-align: center; align-items: center; }
            .order-actions { justify-content: center; }
            .select-controls { flex-direction: column; }
            .select-controls .d-flex { flex-direction: column; width: 100%; }
            .select-controls select, .select-controls .input-group { max-width: 100% !important; }
            .order-status { margin: 0 auto 1rem auto; }
        }
    </style>
</head>

<body>
@extends('components.staff_purchasing')
@section('content')
<div class="container py-5">
    
    <!-- Toast & Alerts -->
    <div class="toast-container position-fixed top-0 end-0 p-4" style="z-index:9999;">
        <div id="toastCari" class="toast align-items-center text-bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex"><div class="toast-body fw-semibold"><i class="fa-solid fa-circle-check me-2"></i>Kurir telah dipilih!</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
        </div>
        @if(session('success'))
        <div id="toastSuccessInit" class="toast show align-items-center text-bg-success border-0 shadow-lg" role="alert">
            <div class="d-flex"><div class="toast-body fw-semibold"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
        </div>
        @endif
    </div>

    <!-- Header -->
    <div class="orders-header">
        <h3><i class="fa fa-truck"></i>Cari Kurir</h3>
        <div class="orders-tabs">
            <a href="#" class="orders-tab active" data-tab="pesanan-baru">Pesanan Baru <span class="badge bg-success">{{ $pesanan_baru->count() }}</span></a>
            <a href="#" class="orders-tab" data-tab="menunggu-konfirmasi">Menunggu Konfirmasi <span class="badge bg-warning">{{ $menunggu_konfirmasi->count() }}</span></a>
            <a href="#" class="orders-tab" data-tab="cari-kurir-lagi">Cari Kurir Lagi <span class="badge bg-danger">{{ $ditolak_kurir->count() }}</span></a>
        </div>
    </div>

    <!-- Controls -->
    <div class="select-controls d-flex gap-3 align-items-center mb-3">
        <div class="input-group" style="max-width: 400px; flex-grow: 1;">
             <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
             <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari pesanan, produk, atau supplier...">
        </div>
        <select id="sortSelect" class="form-select" style="width: auto;">
             <option value="newest">Urutkan: Terbaru</option>
             <option value="oldest">Urutkan: Terlama</option>
        </select>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Tab Pesanan Baru -->
        <div class="tab-panel active" id="pesanan-baru">
            @forelse($pesanan_baru as $order)
                @include('Staff_Purchasing.partials.order_card_cari_kurir', ['order' => $order, 'canAssign' => true])
            @empty
                <div class="text-center py-5"><h5 class="text-muted">Tidak ada pesanan baru.</h5></div>
            @endforelse
        </div>

        <!-- Tab Menunggu Konfirmasi -->
        <div class="tab-panel" id="menunggu-konfirmasi">
            @forelse($menunggu_konfirmasi as $order)
                @include('Staff_Purchasing.partials.order_card_cari_kurir', ['order' => $order, 'canAssign' => false])
            @empty
                <div class="text-center py-5"><h5 class="text-muted">Tidak ada pesanan menunggu konfirmasi.</h5></div>
            @endforelse
        </div>

        <!-- Tab Cari Kurir Lagi -->
        <div class="tab-panel" id="cari-kurir-lagi">
            @forelse($ditolak_kurir as $order)
                @include('Staff_Purchasing.partials.order_card_cari_kurir', ['order' => $order, 'canAssign' => true])
            @empty
                <div class="text-center py-5"><h5 class="text-muted">Tidak ada pesanan ditolak kurir.</h5></div>
            @endforelse
        </div>
    </div>

</div>

<!-- Modal Cari Kurir -->
<div class="modal fade" id="modalCariKurir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-truck me-2"></i>Pilih Kurir Pengantaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Filters in Modal -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Cari Kurir</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control" id="searchKurir" placeholder="Cari nama kurir">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Jenis Kendaraan</label>
                        <select class="form-select" id="filterKendaraan">
                            <option value="">Semua</option>
                            <option value="motor">Motor</option>
                            <option value="mobil">Mobil</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                         <label class="form-label">Status Online</label>
                         <select class="form-select" id="filterOnline">
                             <option value="">Semua</option>
                             <option value="Aktif">Aktif</option>
                             <option value="tidak_aktif">Tidak Aktif</option>
                         </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr><th>Nama</th><th>No Telp</th><th>Kendaraan</th><th>Status</th><th>Antar</th><th>Aksi</th></tr>
                        </thead>
                        <tbody id="kurirTableBody">
                            @forelse($kurirs as $kurir)
                            <tr data-nama="{{ strtolower($kurir->nama_lengkap) }}" 
                                data-kendaraan="{{ $kurir->kurir->jenis_kendaraan ?? 'Motor' }}" 
                                data-statusonline="{{ $kurir->status_online ?? 'aktif' }}">
                                <td>{{ $kurir->nama_lengkap }}</td>
                                <td>{{ $kurir->no_telepon }}</td>
                                <td>{{ ucfirst($kurir->kurir->jenis_kendaraan ?? '-') }}</td>
                                <td><span class="badge badge-online-{{ strtolower(str_replace([' ', '_'], '-', $kurir->status_online ?? 'aktif')) }}">{{ ucfirst($kurir->status_online) }}</span></td>
                                <td><span class="badge badge-antar-{{ strtolower(str_replace([' ', '_'], '-', $kurir->kurir->status_antar ?? 'siap')) }}">{{ $kurir->kurir->status_antar == 'sedang_antar' ? 'Sedang Antar' : ($kurir->kurir->status_antar == 'siap' ? 'Siap' : ($kurir->kurir->status_antar ?? 'Siap')) }}</span></td>
                                <td>
                                    <form action="{{ route('staff_purchasing.assign_kurir') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kode_pesanan" class="modalKodePesanan">
                                        <input type="hidden" name="id_kurir" value="{{ $kurir->id }}">
                                        <button type="submit" class="btn btn-primary btn-sm btnPilihKurir">Pilih</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center">Tidak ada kurir tersedia.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Tab Switching Logic with Persistence
    document.querySelectorAll('.orders-tab').forEach(tab => {
        tab.addEventListener('click', e => {
            e.preventDefault();
            const tabId = tab.dataset.tab;
            
            // UI Updates
            document.querySelectorAll('.orders-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            document.getElementById(tabId).classList.add('active');
            
            // Filter Update
            filterOrders(); 

            // URL Persistence
            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.pushState({}, '', url);
        });
    });

    // Handle Page Load: Initial Tab
    const urlParams = new URLSearchParams(window.location.search);
    const initialTab = urlParams.get('tab');
    if (initialTab) {
        const targetTab = document.querySelector(`.orders-tab[data-tab="${initialTab}"]`);
        if (targetTab) {
            targetTab.click();
        }
    }

    // Modal data passing
    const modalCariKurir = document.getElementById('modalCariKurir');
    const filterKendaraan = document.getElementById('filterKendaraan');
    
    modalCariKurir.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const kodePesanan = button.getAttribute('data-kode');
        const kendaraanPesanan = button.getAttribute('data-kendaraan');
        
        modalCariKurir.querySelectorAll('.modalKodePesanan').forEach(input => input.value = kodePesanan);
        
        // Auto-set filter kendaraan berdasarkan pesanan
        if (kendaraanPesanan && (kendaraanPesanan === 'motor' || kendaraanPesanan === 'mobil')) {
            filterKendaraan.value = kendaraanPesanan.toLowerCase();
        } else {
            filterKendaraan.value = ''; // Reset jika tidak ada/tidak valid
        }
        
        filterKurirTable(); // Trigger filter with vehicle filter
    });

    // Filter Logic (Main)
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    
    function filterOrders() {
        const activePanel = document.querySelector('.tab-panel.active');
        if(!activePanel) return;
        
        const search = searchInput.value.toLowerCase();
        const sort = sortSelect.value;
        const cards = Array.from(activePanel.querySelectorAll('.order-card'));
        
        // Sort
        cards.sort((a,b) => {
            const dateA = parseInt(a.dataset.date);
            const dateB = parseInt(b.dataset.date);
            return sort === 'newest' ? dateB - dateA : dateA - dateB;
        });
        cards.forEach(c => activePanel.appendChild(c));

        // Filter
        cards.forEach(card => {
            const text = (card.textContent).toLowerCase();
            if(text.includes(search)) card.classList.remove('hidden');
            else card.classList.add('hidden');
        });
    }

    searchInput.addEventListener('input', filterOrders);
    sortSelect.addEventListener('change', filterOrders);
    
    // Initial run
    filterOrders();
    
    // Kurir Filter (Modal)
    const searchKurir = document.getElementById('searchKurir');
    const filterOnline = document.getElementById('filterOnline');
    const kurirTableBody = document.getElementById('kurirTableBody');

    function filterKurirTable() {
        const searchText = searchKurir.value.toLowerCase();
        const online = filterOnline.value.toLowerCase();
        const kendaraan = filterKendaraan.value.toLowerCase();
        const rows = kurirTableBody.querySelectorAll('tr');

        rows.forEach(row => {
            if (!row.dataset.nama) return;
            
            const nameMatch = row.dataset.nama.includes(searchText);
            const onlineMatch = online === "" || row.dataset.statusonline.toLowerCase() === online;
            const kendaraanMatch = kendaraan === "" || row.dataset.kendaraan.toLowerCase() === kendaraan;

            if (nameMatch && onlineMatch && kendaraanMatch) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    searchKurir.addEventListener('input', filterKurirTable);
    filterOnline.addEventListener('change', filterKurirTable);
    filterKendaraan.addEventListener('change', filterKurirTable);

    document.querySelectorAll('.btnPilihKurir').forEach(btn => btn.addEventListener('click', () => {
         // Show toast logic if needed
    }));

    // Colorize Badges
    const badges = document.querySelectorAll('.badge-supplier');
    const colors = [
        { bg: "#BAE6FD", text: "#0369A1" }, { bg: "#FEF9C3", text: "#A16207" },
        { bg: "#FBCFE8", text: "#9D174D" }, { bg: "#A7F3D0", text: "#065F46" },
        { bg: "#DDD6FE", text: "#5B21B6" }, { bg: "#FECACA", text: "#991B1B" },
        { bg: "#FDE68A", text: "#B45309" }, { bg: "#F5D0FE", text: "#86198F" }
    ];
    badges.forEach(badge => {
        const text = badge.textContent.trim().toLowerCase();
        let hash = 0;
        for (let i = 0; i < text.length; i++) hash = text.charCodeAt(i) + ((hash << 5) - hash);
        const color = colors[Math.abs(hash) % colors.length];
        badge.style.setProperty('background-color', color.bg, 'important');
        badge.style.setProperty('color', color.text, 'important');
    });
});
</script>
@endsection
</body>
</html>
