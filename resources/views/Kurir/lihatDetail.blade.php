<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Pengiriman</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f5f7fa; }
    .detail-header {
      display: flex; justify-content: space-between; align-items: center;
      margin-bottom: 2rem; background: white; padding: 1.5rem 2rem;
      border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    .detail-header h3 {
      color: #2a522a; font-weight: 700; margin: 0;
      display: flex; align-items: center; gap: .5rem;
    }
    .detail-header h3::before {
      content: "\f48b"; font-family: "Font Awesome 6 Free";
      font-weight: 900; color: #198754;
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
    .detail-number { font-weight: 600; color: #495057; }
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

    /* Badge Supplier Styles */
    .img-container { position: relative; width: 80px; height: 80px; }
    .img-container img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #f1f3f4; }
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
</head>

<body>
   @extends('components.kurir')
@section('content')

<div class="container py-5">

  <!-- HEADER -->
  <div class="detail-header">
    <h3>Detail Pengiriman</h3>
    <small class="text-muted">Informasi alamat & barang dikirim</small>
  </div>

  <!-- BAGIAN ALAMAT -->
  <div class="detail-card">
    <div class="detail-header-section">
      <div class="detail-meta">
        <div>Tanggal: {{ date('d M Y', strtotime($detail['tanggal'])) }}</div>
      </div>
    </div>

    <h5 class="mb-3 fw-bold">Alamat Pengiriman</h5>
    <p class="mb-1 fw-semibold">{{ $detail['nama_penerima'] }} ({{ $detail['no_telp'] }})</p>
    <p class="mb-1">{{ $detail['alamat_jalan'] }}</p>
    <p class="mb-1">
      {{ $detail['kelurahan'] }}, {{ $detail['kecamatan'] }}, {{ $detail['kabupaten'] }} - {{ $detail['kode_pos'] }}
    </p>
  </div>

  <!-- BAGIAN PRODUK -->
  <div class="detail-card">
    <h5 class="fw-bold mb-3">Produk Dikirim</h5>

    @foreach($detail['produk_list'] as $item)
    <div class="product-item">
      <div class="img-container">
        <img src="{{ asset($item['gambar']) }}" alt="{{ $item['produk'] }}">
        <span class="badge-supplier">{{ $item['supplier'] }}</span>
      </div>

      <div class="product-details">
        <h6 class="fw-semibold mb-1">{{ $item['produk'] }}</h6>
        <p class="small text-muted mb-0"> jumlah: {{ $item['jumlah'] }}</p>
      </div>
    </div>
    @endforeach

    <div class="total-section">
      <p class="mb-0 fw-semibold">Ongkos Kirim</p>
      <p class="mb-0 fw-bold text-success">{{ $detail['ongkir'] }}</p>
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
