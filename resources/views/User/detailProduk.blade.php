<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Ubi Ungu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .product-container {
            max-width: 1100px; /* Dilebarin dari 1000px jadi 1100px */
            margin: 80px auto 0; /* Turunin dengan margin-top 80px untuk hindari navbar */
            background: white;
            border-radius: 10px;
            padding: 30px; /* Padding sedikit lebih besar untuk feel lebih luas */
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            gap: 30px; /* Gap antar section lebih besar */
        }
        .image-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .product-image {
            width: 100%;
            height: 350px; /* Gambar lebih tinggi untuk match ukuran container */
            background-color: #e0e0e0;
            border-radius: 10px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px; /* Font placeholder sedikit lebih besar */
            color: #666;
        }
        .detail-section {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .product-title {
            font-size: 28px; /* Judul lebih besar */
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }
        .product-price {
            font-size: 24px; /* Harga lebih besar */
            font-weight: bold;
            color: #28a745;
            margin-bottom: 8px;
        }
        .product-weight {
            font-size: 18px; /* Berat lebih besar */
            color: #666;
            margin-bottom: 12px;
        }
        .product-stock {
            font-size: 16px; /* Stok lebih besar */
            color: #666;
            margin-bottom: 25px;
        }
        .product-description {
            font-size: 16px; /* Deskripsi lebih besar */
            color: #555;
            line-height: 1.6;
            margin-bottom: 25px;
            flex-grow: 1;
            text-align: justify; /* Rata kiri-kanan (justified) */
            text-justify: inter-word;
        }
        .quantity-section {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 25px;
        }
        .quantity-label {
            font-size: 18px; /* Label jumlah lebih besar */
            margin-right: 15px;
            font-weight: 600;
            color: #333;
        }
        .qty-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .qty-input {
            width: 60px;
            text-align: center;
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 8px 4px;
            font-size: 16px;
            outline: none;
        }
        .btn-minus, .btn-plus {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            border: 1px solid #198754;
            background: transparent;
            color: #198754;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .btn-minus:hover, .btn-plus:hover {
            background: #198754;
            color: white;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
        }
        .btn {
            flex: 1;
            padding: 18px; /* Tombol aksi lebih besar */
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
            font-weight: 600;
        }
        .btn-outline-success {
            background: transparent;
            color: #198754;
            border: 2px solid #198754; /* Outline success Bootstrap */
        }
        .btn-outline-success:hover {
            background: #198754;
            color: white;
            border-color: #198754;
        }
        .btn-success {
            background: #198754;
            color: white;
            border: none;
        }
        .btn-success:hover {
            background: #157347;
            color: white;
        }
        @media (max-width: 600px) {
            .product-container {
                flex-direction: column;
                margin-top: 20px; /* Di mobile, margin-top lebih kecil */
                padding: 20px;
            }
            .image-section {
                order: 2;
            }
            .quantity-section {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
@extends('components.user')
@section('content')
    <div class="product-container">
        <div class="image-section">
            <!-- Gambar utama (ganti dengan src gambar asli) -->
            <div class="product-image">
                Gambar Ubi Ungu
            </div>
            <!-- Bisa tambah gambar tambahan di bawah jika perlu -->
        </div>

        <div class="detail-section">
            <h1 class="product-title">Ubi Ungu</h1>

            <div class="product-price">Rp 20.000</div>
            <div class="product-weight">2 kg</div>
            <div class="product-stock">Stok: 50</div>

            <div class="product-description">
                Ubi ungu adalah umbi-umbian yang kaya akan antioksidan, vitamin A, dan serat. Rasanya manis dan lembut saat diolah, cocok untuk camilan sehat atau bahan masakan seperti kue dan bubur.
            </div>

            <div class="quantity-section">
                <label class="quantity-label">Jumlah:</label>
                <div class="qty-box">
                    <button class="btn-minus" onclick="updateQuantity(-1)">−</button>
                    <input type="number" class="qty-input" value="1" min="1" max="50">
                    <button class="btn-plus" onclick="updateQuantity(1)">+</button>
                </div>
            </div>

            <div class="action-buttons">
                <button class="btn btn-outline-success">Tambahkan ke Keranjang</button>
                <button class="btn btn-success">Beli Sekarang</button>
            </div>
        </div>
    </div>

    <script>
        function updateQuantity(change) {
            const input = document.querySelector('.qty-input');
            let value = parseInt(input.value) + change;
            value = Math.max(1, Math.min(50, value)); // Batasi min 1, max stok 50
            input.value = value;
        }
    </script>
@endsection
</body>
</html>
