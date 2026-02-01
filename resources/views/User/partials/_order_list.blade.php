@forelse($collection as $order)
    <div class="order-card">
        <div class="order-header">
            <div class="order-meta">
                <div class="small text-muted">
                    <i class="fa-regular fa-calendar-days me-1"></i> {{ $order->created_at->format('d M Y, H:i') }}
                </div>
                <div class="mt-2 d-flex flex-wrap gap-2">
                    <span class="metode-badge">
                        <i class="{{ $order->opsi_pengiriman == 'dipick_up' ? 'bi bi-shop' : 'fa-solid fa-truck' }}"></i>
                        {{ $order->opsi_pengiriman == 'dipick_up' ? 'Pick Up' : 'Diantar' }}
                    </span>

                    @if($order->opsi_pengiriman != 'dipick_up' && $order->id_kurir && $order->kurir)
                        <div class="vehicle-badge">
                            <i class="fa-solid {{ ($order->kurir->kurir->jenis_kendaraan ?? '') == 'Motor' ? 'fa-motorcycle' : 'fa-truck-pickup' }} me-1"></i>
                            {{ $order->kurir->kurir->jenis_kendaraan ?? 'Kurir' }}
                        </div>
                    @elseif($order->kendaraan)
                        <div class="vehicle-badge">
                            <i class="fa-solid {{ $order->kendaraan == 'Motor' ? 'fa-motorcycle' : 'fa-truck-pickup' }} me-1"></i>
                            {{ $order->kendaraan }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="text-end">
                <div class="small text-muted">Kode Pesanan</div>
                <div class="detail-number">#{{ $order->kode_pesanan }}</div>
            </div>
        </div>

        @php
            $status = $order->status_pesanan;

if (in_array($status, ['dibatalkan', 'ditolak_staff'])) {
                $statusClass = 'status-dibatalkan';
            } elseif (in_array($status, ['menunggu_konfirmasi', 'menunggu_konfirmasi_kurir', 'menunggu_cari_kurir', 'ditolak_kurir'])) {
                $statusClass = 'status-menunggu_konfirmasi';
            } elseif (in_array($status, ['menunggu_konfirmasi_pembayaran'])) {
                $statusClass = 'status-menunggu_konfirmasi_pembayaran';
            } elseif (in_array($status, ['dikirim'])) {
                $statusClass = 'status-dikirim';
            } elseif (in_array($status, ['sedang_diantar', 'pesanan_telah_diambil'])) {
                $statusClass = 'status-diproses';
            } else {
                $statusClass = 'status-' . $status;
            }

if ($status == 'ditolak_staff') {
                $statusLabel = 'Pesanan Dibatalkan oleh Staff';
            } elseif ($status == 'dibatalkan') {
                $statusLabel = 'Dibatalkan';
            } elseif ($status == 'menunggu_konfirmasi_pembayaran') {
                $statusLabel = 'Menunggu Konfirmasi Pembayaran';
            } elseif (in_array($status, ['dikirim'])) {
                $statusLabel = 'Dikirim';
            } elseif (in_array($status, ['sedang_diantar', 'pesanan_telah_diambil'])) {
                $statusLabel = 'Diproses';
                if($status == 'pesanan_telah_diambil') $statusLabel = 'Pesanan telah diambil kurir';
                if($status == 'sedang_diantar') $statusLabel = 'Pesanan sedang disiapkan kurir';
            } elseif (in_array($status, ['menunggu_konfirmasi', 'menunggu_konfirmasi_kurir', 'ditolak_kurir', 'menunggu_cari_kurir'])) {
                $statusLabel = 'Menunggu Konfirmasi';
            } else {
                $statusLabel = ucwords(str_replace('_', ' ', $status));
            }
        @endphp

        <div class="mb-3">
            <span class="order-status {{ $statusClass }} d-inline-flex">
                @if($status == 'selesai') <i class="fas fa-check-circle"></i>
                @elseif($statusClass == 'status-dibatalkan') <i class="fas fa-times-circle"></i>
                @elseif($statusClass == 'status-dikirim') <i class="fas fa-truck"></i>
                @elseif($statusClass == 'status-menunggu_konfirmasi') <i class="fas fa-hourglass-half"></i>
                @elseif($statusClass == 'status-menunggu_konfirmasi_pembayaran') <i class="fas fa-clock"></i>
                @elseif($status == 'menunggu_pembayaran') <i class="fas fa-wallet"></i>
                @elseif($status == 'siap_diambil') <i class="fas fa-box-open"></i>
                @elseif($status == 'pesanan_telah_diambil') <i class="fas fa-check-double"></i>
                @else <i class="fas fa-box"></i> @endif
                {{ $statusLabel }}
            </span>
        </div>

        @php $orderItem = $order->detailPesanan->first(); @endphp
        @if($orderItem)
            <div class="order-product">
                @php
                    $imgSrc = asset('images/default-produk.png');
                    if ($orderItem->gambar) {
                        if (str_starts_with($orderItem->gambar, 'http')) {
                            $imgSrc = $orderItem->gambar;
                        } elseif (str_starts_with($orderItem->gambar, 'images/')) {
                            $imgSrc = asset($orderItem->gambar);
                        } else {
                            $imgSrc = asset('storage/' . $orderItem->gambar);
                        }
                    }
                @endphp
                <img src="{{ $imgSrc }}" alt="{{ $orderItem->nama_produk }}">
                <div class="order-product-details">
                    <h6>{{ $orderItem->nama_produk }}</h6>
                    <p class="mb-1 text-muted small">
                        {{ $orderItem->quantity }} x Rp {{ number_format($orderItem->harga_satuan, 0, ',', '.') }}
                    </p>
                    @if($order->detailPesanan->count() > 1)
                        <div class="produk-lain text-muted small">+ {{ $order->detailPesanan->count() - 1 }} produk lain</div>
                    @endif
                </div>
            </div>
        @endif

        <div class="order-actions">
            @if($order->status_pesanan == 'menunggu_konfirmasi')
                <button type="button" class="btn btn-order-rounded btn-danger-order btn-sm" onclick="confirmCancel('{{ route('pemesanan.destroy', $order->id) }}')">
                    <i class="fa-solid fa-xmark me-1"></i>Batalkan
                </button>
            @elseif($order->status_pesanan == 'menunggu_pembayaran')
                <a href="{{ route('pemesanan.pembayaran', $order->id) }}" class="btn btn-order-rounded btn-primary-order btn-sm px-4">Bayar Sekarang</a>
            @endif
            <a href="{{ route('pemesanan.show', $order->id) }}" class="btn btn-order-rounded btn-outline-success-order btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
        </div>
    </div>
@empty
    <div class="no-orders" style="display: block;">
        <i class="fa-solid fa-box-open"></i>
        <p>Tidak ada pesanan {{ $title }}.</p>
    </div>
@endforelse

<div class="mt-4 d-flex justify-content-center ajax-pagination">
    {{ $collection->appends(request()->all())->links('pagination::bootstrap-5') }}
</div>
