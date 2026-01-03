<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - Food Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+Javanese:wght@400..700&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #F7F7F9;
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }
        .email-container {
            max-width: 1000px;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .left-box {
            background-color: #2A522A;
            color: white;
            padding: 40px;
            border-top-right-radius: 60px;
            border-bottom-right-radius: 60px;
            text-align: center;
        }
        .left-box h2 {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .left-box p {
            margin-bottom: 20px;
            opacity: 0.9;
        }
        .left-box img {
            max-height: 200px;
            width: auto;
        }
        .right-box {
            background-color: white;
            padding: 40px;
            border-top-left-radius: 60px;
            border-bottom-left-radius: 60px;
        }
        .right-box h2 {
            color: #2A522A;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .right-box p {
            color: #555;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .btn {
            display: block;
            background-color: #2A522A;
            color: white !important;
            padding: 12px 30px;
            text-decoration: none !important;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            margin: 20px auto;
            transition: background-color 0.3s;
            text-align: center;
            max-width: 300px;
        }
        .btn:hover {
            background-color: #198754;
            color: white !important;
        }
        .link-url {
            word-break: break-all;
            color: #666;
            font-size: 14px;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #F7F7F9;
            color: #888;
            font-size: 14px;
        }
        .footer .logo {
            color: #2A522A;
            font-weight: bold;
            font-size: 16px;
        }
        @media (max-width: 768px) {
            .email-container {
                border-radius: 10px;
            }
            .left-box, .right-box {
                border-radius: 0 !important;
            }
            .left-box {
                padding: 20px;
            }
            .right-box {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- KIRI (Mirip Login Page) -->
        <div class="left-box">
            <h2>Food Center</h2>
            <p>Dinas Ketahanan Pangan Kabupaten Kutai Barat</p>
        </div>

        <!-- KANAN (Konten Email) -->
        <div class="right-box">
            <h2>Lupa Kata Sandi?</h2>
            <p>Hai {{ $user->nama_lengkap ?? 'Pengguna' }},</p>

            <p>Kami menerima permintaan untuk mereset kata sandi akun Food Center Anda. Jika Anda tidak meminta ini, abaikan email ini.</p>

            <p>Klik tombol di bawah ini untuk membuat kata sandi baru. Link ini hanya berlaku selama 60 menit.</p>

            @php
                $actionUrl = route('password.reset', $token) . '?email=' . urlencode($user->email);
            @endphp
            <div style="text-align: center; margin: 20px 0;">
                <a href="{{ $actionUrl }}" class="btn" style="color: white !important; text-decoration: none !important;">Reset Kata Sandi Sekarang</a>
            </div>

            <p>Atau salin link ini ke browser Anda:</p>
            <div class="link-url">{{ $actionUrl }}</div>

        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="logo">Food Center - Dinas Ketahanan Pangan Kab. Kutai Barat</p>
            <p>&copy; 2026 Food Center. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
