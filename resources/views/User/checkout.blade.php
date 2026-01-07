<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>

        .checkout-container { position: relative; min-height: 100vh; display: flex; flex-direction: row; justify-content: space-between; gap: 1.5rem; margin-top: 0.5rem; padding: 0 1.5rem 1.5rem; box-sizing: border-box; }
        .card { border-radius: 1rem; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08); overflow: hidden; }
        .form-control:focus, .form-select:focus { border-color: #198754 !important; box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25) !important; }
        .left-card .card-body { display: flex; flex-direction: column; height: calc(100vh - 8rem); overflow: hidden; }
        .left-card .scrollable-content { flex: 1; overflow-y: auto; padding-right: 1rem; padding-bottom: 1rem; }
        .right-card .card-body { display: flex; flex-direction: column; height: calc(100vh - 8rem); overflow: hidden; position: relative; padding-bottom: 1rem; }
        .products-section { flex: 1; overflow-y: auto; padding-right: 0.5rem; padding-bottom: 0.75rem; }
        .total-section { position: sticky; bottom: -15px; background: #fff; border-top: 1px solid #e5e5e5; padding: 1rem 0.75rem 1rem; box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.08); z-index: 20; }
        .total-section .btn { background: #198754; border: none; color: #fff; font-weight: 600; border-radius: 0.5rem; width: 100%; padding: 0.625rem; transition: all 0.2s ease; }
        .total-section .btn:hover { background: #157347; transform: translateY(-2px); }
        .total-section .btn:disabled { background: #6c757d; cursor: not-allowed; transform: none; }
        #deliverySection, #pickupSection { display: none; }
        .product-img { width: 40px; height: 40px; object-fit: cover; border-radius: 0.25rem; margin-right: 0.5rem; }
        @media (max-width: 991.98px) { .checkout-container { flex-direction: column; min-height: auto; padding: 0.5rem; gap: 1rem; } .left-card .card-body, .right-card .card-body { height: auto; } }
        .ongkir-section { border: 1px solid #198754; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1rem; background-color: #f8f9fa; }
        .ongkir-help { font-size: 0.875rem; color: #198754; margin-top: 0.25rem; font-weight: 500; }
        .ongkir-error { font-size: 0.875rem; color: #dc3545; margin-top: 0.25rem; font-weight: 500; border-left: 3px solid #dc3545; padding-left: 0.5rem; }
        .ongkir-notes { font-size: 0.875rem; color: #198754; margin-top: 0.25rem; font-style: italic; font-weight: 500; background-color: #d1e7dd; padding: 0.25rem 0.5rem; border-radius: 0.25rem; border-left: 3px solid #198754; }
        .page-header { display: flex; align-items: center; margin-bottom: 1rem; }
        .back-btn { display:flex; align-items:center; justify-content:center; width:40px; height:40px; margin-right:.75rem; color:#6c757d; background:transparent; font-size:1.5rem; text-decoration:none; border:none; border-radius:.5rem; transition:color .2s ease, transform .2s ease; }

        .price-original {
            text-decoration: line-through;
            color: #adb5bd;
            font-size: 0.85rem;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    @extends('components.user')
    @section('content')

    <div class="container checkout-container">

<div class="col-12 col-lg-7 left-card">
            <div class="card p-3">
                <div class="card-body">
                    <div class="page-header">
                        @php
                            $backUrl = route('keranjang.index');
                            if (request()->get('from') === 'detail') {
                                $productId = request()->get('product_id');
                                if ($productId) {
                                    $backUrl = route('produk.detail', $productId);
                                } else {
                                    $backUrl = route('produk');
                                }
                            }
                        @endphp
                        <a href="{{ $backUrl }}" class="back-btn" title="Kembali">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                        <h5 class="fw-bold mb-0">Alamat Pengiriman</h5>
                    </div>

                    <div class="scrollable-content">
                        <div class="alert alert-warning text-justify" role="alert">
                            <i class="fa-solid fa-triangle-exclamation" style="color: orange;"></i>
                            <strong>Catatan:</strong> Kamu akan <strong>membuat pesanan terlebih dahulu.</strong>
                            Pesanan atau biaya pengiriman akan dikonfirmasi oleh <strong>tim purchasing atau kurir</strong>.
                            Setelah <strong>ongkir penawaranmu</strong> disetujui, kamu akan melanjutkan ke pembayaran.
                        </div>

                        <form id="alamatForm">
                            <div class="mb-2">
                                <label class="form-label">Opsi Pengiriman</label>
                                <select class="form-select form-select-sm" id="opsiPengiriman" required>
                                    <option value="">Pilih Pengiriman</option>
                                    <option value="diantar">Diantar</option>
                                    <option value="dipick_up">Pick Up</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" id="namaInput" class="form-control form-control-sm" placeholder="Masukkan nama Anda" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" id="teleponInput" class="form-control form-control-sm" placeholder="08xxxxxxxxxx" required>
                            </div>

<div id="deliverySection">
                                @if($alamat->isNotEmpty())
                                <div class="mb-2">
                                    <label class="form-label">Pilih Alamat Tersimpan (Opsional)</label>
                                    <select class="form-select form-select-sm" id="alamatTersimpan">
                                        <option value="">-- Pilih alamat --</option>
                                        @foreach($alamat as $a)
                                            <option value="{{ $a->id }}">{{ $a->alamat_lengkap }} ({{ $a->kecamatan->nama_kecamatan ?? '-' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @if($alamat->isEmpty())
                                    <div class="alert alert-info mb-2">
                                        <i class="fa fa-info-circle"></i> Belum ada alamat tersimpan. Silakan tambahkan di profil.
                                    </div>
                                @endif

                                <div class="mb-2">
                                    <label class="form-label">Kecamatan</label>
                                    <select id="kecamatanInput" class="form-select form-control-sm" required>
                                        <option value="">Pilih kecamatan</option>
                                        @foreach($kecamatans as $kec)
                                            <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Kelurahan</label>
                                    <select id="kelurahanInput" class="form-select form-control-sm" required>
                                        <option value="">Pilih kelurahan</option>
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Kode Pos</label>
                                    <select id="kodeposInput" class="form-select form-control-sm" required>
                                        <option value="">Pilih kode pos</option>
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea id="alamatLengkapInput" class="form-control form-control-sm" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Kendaraan Diantar</label>
                                    <select class="form-select form-select-sm" id="kendaraanInput" required>
                                        <option value="">Pilih kendaraan</option>
                                        <option value="Mobil">Mobil</option>
                                        <option value="Motor">Motor</option>
                                    </select>
                                </div>

                                <div class="alert alert-info mb-2 ongkir-info" style="display: none;">
                                    <i class="fa fa-info-circle"></i>
                                    <strong>Catatan Ongkir:</strong> Isi penawaran ongkir secara manual. Minimal sesuai ketentuan kendaraan.
                                </div>

                                <div class="ongkir-section">
                                    <div class="mb-2">
                                        <label class="form-label">Penawaran Ongkir</label>
                                        <input type="number" class="form-control form-control-sm" placeholder="Rp 0" step="1000" min="1" id="ongkirInput" required oninput="if(this.value === '0') this.value = '';">
                                        <div id="ongkirHelp" class="ongkir-help" style="display: none;">Minimal ongkir sesuai ketentuan.</div>
                                        <div id="ongkirNotes" class="ongkir-notes" style="display: none;"></div>
                                        <div id="ongkirError" class="ongkir-error" style="display: none;">Penawaran ongkir harus minimal Rp <span id="minimalDisplay">0</span></div>
                                    </div>
                                </div>
                            </div>

<div id="pickupSection">
                                <div class="alert alert-info mb-2">
                                    <i class="fa fa-map-marker-alt"></i> <strong>Alamat Pickup:</strong><br>
                                    Jl. Contoh No. 123, RT 01/RW 01, Kelurahan Pickup, Kecamatan Pickup, Kota Contoh, 12345.
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<div class="col-12 col-lg-5 right-card">
            <div class="card p-3 bg-light shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-2">Rincian Harga</h5>

                    <div class="products-section">
                        @if (empty($checkout))
                            <div class="text-center py-2 text-muted">
                                <p>Tidak ada produk untuk checkout.</p>
                                <a href="{{ route('keranjang.index') }}" class="btn btn-outline-success btn-sm">Kembali ke Keranjang</a>
                            </div>
                        @else
                            @foreach ($checkout as $item)
                                <div class="d-flex align-items-center mb-1">
                                    <img src="{{ $item['gambar'] }}" alt="{{ $item['nama_produk'] }}" class="product-img">
                                    <div class="flex-grow-1 ms-2">
                                        <div class="item-name">{{ $item['nama_produk'] }}</div>
                                        <div class="item-detail">
                                            {{ $item['quantity'] }} x
                                            @if(!empty($item['harga_awal']))
                                                <span class="price-original">Rp {{ number_format($item['harga_awal'], 0, ',', '.') }}</span>
                                            @endif
                                            Rp {{ number_format($item['harga'], 0, ',', '.') }} / {{ $item['satuan_berat'] ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        @if(!empty($item['harga_awal']))
                                            <div class="price-original small">Rp {{ number_format($item['harga_awal'] * $item['quantity'], 0, ',', '.') }}</div>
                                        @endif
                                        <div class="fw-bold">Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</div>
                                    </div>
                                </div>
@endforeach
                        @endif
                    </div>

                    <div class="total-section mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Subtotal • {{ count($checkout) }} item</span>
                            <div class="text-end">
                                @if($originalSubtotal > $subtotal)
                                    <div class="price-original small">Rp {{ number_format($originalSubtotal, 0, ',', '.') }}</div>
                                @endif
                                <span id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div id="pengirimanSection" style="display:none;">
                            <div class="d-flex justify-content-between">
                                <span>Pengiriman</span>
                                <span id="biayaPengiriman">Rp 0</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between fw-bold mb-2">
                            <span>Total</span>
                            <span class="text-success" id="totalHarga">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <button id="buatPesananBtn" class="btn btn-success w-100" disabled>Buat Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const deliverySection = document.getElementById('deliverySection');
            const pickupSection = document.getElementById('pickupSection');
            const opsiPengiriman = document.getElementById('opsiPengiriman');
            const namaInput = document.getElementById('namaInput');
            const teleponInput = document.getElementById('teleponInput');
            const alamatTersimpan = document.getElementById('alamatTersimpan');
            const kecamatanInput = document.getElementById('kecamatanInput');
            const kelurahanInput = document.getElementById('kelurahanInput');
            const kodeposInput = document.getElementById('kodeposInput');
            const alamatLengkapInput = document.getElementById('alamatLengkapInput');
            const kendaraanInput = document.getElementById('kendaraanInput');
            const ongkirInput = document.getElementById('ongkirInput');
            const buatPesananBtn = document.getElementById('buatPesananBtn');
            const pengirimanSection = document.getElementById('pengirimanSection');
            const biayaPengiriman = document.getElementById('biayaPengiriman');
            const totalHarga = document.getElementById('totalHarga');
            const subtotal = {{ $subtotal }};
            let ongkir = 0;
            let minimalOngkir = 0;

            const alamatData = @json($alamat->keyBy('id')->toArray());
            const itemsCheckout = @json($itemsCheckout);

            function updateTotal() {
                const total = subtotal + ongkir;
                totalHarga.textContent = "Rp " + total.toLocaleString('id-ID');
                biayaPengiriman.textContent = "Rp " + ongkir.toLocaleString('id-ID');
                pengirimanSection.style.display = ongkir > 0 ? 'block' : 'none';
            }

            function loadKelurahan(kecId, callback = null) {
                if (!kecId) return;
                console.log('Loading kelurahan for kecamatan:', kecId);
                $('#kelurahanInput').html('<option value="">Loading...</option>');

                $.get(`{{ url('/user/kelurahan') }}/${kecId}`)
                    .done(function(data) {
                        console.log('Kelurahan data:', data);
                        $('#kelurahanInput').html('<option value="">Pilih kelurahan</option>');
                        if (data.length === 0) {
                            alert('Data kelurahan tidak ditemukan untuk kecamatan ini.');
                        }
                        data.forEach(k => $('#kelurahanInput').append(`<option value="${k.id}">${k.nama_kelurahan}</option>`));
                        if (callback) callback();
                    })
                    .fail(function(xhr) {
                        console.error('Error loading kelurahan:', xhr);
                        $('#kelurahanInput').html('<option value="">Gagal memuat data</option>');
                        alert('Gagal mengambil data kelurahan. Silakan coba lagi.');
                    });
            }

            function loadKodePos(kelId, callback = null) {
                if (!kelId) return;
                console.log('Loading kodepos for kelurahan:', kelId);
                $('#kodeposInput').html('<option value="">Loading...</option>');

                $.get(`{{ url('/user/kodepos') }}/${kelId}`)
                    .done(function(data) {
                        console.log('KodePos data:', data);
                        $('#kodeposInput').html('<option value="">Pilih kode pos</option>');
                         if (data.length === 0) {

                         }
                        data.forEach(k => $('#kodeposInput').append(`<option value="${k.id}">${k.kode_pos}</option>`));
                        if (callback) callback();
                    })
                    .fail(function(xhr) {
                        console.error('Error loading kodepos:', xhr);
                        $('#kodeposInput').html('<option value="">Gagal memuat data</option>');
                        alert('Gagal mengambil data kode pos.');
                    });
            }

            function loadMinimalOngkir(kecId, kendaraan, callback = null) {
                if (!kecId || !kendaraan) {
                    minimalOngkir = 0;
                    ongkirInput.min = 0;
                    ongkirInput.placeholder = 'Rp 0';
                    document.getElementById('minimalDisplay').textContent = '0';
                    document.getElementById('ongkirHelp').style.display = 'none';
                    document.getElementById('ongkirNotes').style.display = 'none';
                    document.getElementById('ongkirError').style.display = 'none';
                    document.querySelector('.ongkir-info').style.display = 'none';
                    return;
                }

                $.get(`/keranjang/ongkir/minimal/${kecId}?kendaraan=${kendaraan}`, data => {
                    minimalOngkir = data.minimal || 0;
                    ongkirInput.min = minimalOngkir;
                    ongkirInput.placeholder = `minimal isi ${minimalOngkir.toLocaleString('id-ID')}`;
                    document.getElementById('minimalDisplay').textContent = minimalOngkir.toLocaleString('id-ID');
                    document.getElementById('ongkirHelp').style.display = 'block';
                    document.getElementById('ongkirError').style.display = 'none';
                    if (minimalOngkir > 0) document.querySelector('.ongkir-info').style.display = 'block';
                    updateTotal();
                    if (callback) callback();
                }).fail(() => {
                    minimalOngkir = 0;
                    ongkirInput.min = 0;
                    document.getElementById('minimalDisplay').textContent = '0';
                    document.getElementById('ongkirHelp').style.display = 'none';
                    document.getElementById('ongkirError').style.display = 'block';
                    document.getElementById('ongkirError').innerHTML = 'Gagal load minimal ongkir. Hubungi admin.';
                });
            }

            function checkValidity() {
                let valid = namaInput.value.trim() && teleponInput.value.trim() && itemsCheckout.length > 0;

                if (opsiPengiriman.value === 'diantar') {
                    valid = valid &&
                        kecamatanInput.value &&
                        kelurahanInput.value &&
                        kodeposInput.value &&
                        alamatLengkapInput.value.trim() &&
                        kendaraanInput.value &&
                        ongkirInput.value &&
                        parseInt(ongkirInput.value || 0) >= minimalOngkir;
                }

                buatPesananBtn.disabled = !valid;
                buatPesananBtn.textContent = valid ? 'Buat Pesanan' : 'Lengkapi Form Terlebih Dahulu';
            }

namaInput.addEventListener('input', checkValidity);
            teleponInput.addEventListener('input', checkValidity);

            opsiPengiriman.addEventListener('change', function() {
                const val = this.value;
                deliverySection.style.display = val === 'diantar' ? 'block' : 'none';
                pickupSection.style.display = val === 'dipick_up' ? 'block' : 'none';
                if (val === 'dipick_up') ongkir = 0;
                updateTotal();
                checkValidity();
            });

            kecamatanInput.addEventListener('change', function() {
                loadKelurahan(this.value);
                kelurahanInput.value = '';
                kodeposInput.innerHTML = '<option value="">Pilih kode pos</option>';
                if (kendaraanInput.value) loadMinimalOngkir(this.value, kendaraanInput.value);
                checkValidity();
            });

            kelurahanInput.addEventListener('change', function() {
                loadKodePos(this.value);
                checkValidity();
            });

            kendaraanInput.addEventListener('change', function() {
                if (kecamatanInput.value) loadMinimalOngkir(kecamatanInput.value, this.value);
                checkValidity();
            });

            ongkirInput.addEventListener('input', function() {
                ongkir = parseInt(this.value) || 0;
                updateTotal();
                checkValidity();
            });

if (alamatTersimpan) {
                alamatTersimpan.addEventListener('change', function() {
                    const id = this.value;
                    if (id && alamatData[id]) {
                        const a = alamatData[id];
                        namaInput.value = a.nama_penerima || '';
                        teleponInput.value = a.no_telpon || '';
                        alamatLengkapInput.value = a.alamat_lengkap || '';
                        kecamatanInput.value = a.id_kecamatan || '';
                        loadKelurahan(a.id_kecamatan, () => {
                            kelurahanInput.value = a.id_kelurahan || '';
                            loadKodePos(a.id_kelurahan, () => {
                                kodeposInput.value = a.id_kode_pos || '';
                                if (a.kendaraan) kendaraanInput.value = a.kendaraan;
                                loadMinimalOngkir(a.id_kecamatan, a.kendaraan);
                                checkValidity();
                            });
                        });
                    } else {
                        namaInput.value = '';
                        teleponInput.value = '';
                        alamatLengkapInput.value = '';
                        kecamatanInput.value = '';
                        kelurahanInput.innerHTML = '<option value="">Pilih kelurahan</option>';
                        kodeposInput.innerHTML = '<option value="">Pilih kode pos</option>';
                        kendaraanInput.value = '';
                        checkValidity();
                    }
                });
            }

buatPesananBtn.addEventListener('click', function() {
                if (this.disabled) return;
                this.disabled = true;
                this.textContent = 'Memproses...';

                const data = {
                    _token: '{{ csrf_token() }}',
                    opsi_pengiriman: opsiPengiriman.value,
                    nama_penerima: namaInput.value.trim(),
                    no_telepon: teleponInput.value.trim(),
                    id_alamat: alamatTersimpan ? alamatTersimpan.value : null,
                    alamat_lengkap: opsiPengiriman.value === 'diantar' ? alamatLengkapInput.value.trim() : null,
                    nama_kecamatan: opsiPengiriman.value === 'diantar' ? kecamatanInput.options[kecamatanInput.selectedIndex].text : null,
                    nama_kelurahan: opsiPengiriman.value === 'diantar' ? kelurahanInput.options[kelurahanInput.selectedIndex].text : null,
                    kode_pos: opsiPengiriman.value === 'diantar' ? kodeposInput.options[kodeposInput.selectedIndex].text : null,
                    kendaraan: opsiPengiriman.value === 'diantar' ? kendaraanInput.value : null,
                    ongkir: ongkir,
                    subtotal: subtotal,
                    total: subtotal + ongkir,
                    items: itemsCheckout
                };

                $.ajax({
                    url: '{{ route("pemesanan.store") }}',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        } else {
                            window.location.href = '{{ route("pemesanan.index") }}';
                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.message || 'Gagal membuat pesanan.');
                        buatPesananBtn.disabled = false;
                        buatPesananBtn.textContent = 'Buat Pesanan';
                    }
                });
            });

            updateTotal();
            checkValidity();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
