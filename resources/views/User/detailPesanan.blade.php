<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Pesanan #{{ $pemesanan->kode_pesanan }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      padding: 6px 16px;
      border-radius: 50px;
      font-size: 13px;
      font-weight: 600;
    }
    .vehicle-badge {
        background: #fff3ce;
        color: #856404;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid #ffeaa7;
    }

.status-menunggu_konfirmasi { background: #f1f3f5; color: #495057; }
    .status-menunggu_pembayaran { background: #fff4e6; color: #d9480f; }
    .status-diproses { background: #fef9c3; color: #854d0e; }
    .status-dikirim { background: #e0f2fe; color: #0369a1; }
    .status-selesai { background: #dcfce7; color: #166534; }
    .status-dibatalkan { background: #fee2e2; color: #991b1b; }
    .status-verif { background: #fff7ed; color: #9a3412; }
    .status-siap_diambil { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .status-pesanan_telah_diambil { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

    .price-original {
        text-decoration: line-through;
        color: #adb5bd;
        font-size: 0.85rem;
        margin-right: 0.5rem;
    }

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
    .img-container img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #f1f3f4; }

    @media (max-width: 768px) {
      .detail-header { flex-direction: column; gap: 1rem; text-align: center; }
      .detail-header-section { flex-direction: column; gap: .5rem; align-items: flex-start; }
      .product-item { flex-direction: column; text-align: center; }
      .detail-meta { flex-direction: column; gap: .5rem; }
    }
  </style>
</head>

<body>
   @extends('components.user')
   @section('content')

<div class="container py-5">

<div class="detail-header">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('pemesanan.index') }}" class="text-dark text-decoration-none">
            <i class="fa-solid fa-chevron-left fs-4"></i>
        </a>
        <h3 class="mb-0">Detail Pesanan</h3>
    </div>
    <div class="text-end">
        <small class="text-muted d-block">Kode Pesanan</small>
        <span class="detail-number">#{{ $pemesanan->kode_pesanan }}</span>
    </div>
  </div>

<div class="detail-card">
    <div class="detail-header-section">
      <div class="detail-meta align-items-center">
        <div><i class="fa-regular fa-calendar me-1"></i> {{ $pemesanan->created_at->format('d M Y') }}</div>
        <div class="metode-badge">
            <i class="{{ $pemesanan->opsi_pengiriman == 'dipick_up' ? 'bi bi-shop' : 'fa-solid fa-truck' }}"></i>
            {{ $pemesanan->opsi_pengiriman == 'dipick_up' ? 'Pick Up' : 'Diantar' }}
        </div>

        @if($pemesanan->opsi_pengiriman != 'dipick_up' && $pemesanan->id_kurir && $pemesanan->kurir)
            <div class="vehicle-badge">
                <i class="fa-solid {{ $pemesanan->kurir->kurir->jenis_kendaraan == 'Motor' ? 'fa-motorcycle' : 'fa-truck-pickup' }} me-1"></i>
                {{ $pemesanan->kurir->kurir->jenis_kendaraan ?? 'Kurir' }}
            </div>
        @elseif($pemesanan->kendaraan)
            <div class="vehicle-badge">
                <i class="fa-solid {{ $pemesanan->kendaraan == 'Motor' ? 'fa-motorcycle' : 'fa-truck-pickup' }} me-1"></i>
                {{ $pemesanan->kendaraan }}
            </div>
        @endif

        @php
            $status = $pemesanan->status_pesanan;
            $statusClass = 'status-' . $status;
            if(in_array($status, ['dibatalkan', 'ditolak_staff', 'ditolak_kurir'])) $statusClass = 'status-dibatalkan';
            elseif(in_array($status, ['menunggu_konfirmasi_pembayaran', 'menunggu_verifikasi_pembayaran'])) $statusClass = 'status-verif';
            elseif(in_array($status, ['menunggu_cari_kurir', 'menunggu_konfirmasi_kurir'])) $statusClass = 'status-diproses';
            elseif(in_array($status, ['menunggu_konfirmasi'])) $statusClass = 'status-menunggu_konfirmasi';
            elseif($status == 'sedang_diantar') $statusClass = 'status-dikirim';

            $statusLabel = ucwords(str_replace('_', ' ', $status));
            if($status == 'ditolak_staff') $statusLabel = 'Pesanan Dibatalkan oleh Staff';
            elseif($status == 'ditolak_kurir') $statusLabel = 'Pesanan Ditolak Kurir';
            elseif(in_array($status, ['menunggu_konfirmasi_pembayaran', 'menunggu_verifikasi_pembayaran'])) $statusLabel = 'Menunggu Verifikasi Pembayaran';
            elseif(in_array($status, ['dikirim', 'sedang_diantar'])) $statusLabel = 'Dikirim';
            elseif(in_array($status, ['menunggu_konfirmasi'])) $statusLabel = 'Menunggu Konfirmasi';
            elseif(in_array($status, ['menunggu_cari_kurir', 'menunggu_konfirmasi_kurir'])) $statusLabel = 'Diproses';
        @endphp

        <div class="status-badge {{ $statusClass }}">
            @if($status == 'selesai') <i class="fas fa-check-circle"></i>
            @elseif($statusClass == 'status-dibatalkan') <i class="fas fa-times-circle"></i>
            @elseif($statusClass == 'status-dikirim') <i class="fas fa-truck"></i>
            @elseif($statusClass == 'status-menunggu_konfirmasi') <i class="fas fa-hourglass-half"></i>
            @elseif($statusClass == 'status-verif') <i class="fas fa-clock"></i>
            @elseif($status == 'menunggu_pembayaran') <i class="fas fa-wallet"></i>
            @elseif($status == 'siap_diambil') <i class="fas fa-box-open"></i>
            @elseif($status == 'pesanan_telah_diambil') <i class="fas fa-check-double"></i>
            @else <i class="fas fa-box"></i> @endif
            {{ $statusLabel }}
        </div>
      </div>
    </div>

    <h5 class="mb-3 fw-bold">Alamat Pengiriman</h5>
    <p class="mb-1 fw-semibold">{{ $pemesanan->nama_penerima }} ({{ $pemesanan->no_telepon }})</p>
    @if(strtolower($pemesanan->opsi_pengiriman) == 'diantar')
        <p class="mb-1">{{ $pemesanan->alamat_lengkap }}</p>
        <p class="mb-1">
        {{ $pemesanan->nama_kelurahan }}, {{ $pemesanan->nama_kecamatan }} - {{ $pemesanan->kode_pos }}
        </p>
    @else
        <h6 class="mt-3 mb-1 fw-bold">Alamat Pengambilan (Toko)</h6>
        <p class="mb-1">Komplek Perkantoran, Blok E, Barong Tongkok, Kec. Barong Tongkok, Kabupaten Kutai Barat, Kalimantan Timur 75777</p>
        <p class="mb-1 text-muted small">Silakan tunjukkan kode pesanan ini saat pengambilan.</p>
    @endif
  </div>

<div class="detail-card">
    <h5 class="fw-bold mb-3">Produk Dipesan</h5>

    @foreach($pemesanan->detailPesanan as $item)
    <div class="product-item">
      <div class="img-container">
        <img src="{{ $item->gambar }}" alt="{{ $item->nama_produk }}">
      </div>

      <div class="product-details">
        <h6 class="fw-semibold mb-1">{{ $item->nama_produk }}</h6>
        <p class="small text-muted mb-0">
            {{ $item->quantity }} x
            @if($item->batch && $item->batch->harga_normal > $item->harga_satuan)
                <span class="price-original">Rp {{ number_format($item->batch->harga_normal, 0, ',', '.') }}</span>
            @endif
            Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}/{{ $item->jumlah_satuan }} {{ $item->satuan }}
        </p>
      </div>

      <div class="text-end">
        @if($item->batch && $item->batch->harga_normal > $item->harga_satuan)
            <div class="price-original small">Rp {{ number_format($item->batch->harga_normal * $item->quantity, 0, ',', '.') }}</div>
        @endif
        <div class="fw-bold">
          Rp {{ number_format($item->harga_total, 0, ',', '.') }}
        </div>
      </div>
    </div>
    @endforeach

    <div class="total-section">
      <p class="mb-0 fw-semibold">Subtotal</p>
      <p class="mb-0 fw-bold">Rp {{ number_format($pemesanan->subtotal, 0, ',', '.') }}</p>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-2">
      <p class="mb-0 fw-semibold">Ongkos Kirim</p>
      <p class="mb-0 fw-bold text-success">Rp {{ number_format($pemesanan->ongkir, 0, ',', '.') }}</p>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
      <h5 class="mb-0 fw-bold">Total Pembayaran</h5>
      <h5 class="mb-0 fw-bold text-primary">Rp {{ number_format($pemesanan->total, 0, ',', '.') }}</h5>
    </div>

  </div>

</div>
@endsection

</body>
</html>
