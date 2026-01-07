@forelse($orders as $order)
@php
    $firstItem = $order->detailPesanan->first();
    $supplier = $firstItem && $firstItem->produk && $firstItem->produk->supplier ? $firstItem->produk->supplier->nama_supplier : 'Non-Supplier';

    $imagePath = $firstItem->gambar ?? '';

    if (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/') && $imagePath) {
        $imagePath = 'storage/' . $imagePath;
    }
    $src = $imagePath ? asset($imagePath) : asset('images/default-product.png');
@endphp

<div class="order-card"
     data-date="{{ strtotime($order->created_at) }}"
     data-product="{{ strtolower($firstItem->nama_produk ?? '') }}"
     data-supplier="{{ strtolower($supplier) }}"
     data-metode="{{ strtolower($order->opsi_pengiriman) }}">

    <div class="order-header">
        <div class="order-meta">
            <div><i class="fa-regular fa-calendar me-2"></i>{{ $order->created_at->format('d M Y, H:i') }}</div>
            <div class="text-secondary fw-bold">ID: {{ $order->kode_pesanan }}</div>
            <div>
                @if($order->opsi_pengiriman == 'dipick_up')
                     <span class="metode"><i class="bi bi-shop me-1"></i>Pick Up</span>
                @else
                    <div class="mb-1">
                         <span class="metode"><i class="fa-solid fa-truck me-1"></i>Diantar</span>
                         <span class="alamat ms-1"><i class="fa-solid fa-location-dot me-1"></i>{{ Str::limit($order->alamats->alamat_lengkap ?? $order->alamat_lengkap ?? '', 30) }}</span>
                    </div>
                    @if($order->kendaraan)
                    <div>
                        <span class="badge bg-warning text-dark"><i class="fa-solid fa-truck-pickup me-1"></i>{{ $order->kendaraan }}</span>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    @if($firstItem)
    <div class="order-product">
        <div class="img-container">
            <img src="{{ $src }}" alt="Produk">
            <span class="badge-supplier">{{ $supplier }}</span>
        </div>
        <div class="order-product-details flex-grow-1">
            <h6>{{ $firstItem->nama_produk ?? 'Produk' }}</h6>
            <p class="mb-1 text-muted small">
                {{ $firstItem->quantity }} x Rp {{ number_format($firstItem->harga_satuan, 0, ',', '.') }}
                / {{ $firstItem->jumlah_satuan ?? '1' }} {{ $firstItem->satuan ?? 'Unit' }}
            </p>
            <div class="fw-bold text-success">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</div>

            @if($order->detailPesanan->count() > 1)
            <div class="produk-lain">+ {{ $order->detailPesanan->count() - 1 }} produk lain</div>
            @endif
        </div>
    </div>
    @endif

    <div class="order-actions">
        @if($order->status_pesanan == 'menunggu_konfirmasi')
            <form action="{{ route('staff_purchasing.terima_pesanan', $order->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Terima pesanan ini?')">
                    <i class="fa-solid fa-check me-1"></i>Terima
                </button>
            </form>
        @endif

        <a href="{{ route('staff_purchasing.detail_pesanan', $order->id) }}" class="btn btn-outline-primary btn-sm">
            <i class="fa-solid fa-eye me-1"></i>Lihat Detail
        </a>
    </div>
</div>
@empty
<div class="text-center py-5 text-muted">
    <i class="fa-solid fa-box-open fa-3x mb-3 text-light-gray"></i>
    <p>{{ $emptyMsg }}</p>
</div>
@endforelse
