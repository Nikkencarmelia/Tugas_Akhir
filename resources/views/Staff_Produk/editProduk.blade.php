<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Produk | Food Center</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

        <style>
            .container-produk {
                max-width: 900px;
                margin: 40px auto;
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 8px 20px rgba(0,0,0,0.05);
                padding: 40px 50px;
            }
            h2 {
                font-weight: 600;
                font-size: 1.6rem;
                margin-bottom: 30px;
                color: #2f3e2f;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            label {
                font-weight: 500;
                margin-bottom: 6px;
                color: #444;
            }
            .form-control,
            .form-select {
                border-radius: 10px;
                border: 1px solid #ccc;
                padding: 10px 12px;
                transition: border-color .2s ease;
            }
            .form-control:focus,
            .form-select:focus {
                border-color: #16a34a;
                box-shadow: 0 0 0 2px rgba(22,163,74,0.15);
            }
            .btn-submit {
                background: #16a34a;
                border: none;
                border-radius: 10px;
                padding: 10px 18px;
                color: #fff;
                font-weight: 500;
                transition: .3s;
            }
            .btn-submit:hover {
                background: #15803d;
            }
            .btn-cancel {
                background: #e5e7eb;
                border: none;
                border-radius: 10px;
                padding: 10px 18px;
                color: #333;
                font-weight: 500;
                transition: .3s;
            }
            .btn-cancel:hover {
                background: #d1d5db;
            }
            .img-preview {
                width: 120px;
                height: 120px;
                border-radius: 10px;
                object-fit: cover;
                border: 1px solid #ddd;
                display: block;
                margin-top: 10px;
            }
            .form-section {
                margin-bottom: 25px;
            }
            .btn-group-action {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                margin-top: 30px;
            }
            .dropdown-container {
                position: relative;
            }
            .dropdown-list {
                position: absolute;
                z-index: 1000;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border: 1px solid #ddd;
                border-radius: 10px;
                margin-top: 4px;
                box-shadow: 0 4px 10px rgba(0,0,0,0.08);
                display: none;
            }
            .dropdown-item {
                padding: 8px 12px;
                cursor: pointer;
                transition: background .2s ease;
            }
            .dropdown-item:hover {
                background: #f1f5f9;
            }
            .delete-item {
                cursor: pointer;
                font-size: 14px;
            }
            .current-image {
                max-width: 200px;
                margin-top: 10px;
                border-radius: 10px;
            }
        </style>
    </head>

    <body>
        @extends('Components.staff_produk')
        @section('content')

            <div class="container-produk">
                <h2>
                    <i class="bi bi-pencil text-success"></i>
                    Edit Produk
                </h2>
                <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    @method('PUT')
                    <div class="form-section">
                        <label for="gambar">Gambar Produk</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}"
                                alt="Gambar Saat Ini"
                                class="current-image img-preview" id="currentPreview">
                            <small class="text-muted">Upload gambar baru untuk mengganti yang lama.</small>
                        @else
                            <img id="preview" class="img-preview" src="#" alt="Preview" style="display:none;">
                        @endif
                    </div>
                    <div class="form-section">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" placeholder="Masukkan nama produk">
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-section dropdown-container">
                            <label for="kategori">Kategori</label>
                            <div class="position-relative">
                                <input type="text" class="form-control pe-5" id="kategori" name="kategori" value="{{ old('kategori', $produk->kategori) }}" placeholder="Pilih atau ketik kategori" onfocus="showList('kategori')" oninput="filterList('kategori')">
                                <i class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y me-3 text-secondary"></i>
                            </div>
                            <div class="dropdown-list" id="kategoriList">
                                @foreach($kategoris ?? [] as $kat)
                                    <div class="dropdown-item d-flex justify-content-between align-items-center" onclick="selectItem('kategori', '{{ $kat }}')">
                                        {{ $kat }}
                                        <i class="bi bi-trash text-danger delete-item" onclick="event.stopPropagation(); deleteItem(this, '{{ $kat }}', 'kategori')"></i>
                                    </div>
                                @endforeach
                                <div class="dropdown-item text-success fw-semibold text-center" onclick="openAddModal('kategori')">
                                    + Tambah kategori baru
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 form-section dropdown-container">
                            <label for="satuan">Satuan</label>
                            <div class="position-relative">
                                <input type="text" class="form-control pe-5" id="satuan" name="satuan_berat" value="{{ old('satuan', $produk->satuan) }}" placeholder="Pilih atau ketik satuan" onfocus="showList('satuan')" oninput="filterList('satuan')">
                                <i class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y me-3 text-secondary"></i>
                            </div>
                            <div class="dropdown-list" id="satuanList">
                                @foreach($satuans ?? [] as $sat)
                                    <div class="dropdown-item d-flex justify-content-between align-items-center" onclick="selectItem('satuan', '{{ $sat }}')">
                                        {{ $sat }}
                                        <i class="bi bi-trash text-danger delete-item" onclick="event.stopPropagation(); deleteItem(this, '{{ $sat }}', 'satuan')"></i>
                                    </div>
                                @endforeach
                                <div class="dropdown-item text-success fw-semibold text-center" onclick="openAddModal('satuan')">
                                    + Tambah satuan baru
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 form-section dropdown-container">
                            <label for="supplier">Supplier</label>
                            <div class="position-relative">
                                <input type="text" class="form-control pe-5" id="supplier" name="supplier" value="{{ old('supplier', $produk->supplier) }}" placeholder="Pilih atau ketik supplier" onfocus="showList('supplier')" oninput="filterList('supplier')">
                                <i class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y me-3 text-secondary"></i>
                            </div>
                            <div class="dropdown-list" id="supplierList">
                                @foreach($suppliers ?? [] as $sup)
                                    <div class="dropdown-item d-flex justify-content-between align-items-center" onclick="selectItem('supplier', '{{ $sup }}')">
                                        {{ $sup }}
                                        <i class="bi bi-trash text-danger delete-item" onclick="event.stopPropagation(); deleteItem(this, '{{ $sup }}', 'supplier')"></i>
                                    </div>
                                @endforeach
                                <div class="dropdown-item text-success fw-semibold text-center" onclick="openAddModal('supplier')">
                                    + Tambah supplier baru
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <label for="deskripsi">Deskripsi Produk</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi produk...">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    </div>
                    <div class="form-section">
                        <label for="status">Status</label>
                        <select id="status" name="status_tampil" class="form-select">
                            <option value="">Pilih status tampil</option>
                            <option value="Ditampilkan" {{ old('status_tampil', $produk->status_tampil) == 'Ditampilkan' ? 'selected' : '' }}>Ditampilkan</option>
                            <option value="Diarsipkan" {{ old('status_tampil', $produk->status_tampil) == 'Diarsipkan' ? 'selected' : '' }}>Diarsipkan</option>
                        </select>
                    </div>
                    <div class="btn-group-action">
                        <button type="button" class="btn-cancel" onclick="window.history.back()">Batal</button>
                        <button type="submit" class="btn-submit">Update Produk</button>
                    </div>
                </form>
            </div>
            <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">
                                <i class="bi bi-plus-circle me-2"></i>
                                <span id="modalTitle"></span>
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label id="modalLabel" class="form-label"></label>
                            <input type="text" id="newItem" class="form-control" placeholder="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn-submit" onclick="saveNewItem()">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                let currentType = '';
                function previewImage(e) {
                    const img = document.getElementById('preview');
                    if (img) {
                        img.src = URL.createObjectURL(e.target.files[0]);
                        img.style.display = 'block';
                    }
                }
                function showList(type) {
                    document.getElementById(type + 'List').style.display = 'block';
                }
                function selectItem(type, value) {
                    document.getElementById(type).value = value;
                    document.getElementById(type + 'List').style.display = 'none';
                }
                function filterList(type) {
                    const input = document.getElementById(type).value.toLowerCase();
                    const listItems = document.querySelectorAll('#' + type + 'List .dropdown-item:not(.text-success)');
                    listItems.forEach(i => {
                        const t = i.textContent.toLowerCase();
                        i.style.display = t.includes(input) ? 'flex' : 'none';
                    });
                }
                function deleteItem(el, val, type) {
                    if (confirm(`Hapus ${type} "${val}"?`)) {
                        el.parentElement.remove();
                    }
                }
                function openAddModal(type) {
                    currentType = type;
                    document.getElementById('modalTitle').innerText = 'Tambah ' + type.charAt(0).toUpperCase() + type.slice(1) + ' Baru';
                    document.getElementById('modalLabel').innerText = 'Nama ' + type.charAt(0).toUpperCase() + type.slice(1);
                    document.getElementById('newItem').placeholder = 'Masukkan nama ' + type + '...';
                    document.getElementById('newItem').value = '';
                    new bootstrap.Modal(document.getElementById('addModal')).show();
                }
                function saveNewItem() {
                    const val = document.getElementById('newItem').value.trim();
                    if (!val) return alert('Nama tidak boleh kosong.');
                    const newItem = document.createElement('div');
                    newItem.className = 'dropdown-item d-flex justify-content-between align-items-center';
                    newItem.innerHTML = `${val}<i class="bi bi-trash text-danger delete-item" onclick="event.stopPropagation(); deleteItem(this, '${val}', '${currentType}')"></i>`;
                    newItem.onclick = () => selectItem(currentType, val);
                    document.getElementById(currentType + 'List').insertBefore(newItem, document.getElementById(currentType + 'List').lastElementChild);
                    selectItem(currentType, val);
                    bootstrap.Modal.getInstance(document.getElementById('addModal')).hide();
                }
                document.addEventListener('click', e => {
                    ['kategori', 'satuan', 'supplier'].forEach(t => {
                        const list = document.getElementById(t + 'List');
                        const input = document.getElementById(t);
                        if (list && input && !list.contains(e.target) && !input.contains(e.target)) {
                            list.style.display = 'none';
                        }
                    });
                });
                // Prefill dropdowns with existing value if not in list
                document.addEventListener('DOMContentLoaded', function() {
                    ['kategori', 'satuan', 'supplier'].forEach(function(field) {
                        const input = document.getElementById(field);
                        const value = input.value;
                        if (value && !Array.from(document.querySelectorAll('#' + field + 'List .dropdown-item')).some(item => item.textContent.trim() === value)) {
                            const newItem = document.createElement('div');
                            newItem.className = 'dropdown-item d-flex justify-content-between align-items-center';
                            newItem.innerHTML = `${value}<i class="bi bi-trash text-danger delete-item" onclick="event.stopPropagation(); deleteItem(this, '${value}', '${field}')"></i>`;
                            newItem.onclick = () => selectItem(field, value);
                            document.getElementById(field + 'List').insertBefore(newItem, document.getElementById(field + 'List').lastElementChild);
                        }
                    });
                });
            </script>
        @endsection
    </body>
</html>
