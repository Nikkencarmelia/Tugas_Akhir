@php
    $firstItem = $order->detailPesanan->first();
    $supplier = $firstItem && $firstItem->produk && $firstItem->produk->supplier ? $firstItem->produk->supplier->nama_supplier : 'Non-Supplier';
    $metode = $order->opsi_pengiriman;
    $imagePath = $firstItem->gambar ?? '';
    if (str_starts_with($imagePath, 'images/')) {
        $src = asset($imagePath);
    } elseif (!str_contains($imagePath, 'http') && !str_starts_with($imagePath, 'storage/') && $imagePath) {
        $src = asset('storage/' . $imagePath);
    } else {
        $src = $imagePath ? asset($imagePath) : asset('images/default-product.png');
    }
@endphp

<div class="order-card"
    data-date="{{ $order->updated_at->timestamp }}"
    data-product="{{ strtolower($firstItem->nama_produk ?? '') }}"
    data-supplier="{{ strtolower($supplier) }}">
    
    <div class="order-header">
        <div class="d-flex align-items-start gap-3">
            <div class="order-meta">
                <div><i class="fa-regular fa-calendar me-2"></i>{{ $order->created_at->format('d M Y, H:i') }}</div>
                <div class="text-secondary fw-bold">ID: {{ $order->kode_pesanan }}</div>
                <div>
                    @if($metode == 'dipick_up')
                        <span class="badge-metode"><i class="bi bi-shop"></i> Pick Up</span>
                    @else
                        <div class="d-flex flex-wrap gap-1 mb-1">
                            <span class="badge-metode"><i class="fa-solid fa-truck"></i> Diantar</span>
                            <span class="badge-alamat"><i class="fa-solid fa-location-dot"></i> {{ $order->nama_kelurahan ?? $order->alamats->kelurahan->nama_kelurahan ?? '' }}</span>
                            @if($order->kendaraan)
                                <span class="badge-kendaraan"><i class="fa-solid fa-truck-pickup"></i> {{ $order->kendaraan }}</span>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="mt-2">
                    @php
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
                            $statusLabel = 'Menunggu Konfirmasi Kurir';
                        }
                        elseif($status == 'menunggu_cari_kurir') {
                            $statusClass = 'status-menunggu_konfirmasi';
                            $statusLabel = 'Menunggu Cari Kurir';
                        }
                        elseif($status == 'menunggu_konfirmasi') {
                            $statusClass = 'status-menunggu_konfirmasi';
                            $statusLabel = 'Menunggu Konfirmasi';
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
                    <span class="order-status {{ $statusClass }} py-1 px-2" style="font-size: 12px; margin: 0; display: inline-flex;">
                        <i class="fas {{ $icon }}"></i> {{ $statusLabel }}
                    </span>
                </div>
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
            <h6>{{ $firstItem->nama_produk }}</h6>
            <p class="mb-1 text-muted small">
                {{ $firstItem->quantity }} x Rp {{ number_format($firstItem->harga_satuan, 0, ',', '.') }} 
                / {{ $firstItem->jumlah_satuan }} {{ $firstItem->satuan }}
            </p>
            
            @if($order->detailPesanan->count() > 1)
            <div class="produk-lain mb-2">+ {{ $order->detailPesanan->count() - 1 }} produk lain</div>
            @endif

            <div class="border-top mt-2 pt-2 small text-muted">
                <div class="d-flex justify-content-between">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Ongkir:</span>
                    <span>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between fw-bold text-success mt-1">
                    <span>Total:</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="order-actions">
        <a href="{{ route('staff_purchasing.detail_pesanan', $order->id) }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye me-1"></i>Lihat Detail</a>
        
        <!-- Action Buttons Specific to Status -->
        @if($order->status_pesanan == 'siap_diambil')
             <form action="{{ route('staff_purchasing.to_dikirim', $order->id) }}" method="POST" class="formSudahDiambil d-inline">
                @csrf
                <button type="button" class="btn btn-success btn-sm btnSudahDiambil">
                    <i class="fa-solid fa-check-circle me-1"></i>Sudah Diambil
                </button>
            </form>
        @elseif($order->status_pesanan == 'diproses')
           <form action="{{ route('staff_purchasing.to_siap_diambil', $order->id) }}" method="POST" class="formSiapDiambil d-inline">
                @csrf
                <button type="button" class="btn btn-primary btn-sm btnSiapDiambil">
                    <i class="fa-solid fa-box-open me-1"></i>Siap Diambil/Dikirim
                </button>
           </form>
        @endif
    </div>
</div>
