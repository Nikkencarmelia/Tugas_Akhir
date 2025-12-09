<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk | Food Center</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .container-produk{max-width:900px;margin:40px auto;background:#fff;border-radius:16px;box-shadow:0 8px 20px rgba(0,0,0,0.05);padding:40px 50px}
        h2{font-weight:600;font-size:1.6rem;margin-bottom:30px;color:#2f3e2f;display:flex;align-items:center;gap:10px}
        label{font-weight:500;margin-bottom:6px;color:#444}
        .form-control,.form-select{border-radius:10px;border:1px solid #ccc;padding:10px 12px;transition:.2s}
        .form-control:focus,.form-select:focus{border-color:#16a34a;box-shadow:0 0 0 2px rgba(22,163,74,0.15)}
        .btn-submit{background:#16a34a;border:none;border-radius:10px;padding:10px 18px;color:#fff;font-weight:500}
        .btn-cancel{background:#e5e7eb;border:none;border-radius:10px;padding:10px 18px;color:#333}
        .btn-submit:hover{background:#15803d}
        .img-preview{width:120px;height:120px;border-radius:10px;object-fit:cover;border:1px solid #ddd;margin-top:10px}
        .dropdown-container{position:relative}
        .dropdown-list{position:absolute;z-index:1000;top:100%;left:0;right:0;background:white;border:1px solid #ddd;border-radius:10px;margin-top:4px;box-shadow:0 4px 10px rgba(0,0,0,0.08);display:none;max-height:200px;overflow-y:auto}
        .dropdown-item{padding:8px 12px;cursor:pointer;display:flex;justify-content-between;align-items:center}
        .dropdown-item:hover{background:#f1f5f9}
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
        <input type="file" class="form-control" name="gambar" accept="image/*">
    </div>

    {{-- Nama Produk --}}
    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" class="form-control" name="nama_produk" required>
    </div>

    <div class="row">

        {{-- Kategori --}}
        <div class="col-md-4 mb-3">
            <label>Kategori</label>
            <input list="kategoriList" class="form-control" name="kategori_input" placeholder="Pilih / tulis baru">
            <datalist id="kategoriList">
                @foreach($kategori as $k)
                    <option value="{{ $k->nama_kategori }}">
                @endforeach
            </datalist>
        </div>

        {{-- Satuan --}}
        <div class="col-md-4 mb-3">
            <label>Satuan</label>
            <input list="satuanList" class="form-control" name="satuan_input" placeholder="Pilih / tulis baru">
            <datalist id="satuanList">
                @foreach($satuan as $s)
                    <option value="{{ $s->nama_satuan }}">
                @endforeach
            </datalist>
        </div>

        {{-- Supplier --}}
        <div class="col-md-4 mb-3">
            <label>Supplier</label>
            <input list="supplierList" class="form-control" name="supplier_input" placeholder="Pilih / tulis baru">
            <datalist id="supplierList">
                @foreach($supplier as $sp)
                    <option value="{{ $sp->nama_supplier }}">
                @endforeach
            </datalist>
        </div>

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


{{-- Modal Tambah --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><span id="modalTitle"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label id="modalLabel"></label>
                <input type="text" id="newItem" class="form-control">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-submit" onclick="saveNewItem()">Simpan</button>
            </div>

        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit <span id="editTitle"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label id="editLabel"></label>
                <input type="text" id="editValue" class="form-control">
                <input type="hidden" id="editItemId">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-submit bg-primary" onclick="saveEditItem()">Simpan</button>
            </div>

        </div>
    </div>
</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

let currentType = ""; // kategori / satuan / supplier

/* ================= PREVIEW GAMBAR ================= */
function previewImage(e){
    const img = document.getElementById('preview');
    img.src = URL.createObjectURL(e.target.files[0]);
    img.style.display = 'block';
}

/* ================= DROPDOWN HANDLER ================= */
function showList(type){
    document.getElementById(type + "List").style.display = "block";
}

function hideList(type){
    document.getElementById(type + "List").style.display = "none";
}

function selectItem(type, id, text){
    document.getElementById(type).value = text;  // ⬅ karena create sekaligus, value = nama
    document.getElementById(type + "Text").value = text;
    hideList(type);
}

function filterList(type){
    const keyword = document.getElementById(type + "Text").value.toLowerCase();
    const items = document.querySelectorAll(`#${type}List .dropdown-item`);

    items.forEach(i => {
        i.style.display = i.textContent.toLowerCase().includes(keyword)
            ? "flex"
            : "none";
    });
}


/* ================== ADD ITEM (TAMBAH) ================== */
function openAddModal(type){
    currentType = type;
    document.getElementById("modalTitle").innerText = "Tambah " + type;
    document.getElementById("newItem").value = "";

    new bootstrap.Modal(document.getElementById("addModal")).show();
}

function saveNewItem(){
    const name = document.getElementById("newItem").value.trim();
    if(!name){
        alert("Nama tidak boleh kosong");
        return;
    }

    const list = document.getElementById(currentType + "List");

    const div = document.createElement("div");
    div.className = "dropdown-item d-flex justify-content-between";
    div.innerHTML = `
        <span onclick="selectItem('${currentType}', null, '${name}')">${name}</span>
        <span>
            <i class="bi bi-pencil-square text-primary me-2" onclick="openEditModal('${currentType}', null, '${name}')"></i>
            <i class="bi bi-trash text-danger" onclick="deleteItem(this, '${currentType}', null)"></i>
        </span>
    `;

    list.insertBefore(div, list.lastElementChild);

    selectItem(currentType, null, name);

    bootstrap.Modal.getInstance(document.getElementById("addModal")).hide();
}


/* ================== EDIT ITEM ================== */
function openEditModal(type, id, text){
    currentType = type;
    document.getElementById("editValue").value = text;
    new bootstrap.Modal(document.getElementById("editModal")).show();
}

function saveEditItem(){
    const newName = document.getElementById("editValue").value.trim();
    if(!newName){
        alert("Nama tidak boleh kosong");
        return;
    }

    const list = document.getElementById(currentType + "List");

    list.querySelectorAll(".dropdown-item span:first-child").forEach(span => {
        if(span.innerText === document.getElementById("editValue").defaultValue){
            span.innerText = newName;
        }
    });

    selectItem(currentType, null, newName);

    bootstrap.Modal.getInstance(document.getElementById("editModal")).hide();
}


/* ================== DELETE ================== */
function deleteItem(el, type, id){
    if(!confirm("Yakin ingin menghapus?")) return;

    el.closest(".dropdown-item").remove();

    const selected = document.getElementById(type).value;
    const inputText = document.getElementById(type + "Text").value;

    if(selected === inputText){
        document.getElementById(type).value = "";
        document.getElementById(type + "Text").value = "";
    }
}


/* ================== AUTO CLOSE DROPDOWN ================== */
document.addEventListener("click", e => {
    ["kategori", "satuan", "supplier"].forEach(type => {
        const list = document.getElementById(type + "List");
        const input = document.getElementById(type + "Text");

        if(list && input && !list.contains(e.target) && !input.contains(e.target)){
            list.style.display = "none";
        }
    });
});

</script>



</body>
</html>
