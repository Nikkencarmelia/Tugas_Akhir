<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pengiriman Masuk - Kurir</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { background: #f5f7fa; }
    .orders-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;background:white;padding:1.5rem 2rem;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.08);}
    .orders-header h3{color:#198754;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;}
    .order-card{background:white;border-radius:16px;padding:1.5rem;margin-bottom:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.06);transition:all .3s ease;border:1px solid #f1f3f4;}
    .order-card:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(0,0,0,0.1);}
    .order-header{display:flex;justify-content:space-between;align-items:start;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid #e9ecef;}
    .order-meta{display:flex;flex-direction:column;font-size:14px;color:#6c757d;}
    .order-number{font-weight:700;color:#334155;font-size: 1.1rem;}
    .order-product{display:flex;align-items:center;gap:1rem;margin-bottom:1rem;padding:1rem;background:#f8f9fa;border-radius:12px;}
    .order-product img{width:80px;height:80px;object-fit:cover;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
    .order-product-details { flex-grow: 1; }
    .produk-lain { font-size: 12px; color: #6c757d; font-style: italic; }

.img-container { position: relative; width: 80px; height: 80px; }
    .img-container img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #f1f3f4; }
    .badge-supplier {
      position: absolute; top: 5px; right: 5px;
      font-size: .7rem; font-weight: 600;
      padding: .3rem .55rem; border-radius: .4rem; line-height: 1;
    }

    .order-actions{display:flex;gap:.5rem;margin-top:1rem;flex-wrap:wrap;}
    .btn-order{padding:6px 14px;border-radius:20px;font-size:13px;font-weight:500;transition:all .3s ease;}
    .select-controls{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;flex-wrap:wrap;gap:.5rem;}

    @media(max-width:768px){.orders-header{flex-direction:column;gap:1rem;text-align:center}.order-header{flex-direction:column;gap:.5rem;align-items:flex-start}.order-product{flex-direction:column;text-align:center}.order-actions{justify-content:center}}
  </style>
</head>

<body>
@extends('components.kurir')
@section('content')
<div class="container py-5">

  <div class="toast-container position-fixed top-0 end-0 p-4" style="z-index:9999;">
    <div id="toastSuccess" class="toast align-items-center text-bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" style="min-width:380px;font-size:1rem;border-radius:0.75rem;">
      <div class="d-flex"><div class="toast-body fw-semibold"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
    </div>
    <div id="toastReject" class="toast align-items-center text-bg-danger border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" style="min-width:380px;font-size:1rem;border-radius:0.75rem;">
      <div class="d-flex"><div class="toast-body fw-semibold"><i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
    </div>
  </div>

  <div class="orders-header">
    <h3>Pengiriman Masuk <span class="badge bg-success ms-2">{{ count($pengiriman_masuk) }}</span></h3>
    <small class="text-muted">Daftar pengiriman pesanan yang menunggu konfirmasi dari kurir (ID Akun: {{ Auth::id() }})</small>
  </div>

  <div class="select-controls">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="selectAll">
      <label class="form-check-label fw-semibold" for="selectAll">Pilih Semua</label>
    </div>
    <div class="d-flex gap-2">

      <button class="btn btn-success btn-sm btn-bulk-selected d-none" id="btnTerimaDipilih"><i class="fa-solid fa-check me-1"></i>Terima Dipilih</button>
      <button class="btn btn-danger btn-sm btn-bulk-selected d-none" id="btnTolakDipilih"><i class="fa-solid fa-xmark me-1"></i>Tolak Dipilih</button>

    </div>
  </div>

<form id="bulkActionForm" method="POST" action="">
      @csrf
  </form>

  @forelse($pengiriman_masuk as $order)
    @php
        $firstItem = $order->detailPesanan->first();
        $supplier = $firstItem && $firstItem->produk && $firstItem->produk->supplier ? $firstItem->produk->supplier->nama_supplier : 'Non-Supplier';

        $imagePath = $firstItem->gambar ?? '';
        if (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/')) {
            $imagePath = 'storage/' . $imagePath;
        }
        $src = asset($imagePath);

        $penerima = $order->nama_penerima ?? ($order->user->name ?? '-');
        $telepon = $order->no_telepon ?? ($order->user->no_telepon ?? '-');
        $kelurahan = $order->nama_kelurahan ?? '-';
        $metode = $order->opsi_pengiriman;
        $kendaraan = $order->kendaraan;

$status = $order->status_pesanan;
        $statusClass = 'status-' . $status;
        $statusLabel = ucwords(str_replace('_', ' ', $status));

        if(in_array($status, ['dibatalkan', 'ditolak_staff', 'ditolak_kurir'])) {
            $statusClass = 'status-dibatalkan';
            $statusLabel = 'Dibatalkan';
            if($status == 'ditolak_kurir') $statusLabel = 'Ditolak Kurir';
        }
        elseif(in_array($status, ['menunggu_konfirmasi_pembayaran', 'menunggu_verifikasi_pembayaran', 'menunggu_pembayaran_diverifikasi'])) {
            $statusClass = 'status-verif';
            $statusLabel = 'Menunggu Verifikasi';
        }
        elseif($status == 'menunggu_konfirmasi_kurir') {
            $statusClass = 'status-menunggu_konfirmasi_kurir';
            $statusLabel = 'Menunggu Konfirmasi Anda';
        }

        $icon = 'fa-box';
        if($status == 'selesai') $icon = 'fa-check-circle';
        elseif($statusClass == 'status-dibatalkan') $icon = 'fa-times-circle';
        elseif(in_array($status, ['dikirim', 'sedang_diantar'])) $icon = 'fa-truck';
        elseif($statusClass == 'status-menunggu_konfirmasi' || $statusClass == 'status-menunggu_konfirmasi_kurir') $icon = 'fa-hourglass-half';
        elseif($statusClass == 'status-verif') $icon = 'fa-clock';
        elseif($status == 'menunggu_pembayaran') $icon = 'fa-wallet';
        elseif($status == 'siap_diambil') $icon = 'fa-box-open';
        elseif($status == 'pesanan_telah_diambil') $icon = 'fa-check-double';
    @endphp
<div class="order-card">
  <div class="order-header">
    <div class="d-flex align-items-start gap-3">
      <div class="form-check mt-1">
        <input class="form-check-input orderCheckbox" type="checkbox" name="order_ids[]" value="{{ $order->id }}" form="bulkActionForm">
      </div>
      <div class="order-meta">
        <div class="order-number mb-2">#{{ $order->kode_pesanan }}</div>
        <div class="mb-2"><i class="fa-regular fa-calendar me-1"></i>{{ $order->created_at->format('d M Y') }}</div>
        <div class="d-flex flex-wrap gap-1">
            @if($metode == 'delivery')
            <span class="vehicle-badge text-uppercase">
                <i class="fa-solid fa-{{ $kendaraan == 'motor' ? 'motorcycle' : 'truck-pickup' }}"></i>
                {{ $kendaraan }}
            </span>
            @endif
            <span class="alamat-badge">
                <i class="fa-solid fa-location-dot"></i>
                {{ $kelurahan }} - {{ $order->alamat_lengkap }}
            </span>
            <span class="penerima-badge">
                <i class="fa-solid fa-user"></i>
                {{ Str::limit($penerima, 15) }}
            </span>
            <span class="phone-badge">
                <i class="fa-solid fa-phone"></i>
                {{ $telepon }}
            </span>
        </div>
      </div>
    </div>
    <div class="text-end">
        <div class="order-status {{ $statusClass }}">
            <i class="fas {{ $icon }} me-1"></i> {{ $statusLabel }}
        </div>
        <div class="text-success fw-bold small mt-2">
            Rp {{ number_format($order->ongkir, 0, ',', '.') }}
        </div>
    </div>
  </div>

  <div class="order-product">
    <div class="img-container">
      <img src="{{ $src }}" alt="{{ $firstItem->nama_produk ?? 'Produk' }}">
      <span class="badge-supplier">{{ $supplier }}</span>
    </div>
    <div class="order-product-details">
      <h6>{{ $firstItem->nama_produk ?? '-' }}</h6>
      <small>Jumlah: {{ $firstItem->quantity ?? 0 }} {{ $firstItem->satuan ?? 'pcs' }}</small>
        @if($order->detailPesanan->count() > 1)
        <div class="produk-lain">+ {{ $order->detailPesanan->count() - 1 }} produk lain</div>
        @endif
    </div>
  </div>

  <div class="order-actions">
    <form action="{{ route('kurir.terima', $order->id) }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-success btn-sm"><i class="fa-solid fa-check me-1"></i>Terima</button>
    </form>

    <form action="{{ route('kurir.tolak', $order->id) }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-danger-order btn-sm"><i class="fa-solid fa-xmark me-1"></i>Tolak</button>
    </form>

    <a href="{{ route('kurir.detail_pesanan', $order->id) }}" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
  </div>

</div>
@empty
<div class="text-center py-5">
    <h5 class="text-muted">Tidak ada pengiriman yang harus diproses.</h5>
</div>
@endforelse

</div>

  <!-- Modal Konfirmasi Bulk Action -->

  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Konfirmasi</h5>
          <button type="button" class="btn-close" id="btnCloseModal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modalBody">
          Apakah Anda yakin?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="btnCancelModal">Batal</button>
          <button type="button" class="btn btn-success" id="btnConfirmAction">Ya, Lanjutkan</button>
        </div>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded',()=>{
  const toastSuccess=new bootstrap.Toast(document.getElementById('toastSuccess'),{delay:3000});
  const toastReject=new bootstrap.Toast(document.getElementById('toastReject'),{delay:3000});

  const selectAll=document.getElementById('selectAll');
  const checkboxes=document.querySelectorAll('.orderCheckbox');

  const btnTerimaDipilih=document.getElementById('btnTerimaDipilih');
  const btnTolakDipilih=document.getElementById('btnTolakDipilih');
  const btnsBulkSelected = document.querySelectorAll('.btn-bulk-selected');
  const btnsBulkAll = document.querySelectorAll('.btn-bulk-all');

  const bulkActionForm = document.getElementById('bulkActionForm');

  function updateButtons() {
      const checkedCount = [...checkboxes].filter(cb => cb.checked).length;
      if (checkedCount > 0) {
          btnsBulkSelected.forEach(btn => btn.classList.remove('d-none'));
      } else {
          btnsBulkSelected.forEach(btn => btn.classList.add('d-none'));
      }
      selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
      selectAll.checked = checkedCount === checkboxes.length && checkboxes.length > 0;
  }

  selectAll.addEventListener('change', () => {
      checkboxes.forEach(cb => cb.checked = selectAll.checked);
      updateButtons();
  });

  checkboxes.forEach(cb => {
      cb.addEventListener('change', updateButtons);
  });

  const confirmationModalEl = document.getElementById('confirmationModal');
  const confirmationModal = new bootstrap.Modal(confirmationModalEl);
  const modalTitle = document.getElementById('modalTitle');
  const modalBody = document.getElementById('modalBody');
  const btnConfirmAction = document.getElementById('btnConfirmAction');
  const btnCloseModal = document.getElementById('btnCloseModal');
  const btnCancelModal = document.getElementById('btnCancelModal');
  let currentAction = '';

  function hideModal() {
      confirmationModal.hide();
  }

  btnCloseModal.addEventListener('click', hideModal);
  btnCancelModal.addEventListener('click', hideModal);

  btnTerimaDipilih.addEventListener('click', (e) => {
      e.preventDefault();
      modalTitle.textContent = 'Konfirmasi Terima';
      modalBody.textContent = 'Apakah Anda yakin ingin menerima semua pesanan yang dipilih?';
      currentAction = "{{ route('kurir.terima_dipilih') }}";
      confirmationModal.show();
  });

  btnTolakDipilih.addEventListener('click', (e) => {
      e.preventDefault();
      modalTitle.textContent = 'Konfirmasi Tolak';
      modalBody.textContent = 'Apakah Anda yakin ingin menolak semua pesanan yang dipilih?';
      currentAction = "{{ route('kurir.tolak_dipilih') }}";
      confirmationModal.show();
  });

  btnConfirmAction.addEventListener('click', () => {
    if(currentAction) {
        bulkActionForm.action = currentAction;
        bulkActionForm.submit();
    }
  });

if({{ session('success') ? 'true' : 'false' }}) toastSuccess.show();
  if({{ session('error') ? 'true' : 'false' }}) toastReject.show();

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

  colorizeBadges();
});
</script>
@endsection
</body>
</html>
