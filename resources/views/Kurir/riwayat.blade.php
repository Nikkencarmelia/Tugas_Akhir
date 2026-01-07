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
    .orders-header h3{color:#198754;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;}
    .orders-tabs{display:flex;gap:1rem;align-items:center;flex-wrap:wrap;}
    .orders-tab{padding:8px 16px;border-radius:20px;background:white;text-decoration:none;color:#6c757d;font-weight:500;border:1px solid #dee2e6;transition:all .3s ease;}
    .orders-tab.active{background:#198754;color:white;border-color:#198754;}
    .orders-tab:hover{background:#e9ecef;color:#495057;}
    .order-card{background:white;border-radius:16px;padding:1.5rem;margin-bottom:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.06);border:1px solid #f1f3f4;transition:all .3s ease;}
    .order-card:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(0,0,0,0.1);}
    .order-header{display:flex;justify-content:space-between;align-items:start;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid #e9ecef;}
    .order-meta{display:flex;flex-direction:column;font-size:14px;color:#6c757d;}
    .order-number{font-weight:700;color:#334155;font-size: 1.1rem;}
    .order-product{display:flex;align-items:center;gap:1rem;padding:1rem;background:#f8f9fa;border-radius:12px;}
    .order-product img{width:80px;height:80px;object-fit:cover;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
    .order-product-details{flex-grow:1;}
    .produk-lain { font-size: 12px; color: #6c757d; font-style: italic; }
    .order-actions{display:flex;gap:.5rem;margin-top:1rem;flex-wrap:wrap;}
    .tab-panel{display:none;}
    .tab-panel.active{display:block;}

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

<div class="orders-header">
    <h3>Riwayat Pengiriman</h3>
    <div class="orders-tabs">
      <a href="#" class="orders-tab active" data-tab="selesai">Selesai</a>
      <a href="#" class="orders-tab" data-tab="ditolak">Ditolak/Dibatalkan</a>
    </div>
  </div>

  <div class="tab-content">

<div id="selesai" class="tab-panel active">
      @forelse($selesai as $order)
      @php
          $firstItem = $order->detailPesanan->first();
          $productName = $firstItem ? ($firstItem->produk->nama_produk ?? $firstItem->nama_produk) : 'Produk';
          $supplierName = $firstItem && $firstItem->produk && $firstItem->produk->supplier ? $firstItem->produk->supplier->nama_supplier : 'Non-Supplier';

          $imagePath = $firstItem->gambar ?? '';
          if (str_starts_with($imagePath, 'images/')) {
              $src = asset($imagePath);
          } elseif (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/') && $imagePath) {
              $src = asset('storage/' . $imagePath);
          } else {
              $src = $imagePath ? asset($imagePath) : asset('images/default-product.png');
          }

          $penerima = $order->nama_penerima ?? ($order->user->name ?? '-');
          $telepon = $order->no_telepon ?? ($order->user->no_telepon ?? '-');
          $kelurahan = $order->nama_kelurahan ?? '-';
          $metode = $order->opsi_pengiriman;
          $kendaraan = $order->kendaraan;
      @endphp
      <div class="order-card">
        <div class="order-header">
          <div class="order-meta">
            <div class="order-number mb-2">#{{ $order->kode_pesanan }}</div>
            <div class="mb-2 small text-muted"><i class="fa-regular fa-calendar me-1"></i>{{ $order->created_at->format('d M Y') }}</div>
            <div class="d-flex flex-wrap gap-1">
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
          <div class="text-end">
             <div class="order-status status-selesai">
                <i class="fas fa-check-circle me-1"></i> Selesai
             </div>
             <div class="text-success fw-bold small mt-2">
                Rp {{ number_format($order->ongkir, 0, ',', '.') }}
             </div>
          </div>
        </div>
        <div class="order-product">
          <div class="img-container">
            <img src="{{ $src }}" alt="Produk">
            <span class="badge-supplier">{{ $supplierName }}</span>
          </div>
          <div class="order-product-details">
            <h6>{{ $productName }}</h6>
            <small>{{ $firstItem->quantity ?? 1 }} x Rp {{ number_format($firstItem->harga_satuan ?? 0, 0, ',', '.') }}</small>
            @if($order->detailPesanan->count() > 1)
              <div class="produk-lain">+ {{ $order->detailPesanan->count() - 1 }} produk lain</div>
            @endif
          </div>
        </div>
        <div class="order-actions">
          <a href="{{ route('kurir.detail_pesanan', $order->id) }}?tab=selesai" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
        </div>
      </div>
      @empty
      <div class="text-center py-5 text-muted">Tidak ada riwayat pengiriman selesai.</div>
      @endforelse
    </div>

<div id="ditolak" class="tab-panel">
      @forelse($dibatalkan as $item)
      @php
          $isTugasKurir = $item instanceof \App\Models\TugasKurir;
          $order = $isTugasKurir ? $item->pemesanan : $item;
          if(!$order) continue;

          if ($isTugasKurir) {
              $statusLabel = 'Dibatalkan oleh Anda';
              $statusIcon = 'fa-person-circle-xmark';
              $dateDisplay = $item->created_at;
          } else {
              $statusLabel = ($order->status_pesanan == 'ditolak_staff') ? 'Pesanan Dibatalkan oleh Staff' : 'Pesanan Dibatalkan';
              $statusIcon = 'fa-times-circle';
              $dateDisplay = $order->updated_at;
          }

          $firstItem = $order->detailPesanan->first();
          $productName = $firstItem ? ($firstItem->produk->nama_produk ?? $firstItem->nama_produk) : 'Produk';
          $supplierName = $firstItem && $firstItem->produk && $firstItem->produk->supplier ? $firstItem->produk->supplier->nama_supplier : 'Non-Supplier';

          $imagePath = $firstItem->gambar ?? '';
          if (str_starts_with($imagePath, 'images/')) {
              $src = asset($imagePath);
          } elseif (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/') && $imagePath) {
              $src = asset('storage/' . $imagePath);
          } else {
              $src = $imagePath ? asset($imagePath) : asset('images/default-product.png');
          }

          $penerima = $order->nama_penerima ?? ($order->user->name ?? '-');
          $telepon = $order->no_telepon ?? ($order->user->no_telepon ?? '-');
          $kelurahan = $order->nama_kelurahan ?? '-';
      @endphp
      <div class="order-card">
        <div class="order-header">
          <div class="order-meta">
            <div class="order-number mb-2">#{{ $order->kode_pesanan }}</div>
            <div class="mb-2 small text-muted"><i class="fa-regular fa-calendar me-1"></i>{{ $dateDisplay->format('d M Y, H:i') }}</div>
            <div class="d-flex flex-wrap gap-1">
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
          <div class="text-end">
             <div class="order-status status-dibatalkan">
                <i class="fas {{ $statusIcon }} me-1"></i> {{ $statusLabel }}
             </div>
             <div class="text-danger fw-bold small mt-2">
                Rp {{ number_format($order->ongkir, 0, ',', '.') }}
             </div>
          </div>
        </div>
        <div class="order-product">
          <div class="img-container">
            <img src="{{ $src }}" alt="Produk">
            <span class="badge-supplier">{{ $supplierName }}</span>
          </div>
          <div class="order-product-details">
            <h6>{{ $productName }}</h6>
            <small>{{ $firstItem->quantity ?? 1 }} x Rp {{ number_format($firstItem->harga_satuan ?? 0, 0, ',', '.') }}</small>
            @if($order->detailPesanan->count() > 1)
              <div class="produk-lain">+ {{ $order->detailPesanan->count() - 1 }} produk lain</div>
            @endif
          </div>
        </div>
        <div class="order-actions">
          <a href="{{ route('kurir.detail_pesanan', $order->id) }}?tab=ditolak" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
        </div>
      </div>
      @empty
      <div class="text-center py-5 text-muted">Tidak ada riwayat ditolak atau dibatalkan.</div>
      @endforelse
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded',()=>{

  const tabs=document.querySelectorAll('.orders-tab');
  const panels=document.querySelectorAll('.tab-panel');

  function switchTab(tabId) {
      tabs.forEach(t => {
          if(t.dataset.tab === tabId) t.classList.add('active');
          else t.classList.remove('active');
      });
      panels.forEach(p => {
          if(p.id === tabId) p.classList.add('active');
          else p.classList.remove('active');
      });

      const url = new URL(window.location);
      url.searchParams.set('tab', tabId);
      window.history.replaceState({}, '', url);
  }

  tabs.forEach(tab=>{
    tab.addEventListener('click',e=>{
      e.preventDefault();
      switchTab(tab.dataset.tab);
    });
  });

const urlParams = new URLSearchParams(window.location.search);
  const activeTab = urlParams.get('tab');
  if (activeTab && document.getElementById(activeTab)) {
      switchTab(activeTab);
  }

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
