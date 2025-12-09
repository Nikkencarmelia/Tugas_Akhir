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
    .orders-header h3{color:#2a522a;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;}
    .orders-header h3::before{content:"\f0d1";font-family:"Font Awesome 6 Free";font-weight:900;color:#198754;}
    .order-card{background:white;border-radius:16px;padding:1.5rem;margin-bottom:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.06);transition:all .3s ease;border:1px solid #f1f3f4;}
    .order-card:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(0,0,0,0.1);}
    .order-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid #e9ecef;}
    .order-meta{display:flex;flex-direction:column;font-size:14px;color:#6c757d;}
    .order-meta .alamat{background:#e8f5e9;color:#1b5e20;padding:3px 8px;border-radius:6px;display:inline-block;margin-top:4px;font-size:13px;}
    .order-number{font-weight:600;color:#495057;}
    .order-product{display:flex;align-items:center;gap:1rem;margin-bottom:1rem;padding:1rem;background:#f8f9fa;border-radius:12px;}
    .order-product img{width:80px;height:80px;object-fit:cover;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
    .order-product-details { flex-grow: 1; }
    .produk-lain { font-size: 12px; color: #6c757d; font-style: italic; }

    /* Badge Supplier Styles */
    .img-container { position: relative; width: 80px; height: 80px; }
    .img-container img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #f1f3f4; }
    .badge-supplier {
      position: absolute; top: 5px; right: 5px;
      font-size: .7rem; font-weight: 600;
      padding: .3rem .55rem; border-radius: .4rem; line-height: 1;
    }

    .order-actions{display:flex;gap:.5rem;margin-top:1rem;flex-wrap:wrap;}
    .btn-order{padding:6px 14px;border-radius:20px;font-size:13px;font-weight:500;transition:all .3s ease;}
    .btn-primary-order{background:#198754;color:white;border:1px solid #198754;}
    .btn-primary-order:hover{background:#146c43;border-color:#146c43;}
    .btn-danger-order{background:#dc3545;color:white;border:1px solid #dc3545;}
    .btn-danger-order:hover{background:#b02a37;border-color:#b02a37;}
    .btn-secondary-order{background:#f8f9fa;color:#495057;border:1px solid #dee2e6;}
    .btn-secondary-order:hover{background:#e9ecef;color:#212529;}
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
      <div class="d-flex"><div class="toast-body fw-semibold"><i class="fa-solid fa-circle-check me-2"></i>Pengiriman telah diterima!</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
    </div>
    <div id="toastReject" class="toast align-items-center text-bg-danger border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" style="min-width:380px;font-size:1rem;border-radius:0.75rem;">
      <div class="d-flex"><div class="toast-body fw-semibold"><i class="fa-solid fa-triangle-exclamation me-2"></i>Pengiriman telah ditolak!</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
    </div>
  </div>

  <div class="orders-header">
    <h3>Pengiriman Masuk <span class="badge bg-success ms-2">{{ count($pengiriman_masuk) }}</span></h3>
    <small class="text-muted">Daftar pengiriman pesanan yang menunggu konfirmasi dari kurir</small>
  </div>

  <div class="select-controls">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="selectAll">
      <label class="form-check-label fw-semibold" for="selectAll">Pilih Semua</label>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-success btn-sm" id="btnTerimaSemua"><i class="fa-solid fa-check me-1"></i>Terima Semua</button>
      <button class="btn btn-danger btn-sm" id="btnTolakSemua"><i class="fa-solid fa-xmark me-1"></i>Tolak Semua</button>
    </div>
  </div>

  @foreach($pengiriman_masuk as $order)
<div class="order-card">
  <div class="order-header">
    <div class="d-flex align-items-start gap-2">
      <div class="form-check">
        <input class="form-check-input orderCheckbox" type="checkbox">
      </div>
      <div class="order-meta">
        <div><i class="fa-regular fa-calendar me-1"></i>{{ date('d M Y', strtotime($order['tanggal'])) }}</div>
        <div class="text-success fw-semibold"><i class="fa-solid fa-truck me-1"></i> Ongkir: {{ $order['ongkir'] }}</div>
        <div class="alamat"><i class="fa-solid fa-location-dot me-1"></i>{{ $order['alamat'] }}</div>
      </div>
    </div>
    <div class="order-number">#{{ rand(1000000000,9999999999) }}</div>
  </div>

  <div class="order-product">
    <div class="img-container">
      <img src="{{ asset($order['gambar']) }}" alt="{{ $order['produk'] }}">
      <span class="badge-supplier">{{ $order['supplier'] }}</span>
    </div>
    <div class="order-product-details">
      <h6>{{ $order['produk'] }}</h6>
      <small>Jumlah: {{ $order['jumlah'] }}</small>
      @if(isset($order['total_produk']) && $order['total_produk'] > 1)
        <div class="produk-lain">+ {{ $order['total_produk'] - 1 }} produk lain</div>
      @endif
    </div>
  </div>

  <div class="order-actions">
  <button class="btn btn-success btnTerima btn-sm"><i class="fa-solid fa-check me-1"></i>Terima</button>
  <button class="btn btn-outline-danger btnTolak btn-sm"><i class="fa-solid fa-xmark me-1"></i>Tolak</button>
  <a href="/kurir/detail" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
</div>

</div>
@endforeach


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded',()=>{
  const toastSuccess=new bootstrap.Toast(document.getElementById('toastSuccess'),{delay:3000});
  const toastReject=new bootstrap.Toast(document.getElementById('toastReject'),{delay:3000});
  const selectAll=document.getElementById('selectAll');
  const checkboxes=document.querySelectorAll('.orderCheckbox');
  const btnTerimaSemua=document.getElementById('btnTerimaSemua');
  const btnTolakSemua=document.getElementById('btnTolakSemua');

  document.querySelectorAll('.btnTerima').forEach(btn=>btn.addEventListener('click',()=>toastSuccess.show()));
  document.querySelectorAll('.btnTolak').forEach(btn=>btn.addEventListener('click',()=>toastReject.show()));
  selectAll.addEventListener('change',()=>checkboxes.forEach(cb=>cb.checked=selectAll.checked));
  btnTerimaSemua.addEventListener('click',()=>{if([...checkboxes].filter(cb=>cb.checked).length>0)toastSuccess.show()});
  btnTolakSemua.addEventListener('click',()=>{if([...checkboxes].filter(cb=>cb.checked).length>0)toastReject.show()});

  // Colorize supplier badges
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
