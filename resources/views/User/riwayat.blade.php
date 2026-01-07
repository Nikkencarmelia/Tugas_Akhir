<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .orders-header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .orders-header h3 {
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

.orders-tabs {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: wrap;
            background: transparent;
            padding: 0;
            border-radius: 0;
            margin-bottom: 2rem;
        }

        .orders-tab {
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            color: #6c757d;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid #dee2e6;
            background: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 14px;
        }

        .orders-tab:hover {
            background: #e9ecef;
            color: #495057;
        }

        .orders-tab.active {
            background: #198754;
            color: white !important;
            border-color: #198754;
            box-shadow: 0 4px 10px rgba(25, 135, 84, 0.2);
        }

        .filter-row {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            align-items: center;
        }

        .search-input-group {
            max-width: 400px;
            flex-grow: 1;
        }

        .search-input-group .form-control {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 0.6rem 1rem;
        }

.order-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
            transition: transform 0.2s;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .order-meta {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .order-number {
            font-weight: 700;
            color: #334155;
            font-size: 1rem;
        }

        .detail-number {
            font-weight: 700;
            color: #198754;
            font-size: 1.1rem;
        }

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

.status-menunggu_konfirmasi { background: #f1f3f5; color: #495057; }
        .status-menunggu_pembayaran { background: #fff4e6; color: #d9480f; }
        .status-diproses { background: #fef9c3; color: #854d0e; }
        .status-dikirim { background: #e0f2fe; color: #0369a1; }
        .status-selesai { background: #dcfce7; color: #166534; }
        .status-dibatalkan { background: #fee2e2; color: #991b1b; }
        .status-menunggu_konfirmasi_pembayaran { background: #fff7ed; color: #9a3412; }

.status-sedang_diantar { background: #e0f2fe; color: #0369a1; }
        .status-siap_diambil { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .status-pesanan_telah_diambil { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

        .metode { font-size: 12px; color: #64748b; margin-top: 4px; }

        .metode-badge {
            background: #e3f2fd;
            color: #0d47a1;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .vehicle-badge {
            background: #fff3ce;
            color: #856404;
            padding: 2px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            margin-top: 4px;
            border: 1px solid #ffeaa7;
        }

        .order-product {
            display: flex;
            gap: 1rem;
            margin: 1rem 0;
            align-items: center;
        }

        .order-product img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #f1f5f9;
        }

        .order-product-details h6 {
            margin: 0;
            font-weight: 600;
            color: #334155;
        }

        .order-actions {
            display: flex;
            justify-content: flex-start;
            gap: 0.75rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
        }

        .btn-order-rounded {
            padding: 7px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            transition: all .2s;
        }

        .btn-primary-order {
            background: #198754;
            color: white;
            border: 1px solid #198754;
        }
        .btn-primary-order:hover {
            background: #157347;
            border-color: #157347;
            color: white;
        }
        .btn-outline-success-order {
            background: white;
            color: #0d6efd;
            border: 1px solid #0d6efd;
        }
        .btn-outline-success-order:hover {
            background: #0d6efd;
            color: white;
        }
        .btn-danger-order {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .btn-danger-order:hover {
            background: #fecaca;
        }

        .no-orders { text-align: center; padding: 3rem; color: #94a3b8; }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }

        @media (max-width: 768px) {
            .filter-row { flex-direction: column; align-items: stretch; }
            .search-input-group { max-width: 100%; }
        }
    </style>

    <div class="container py-5">

        <div class="toast-container position-fixed top-0 end-0 p-4" style="z-index: 10000;">
            <div id="liveToast" class="toast align-items-center text-bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-semibold">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        <span id="toastMessage">Pesanan berhasil dibuat!</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <div class="orders-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h3>Pesanan Anda</h3>
                <div class="orders-tabs">
                    <a href="#" class="orders-tab active" data-tab="konfirmasi">Menunggu Konfirmasi</a>
                    <a href="#" class="orders-tab" data-tab="menunggu">Belum Bayar</a>
                    <a href="#" class="orders-tab" data-tab="proses">Diproses</a>
                    <a href="#" class="orders-tab" data-tab="dikirim">Dikirim</a>
                    <a href="#" class="orders-tab" data-tab="selesai">Selesai</a>
                    <a href="#" class="orders-tab" data-tab="dibatalkan">Dibatalkan</a>
                </div>
            </div>

            <form id="filterForm" action="{{ route('pemesanan.riwayat.pesanan') }}" method="GET" class="filter-row">
                <div class="input-group search-input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari kode pesanan atau nama produk..." value="{{ request('search') }}">
                </div>
                <select name="sort" id="sortSelect" class="form-select w-auto">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                </select>
            </form>
        </div>

        <div id="tabContent">

            <div class="tab-panel active" id="panel-konfirmasi">
                @include('User.partials._order_list', ['collection' => $konfirmasi_pesanan, 'title' => 'menunggu konfirmasi'])
            </div>
            <div class="tab-panel" id="panel-menunggu">
                @include('User.partials._order_list', ['collection' => $menunggu_pembayaran, 'title' => 'menunggu pembayaran'])
            </div>
            <div class="tab-panel" id="panel-proses">
                @include('User.partials._order_list', ['collection' => $diproses, 'title' => 'sedang diproses'])
            </div>
            <div class="tab-panel" id="panel-dikirim">
                @include('User.partials._order_list', ['collection' => $dikirim, 'title' => 'sedang dikirim'])
            </div>
            <div class="tab-panel" id="panel-selesai">
                @include('User.partials._order_list', ['collection' => $selesai, 'title' => 'selesai'])
            </div>
            <div class="tab-panel" id="panel-dibatalkan">
                @include('User.partials._order_list', ['collection' => $dibatalkan, 'title' => 'dibatalkan atau ditolak'])
            </div>
        </div>
    </div>

    @extends('components.user')
    @section('content')

    @endsection

<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" id="cancelOrderModalLabel">Konfirmasi Pembatalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    Apakah Anda yakin ingin membatalkan pesanan ini? Stok yang telah dikurangi akan dikembalikan ke gudang.
                </div>
                <div class="modal-footer border-top-0 px-4 pb-4">
                    <button type="button" class="btn btn-light px-4 fw-semibold" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="confirmCancelBtn" class="btn btn-danger px-4 fw-semibold">Ya, Batalkan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {

            @if(session('checkout_success') || session('success'))
                const toastEl = document.getElementById('liveToast');
                const toastMessage = document.getElementById('toastMessage');
                @if(session('success'))
                    toastMessage.textContent = '{{ session('success') }}';
                @endif
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            @endif

            let activeTab = '{{ request('tab', 'konfirmasi') }}';

$('.orders-tab').removeClass('active');
            $(`.orders-tab[data-tab="${activeTab}"]`).addClass('active');
            $('.tab-panel').removeClass('active');
            $(`#panel-${activeTab}`).addClass('active');

$('.orders-tab').on('click', function(e) {
                e.preventDefault();
                const tab = $(this).data('tab');
                activeTab = tab;

                $('.orders-tab').removeClass('active');
                $(this).addClass('active');

                $('.tab-panel').removeClass('active');
                $(`#panel-${tab}`).addClass('active');

const url = new URL(window.location);
                url.searchParams.set('tab', tab);
                window.history.pushState({}, '', url);
            });

let searchTimeout;
            $('input[name="search"], #sortSelect').on('input change', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    fetchFilteredData();
                }, 300);
            });

            function fetchFilteredData(url = '{{ route('pemesanan.riwayat.pesanan') }}') {
                const search = $('input[name="search"]').val();
                const sort = $('#sortSelect').val();

                $.ajax({
                    url: url,
                    data: { search, sort },
                    dataType: 'json',
                    success: function(data) {
                        $('#panel-konfirmasi').html(data.konfirmasi);
                        $('#panel-menunggu').html(data.menunggu);
                        $('#panel-proses').html(data.proses);
                        $('#panel-dikirim').html(data.dikirim);
                        $('#panel-selesai').html(data.selesai);
                        $('#panel-dibatalkan').html(data.dibatalkan);

}
                });
            }

$(document).on('click', '.ajax-pagination a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                fetchFilteredData(url);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

let cancelUrl = '';
            window.confirmCancel = function(url) {
                cancelUrl = url;
                const modal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
                modal.show();
            }

            $('#confirmCancelBtn').on('click', function() {
                if (cancelUrl) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = cancelUrl;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>
