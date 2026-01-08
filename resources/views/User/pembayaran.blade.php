<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Pembayaran - {{ $pemesanan->kode_pesanan }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .checkout-container { background-color: #f8f9fa; min-height: 100vh; }
            .card { border-radius: 12px; background: white; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
            .btn-success { background-color: #198754; border: none; padding: 12px; font-weight: 600; }
            .btn-success:hover { background-color: #146c38; }
        </style>
    </head>
    <body>
        @extends('Components.user')
        @section('content')

        <div class="container checkout-container py-5">
            <h4 class="mb-4 fw-bold text-center">Pembayaran Pesanan</h4>
            <div class="row g-4 justify-content-center">

<div class="col-12 col-lg-6">
                    <div class="card p-4">
                        <h5 class="fw-bold mb-3">Instruksi Pembayaran</h5>

                        <div class="alert alert-light border mb-4">
                            <h6 class="fw-bold text-primary mb-2"><i class="fa-solid fa-building-columns me-2"></i>Transfer Bank (Manual)</h6>
                            <p class="mb-1 text-muted small">Silakan transfer sesuai total tagihan ke rekening di bawah ini:</p>
                            <div class="p-3 bg-white border rounded mt-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Bank</span>
                                    <span class="fw-bold">BRI</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">No. Rekening</span>
                                    <span class="fw-bold text-dark fs-5">1234-5678-9012-3456</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Atas Nama</span>
                                    <span class="fw-bold">Dinas Ketahanan Pangan</span>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('pemesanan.proses_pembayaran', $pemesanan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-bold">Upload Bukti Transfer</label>
                                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" accept="image/*" required>
                                <img id="imgPreview" class="img-preview mt-3 rounded border" style="max-width: 100%; max-height: 200px; display: none;" alt="Preview Bukti Pembayaran">
                                <small class="text-muted">Format: JPG, PNG. Maks 5MB.</small>
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-3">
                                <i class="fa-solid fa-paper-plane me-2"></i>Kirim Bukti Pembayaran
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Toast Container for Notifications -->
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div id="validationToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body" id="toastBody">
                                Pesan kesalahan akan muncul di sini.
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const gambarInput = document.getElementById('bukti_pembayaran');
                        const imagePreview = document.getElementById('imgPreview');
                        const toastEl = document.getElementById('validationToast');
                        const toastBody = document.getElementById('toastBody');
                        const toast = new bootstrap.Toast(toastEl);

                        function showToast(message) {
                            toastBody.textContent = message;
                            toast.show();
                        }

                        if (gambarInput && imagePreview) {
                            gambarInput.addEventListener('change', function(e) {
                                const file = e.target.files[0];
                                
                                if (file) {
                                    if (!file.type.startsWith('image/')) {
                                        showToast('File yang dipilih bukan gambar!');
                                        e.target.value = '';
                                        imagePreview.style.display = 'none';
                                        return;
                                    }

                                    const maxSize = 5 * 1024 * 1024; // 5MB
                                    if (file.size > maxSize) {
                                        showToast('Ukuran file terlalu besar! Maksimal 5MB.');
                                        e.target.value = '';
                                        imagePreview.style.display = 'none';
                                        return;
                                    }

                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        imagePreview.src = e.target.result;
                                        imagePreview.style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    imagePreview.style.display = 'none';
                                }
                            });
                        }
                    });
                </script>

<div class="col-12 col-lg-5">
                    <div class="card p-4">
                        <h5 class="fw-bold mb-3">Rincian Pesanan</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Kode Pesanan</span>
                            <span class="fw-bold">{{ $pemesanan->kode_pesanan }}</span>
                        </div>
                        <hr>
                        <div class="products-list mb-3">
                            @foreach($pemesanan->detailPesanan as $item)
                            <div class="d-flex align-items-center mb-3 border-bottom pb-2">

                                @php
                                    $imgSrc = asset('images/default-produk.png');
                                    if ($item->gambar) {
                                        if (str_starts_with($item->gambar, 'http')) {
                                            $imgSrc = $item->gambar;
                                        } elseif (str_starts_with($item->gambar, 'images/')) {
                                            $imgSrc = asset($item->gambar);
                                        } else {
                                            $imgSrc = asset($item->gambar);
                                        }
                                    }
                                @endphp
                                <img src="{{ $imgSrc }}" alt="{{ $item->nama_produk }}" class="rounded me-2" style="width: 50px; height: 50px; object-fit: cover;">

                                <div class="flex-grow-1">
                                    <div class="small fw-semibold">{{ $item->nama_produk }}</div>
                                    <div class="small text-muted">
                                        @php
                                            $hargaNormal = $item->batch ? $item->batch->harga_normal : $item->harga_satuan;
                                            $hargaSekarang = $item->harga_satuan;
                                            $adaDiskon = $hargaNormal > $hargaSekarang;
                                        @endphp
                                        {{ $item->quantity }} x
                                        @if($adaDiskon)
                                            <span class="text-decoration-line-through text-danger me-1">Rp {{ number_format($hargaNormal, 0, ',', '.') }}</span>
                                            <span class="fw-bold text-success">Rp {{ number_format($hargaSekarang, 0, ',', '.') }}</span>
                                        @else
                                            Rp {{ number_format($hargaSekarang, 0, ',', '.') }}
                                        @endif
                                        / {{ $item->jumlah_satuan }} {{ $item->satuan }}
                                    </div>
                                </div>
                                <span class="small fw-bold">Rp {{ number_format($item->harga_total, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($pemesanan->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Ongkir</span>
                            <span>Rp {{ number_format($pemesanan->ongkir, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-3 pt-3 border-top fw-bold fs-5 text-success">
                            <span>Total Bayar</span>
                            <span>Rp {{ number_format($pemesanan->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @endsection
    </body>
</html>
