<!DOCTYPE html>
<html lang="id">
<head>
    <title>Detail Pengiriman</title>
</head>
<body>
@extends('Components.kurir')

@section('content')
<style>
    .detail-header {
      display: flex; justify-content: space-between; align-items: center;
      margin-bottom: 2rem; background: white; padding: 1.5rem 2rem;
      border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    .detail-header h3 {
      color: #198754; font-weight: 700; margin: 0;
      display: flex; align-items: center; gap: .5rem;
    }
    .detail-card {
      background: white; border-radius: 16px; padding: 1.5rem;
      margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
      transition: all .3s ease; border: 1px solid #f1f3f4;
    }
    .detail-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    .detail-header-section {
      display: flex; justify-content: space-between; align-items: center;
      margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef;
    }
    .detail-meta { display: flex; gap: 2rem; font-size: 14px; color: #6c757d; }
    .detail-number { font-weight: 700; color: #334155; font-size: 1.1rem; }
    .product-item {
      display: flex; align-items: center; gap: 1rem;
      margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 12px;
    }
    .product-item img {
      width: 80px; height: 80px; object-fit: cover;
      border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .product-details { flex-grow: 1; }
    .total-section {
      display: flex; justify-content: space-between; align-items: center;
      margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e9ecef;
    }

.img-container { position: relative; width: 80px; height: 80px; }
    .img-container img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #dee2e6; }
    .badge-supplier {
      position: absolute; top: 5px; right: 5px;
      font-size: .7rem; font-weight: 600;
      padding: .3rem .55rem; border-radius: .4rem; line-height: 1;
    }

    @media (max-width: 768px) {
      .detail-header { flex-direction: column; gap: 1rem; text-align: center; }
      .detail-header-section { flex-direction: column; gap: .5rem; align-items: flex-start; }
      .product-item { flex-direction: column; text-align: center; }
      .detail-meta { flex-direction: column; gap: .5rem; }
    }
</style>

@php
    $tab = request('tab');
    $backUrl = route('kurir.pengiriman');

    if (in_array($tab, ['menunggu', 'dikirim'])) {
        $backUrl = route('kurir.status_pengiriman', ['tab' => $tab]);
    } elseif (in_array($tab, ['selesai', 'ditolak'])) {
        $backUrl = route('kurir.riwayat', ['tab' => $tab]);
    }
@endphp

<div class="container py-5">

  <div class="mb-3">
    <a href="{{ $backUrl }}" class="btn btn-outline-secondary btn-sm border-0">
        <i class="fa-solid fa-chevron-left me-1"></i> Kembali
    </a>
  </div>

<div class="detail-header">
    <h3><i class="fa-solid fa-circle-info"></i> Detail Pengiriman</h3>
    <div class="text-end">
        <div class="detail-number">#{{ $pemesanan->kode_pesanan }}</div>
        <div class="small text-muted">{{ $pemesanan->created_at->format('d M Y, H:i') }}</div>
    </div>
  </div>

<div class="detail-card">
    <h5 class="mb-3 fw-bold text-success"><i class="fa-solid fa-location-dot me-2"></i>Alamat Pengiriman</h5>
    <div class="p-3 bg-light rounded-3 border-start border-success border-4">
        <p class="mb-1 fw-bold text-dark" style="font-size: 1.1rem;">{{ $pemesanan->nama_penerima }}</p>
        <p class="mb-2 text-success fw-semibold"><i class="fa-solid fa-phone me-1"></i> {{ $pemesanan->no_telepon }}</p>
        <p class="mb-1 text-muted">{{ $pemesanan->alamat_lengkap }}</p>
        <p class="mb-0 fw-bold text-dark">
          {{ $pemesanan->nama_kelurahan }}, {{ $pemesanan->nama_kecamatan }} - {{ $pemesanan->kode_pos }}
        </p>
    </div>
  </div>

<div class="detail-card">
    <h5 class="fw-bold mb-3 text-success"><i class="fa-solid fa-box me-2"></i>Produk Dikirim</h5>

    @foreach($pemesanan->detailPesanan as $item)
    @php
        $supplierName = $item->produk && $item->produk->supplier ? $item->produk->supplier->nama_supplier : 'Non-Supplier';
        $imagePath = $item->gambar ?? '';
        if (str_starts_with($imagePath, 'images/')) {
            $src = asset($imagePath);
        } else {
            $src = $imagePath ? asset($imagePath) : asset('images/default-product.png');
        }
    @endphp
    <div class="product-item">
      <div class="img-container">
        <img src="{{ $src }}" alt="{{ $item->nama_produk }}">
        <span class="badge-supplier">{{ $supplierName }}</span>
      </div>

      <div class="product-details">
        <h6 class="fw-bold mb-1">{{ $item->nama_produk }}</h6>
        <p class="small text-muted mb-0">Jumlah: <span class="fw-bold text-dark">{{ $item->quantity }} item - {{ $item->jumlah_satuan }} {{ $item->satuan }}</span></p>
      </div>
    </div>
    @endforeach

    <div class="total-section">
      <p class="mb-0 fw-bold text-dark">Ongkos Kirim</p>
      <p class="mb-0 fw-bold text-success fs-5">Rp {{ number_format($pemesanan->ongkir, 0, ',', '.') }}</p>
    </div>

  </div>

</div>

<script>
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

document.addEventListener('DOMContentLoaded', colorizeBadges);
</script>

@endsection
</body>
</html>
