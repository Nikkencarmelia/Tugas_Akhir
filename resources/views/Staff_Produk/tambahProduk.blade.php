<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tambah Produk | Food Center</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

        <style>
            .container-produk{
                max-width:900px;
                margin:40px auto;
                background:#fff;
                border-radius:16px;
                box-shadow:0 8px 20px rgba(0,0,0,0.05);
                padding:40px 50px
            }

            h2{font-weight:600;
                font-size:1.6rem;
                margin-bottom:30px;
                color:#2f3e2f;
                display:flex;
                align-items:center;
                gap:10px
            }

            label{
                font-weight:500;
                margin-bottom:6px;
                color:#444
            }

            .form-control,.form-select{
                border-radius:10px;
                border:1px solid #ccc;
                padding:10px 12px;
                transition:.2s
            }

            .form-control:focus,.form-select:focus{
                border-color:#16a34a;
                box-shadow:0 0 0 2px rgba(22,163,74,0.15)
            }

            .btn-submit{
                background:#16a34a;
                border:none;
                border-radius:10px;
                padding:10px 18px;
                color:#fff;
                font-weight:500
            }

            .btn-cancel{
                background:#e5e7eb;
                border:none;
                border-radius:10px;
                padding:10px 18px;
                color:#333
            }

            .btn-submit:hover{
                background:#15803d
            }

            .img-preview{
                width:120px;
                height:120px;
                border-radius:10px;
                object-fit:cover;
                border:1px solid #ddd;
                margin-top:10px
            }
        </style>
    </head>

    <body>
        @extends('Components.staff_produk')

        @section('content')
        <div class="container-produk">
            <h2><i class="bi bi-plus-circle text-success"></i> Tambah Produk Baru</h2>

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Gambar --}}
            <div class="mb-3">
                <label>Gambar Produk</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                <img id="imagePreview" class="img-preview d-none" alt="Preview Gambar Produk">
            </div>

            {{-- Nama Produk --}}
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" class="form-control" name="nama_produk" required>
            </div>

            <div class="row">

                {{-- Kategori --}}
                <div class="col-md-3 mb-3">
                    <label>Kategori</label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Jumlah Satuan --}}
                <div class="col-md-3 mb-3">
                    <label>Jumlah Satuan</label>
                    <input type="number" class="form-control" name="jumlah_satuan" min="1" required>
                </div>

                {{-- Satuan --}}
                <div class="col-md-3 mb-3">
                    <label>Satuan</label>
                    <select name="id_satuan" class="form-select" required>
                        <option value="">Pilih Satuan</option>
                        @foreach ($satuan as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_satuan }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Supplier --}}
                <div class="col-md-3 mb-3">
                    <label>Supplier</label>
                    <select name="id_supplier" class="form-select" required>
                        <option value="">Pilih Supplier</option>
                        @foreach ($supplier as $sp)
                            <option value="{{ $sp->id }}">{{ $sp->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- Estimasi Hari Kadaluarsa --}}
            <div class="mb-3">
                <label>Estimasi Hari Kadaluarsa</label>
                <input type="number" class="form-control" name="estimasi_kadaluwarsa_hari" min="0" required>
                <small class="text-muted">Masukkan estimasi hari kadaluarsa produk dari tanggal masuk (contoh: 30 hari)</small>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label>Deskripsi Produk</label>
                <textarea class="form-control" name="deskripsi" rows="4"></textarea>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label>Status</label>
                <select name="status_tampil" class="form-select" required>
                    <option value="Ditampilkan">Ditampilkan</option>
                    <option value="Diarsipkan">Diarsipkan</option>
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" class="btn btn-secondary" onclick="history.back()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Produk</button>
            </div>

        </form>

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const gambarInput = document.getElementById('gambar');
                const imagePreview = document.getElementById('imagePreview');

                if (gambarInput && imagePreview) {
                    gambarInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];

                        if (file) {
                            // Cek apakah file adalah gambar
                            if (file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    imagePreview.src = e.target.result;
                                    imagePreview.classList.remove('d-none');
                                };
                                reader.readAsDataURL(file);
                            } else {
                                alert('File yang dipilih bukan gambar!');
                                e.target.value = ''; // Reset input
                            }
                        } else {
                            imagePreview.classList.add('d-none');
                        }
                    });
                }
            });
        </script>

        @endsection

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
