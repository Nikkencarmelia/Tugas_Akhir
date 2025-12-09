<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Pengiriman</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { background: #f5f7fa; }
    .orders-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;background:white;padding:1.5rem 2rem;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.08);}
    .orders-header h3{color:#2a522a;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;}
    .orders-header h3::before{content:"\f48b";font-family:"Font Awesome 6 Free";font-weight:900;color:#198754;}
    .orders-tabs{display:flex;gap:1rem;align-items:center;flex-wrap:wrap;}
    .orders-tab{padding:8px 16px;border-radius:20px;background:#f8f9fa;text-decoration:none;color:#6c757d;font-weight:500;border:1px solid #e9ecef;transition:all .3s ease;}
    .orders-tab.active{background:#198754;color:white;border-color:#198754;}
    .orders-tab:hover{background:#e9ecef;color:#495057;}
    .order-card{background:white;border-radius:16px;padding:1.5rem;margin-bottom:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.06);border:1px solid #f1f3f4;transition:all .3s ease;}
    .order-card:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(0,0,0,0.1);}
    .order-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid #e9ecef;}
    .order-meta{display:flex;flex-direction:column;font-size:14px;color:#6c757d;}
    .order-meta .alamat{background:#e8f5e9;color:#1b5e20;padding:3px 8px;border-radius:6px;display:inline-block;margin-top:4px;font-size:13px;}
    .order-number{font-weight:600;color:#495057;}
    .order-status{display:flex;align-items:center;gap:.5rem;padding:6px 12px;border-radius:20px;font-size:13px;font-weight:500;margin-bottom:1rem;}
    .status-selesai{background: var(--bs-success-bg-subtle); color: var(--bs-success);}
    .status-ditolak{background: var(--bs-danger-bg-subtle); color: var(--bs-danger);}
    .order-product{display:flex;align-items:center;gap:1rem;padding:1rem;background:#f8f9fa;border-radius:12px;}
    .order-product img{width:80px;height:80px;object-fit:cover;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
    .order-product-details{flex-grow:1;}
    .produk-lain { font-size: 12px; color: #6c757d; font-style: italic; }
    .order-actions{display:flex;gap:.5rem;margin-top:1rem;flex-wrap:wrap;}
    .tab-panel{display:none;}
    .tab-panel.active{display:block;}

    /* Badge Supplier Styles */
    .img-container { position: relative; width: 80px; height: 80px; }
    .img-container img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #f1f3f4; }
    .badge-supplier {
      position: absolute; top: 5px; right: 5px;
      font-size: .7rem; font-weight: 600;
      padding: .3rem .55rem; border-radius: .4rem; line-height: 1;
    }

    @media(max-width:768px){
      .orders-header{flex-direction:column;gap:1rem;text-align:center}
      .orders-tabs{justify-content:center;flex-wrap:wrap}
      .order-header{flex-direction:column;gap:.5rem;align-items:flex-start}
      .order-product{flex-direction:column;text-align:center}
      .order-actions{justify-content:center}
    }
  </style>
</head>
<body>
@extends('components.kurir')
@section('content')
<div class="container py-5">

  <!-- Toast -->
  <div class="toast-container position-fixed top-0 end-0 p-4" style="z-index:9999;">
    <div id="toastInfo" class="toast align-items-center text-bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" style="min-width:380px;font-size:1rem;border-radius:0.75rem;">
      <div class="d-flex">
        <div class="toast-body fw-semibold"><i class="fa-solid fa-circle-info me-2"></i>Detail pengiriman dibuka!</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>

  <!-- Header & Tabs -->
  <div class="orders-header">
    <h3>Riwayat Pengiriman</h3>
    <div class="orders-tabs">
      <a href="#" class="orders-tab active" data-tab="selesai">Selesai</a>
      <a href="#" class="orders-tab" data-tab="ditolak">Ditolak</a>
    </div>
  </div>

  <div class="tab-content">

    <!-- SELESAI -->
    <div id="selesai" class="tab-panel active">
      @foreach($riwayat as $order)
      @if($order['status'] == 'Selesai')
      <div class="order-card">
        <div class="order-header">
          <div class="order-meta">
            <div><i class="fa-regular fa-calendar me-1"></i>{{ date('d M Y', strtotime($order['tanggal'])) }}</div>
            <div><strong>Ongkir:</strong> <span class="text-success fw-semibold">{{ $order['ongkir'] }}</span></div>
            <div class="alamat"><i class="fa-solid fa-location-dot me-1"></i>{{ $order['alamat'] }}</div>
          </div>
          <div class="order-number">#{{ rand(1000000000,9999999999) }}</div>
        </div>
        <div class="order-status status-selesai"><i class="fa-solid fa-circle-check"></i> Selesai</div>
        <div class="order-product">
          <div class="img-container">
            <img src="{{ asset($order['gambar']) }}" alt="{{ $order['produk'] }}">
            <span class="badge-supplier">{{ $order['supplier'] }}</span>
          </div>
          <div class="order-product-details">
            <h6>{{ $order['produk'] }}</h6>
            <small>{{ $order['jumlah'] }}</small>
            @if(isset($order['total_produk']) && $order['total_produk'] > 1)
              <div class="produk-lain">+ {{ $order['total_produk'] - 1 }} produk lain</div>
            @endif
          </div>
        </div>
        <div class="order-actions">
          <button class="btn btn-outline-success btn-sm btn-detail"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</button>
        </div>
      </div>
      @endif
      @endforeach
    </div>

    <!-- DITOLAK -->
    <div id="ditolak" class="tab-panel">
      @foreach($riwayat as $order)
      @if($order['status'] == 'Ditolak')
      <div class="order-card">
        <div class="order-header">
          <div class="order-meta">
            <div><i class="fa-regular fa-calendar me-1"></i>{{ date('d M Y', strtotime($order['tanggal'])) }}</div>
            <div><strong>Ongkir:</strong> <span class="text-danger fw-semibold">{{ $order['ongkir'] }}</span></div>
            <div class="alamat"><i class="fa-solid fa-location-dot me-1"></i>{{ $order['alamat'] }}</div>
          </div>
          <div class="order-number">#{{ rand(1000000000,9999999999) }}</div>
        </div>
        <div class="order-status status-ditolak"><i class="fa-solid fas fa-times-circle"></i> Ditolak</div>
        <div class="order-product">
          <div class="img-container">
            <img src="{{ asset($order['gambar']) }}" alt="{{ $order['produk'] }}">
            <span class="badge-supplier">{{ $order['supplier'] }}</span>
          </div>
          <div class="order-product-details">
            <h6>{{ $order['produk'] }}</h6>
            <small>{{ $order['jumlah'] }}</small>
            @if(isset($order['total_produk']) && $order['total_produk'] > 1)
              <div class="produk-lain">+ {{ $order['total_produk'] - 1 }} produk lain</div>
            @endif
          </div>
        </div>
        <div class="order-actions">
          <button class="btn btn-outline-success btn-sm btn-detail"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</button>
        </div>
      </div>
      @endif
      @endforeach
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded',()=>{
  // Tab switching
  const tabs=document.querySelectorAll('.orders-tab');
  const panels=document.querySelectorAll('.tab-panel');
  tabs.forEach(tab=>{
    tab.addEventListener('click',e=>{
      e.preventDefault();
      tabs.forEach(t=>t.classList.remove('active'));
      panels.forEach(p=>p.classList.remove('active'));
      tab.classList.add('active');
      document.getElementById(tab.dataset.tab).classList.add('active');
    });
  });

  // Toast on "Lihat Detail"
  const toastInfo=new bootstrap.Toast(document.getElementById('toastInfo'),{delay:2000});
  document.querySelectorAll('.btn-detail').forEach(btn=>{
    btn.addEventListener('click',()=>toastInfo.show());
  });

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
