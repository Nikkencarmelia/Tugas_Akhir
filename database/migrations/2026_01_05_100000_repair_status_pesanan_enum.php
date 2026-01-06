<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Redefine the ENUM to ensure 'menunggu_konfirmasi_kurir' exists
        // Using raw statement to ensure it works across connection types if supported, 
        // but strictly for MySQL which this project seems to use.
        DB::statement("ALTER TABLE pemesanans MODIFY COLUMN status_pesanan ENUM(
            'menunggu_konfirmasi',
            'menunggu_cari_kurir',
            'menunggu_konfirmasi_kurir',
            'ditolak_kurir',
            'ditolak_staff',
            'ditolak_staff_diambil',
            'menunggu_pembayaran',
            'menunggu_konfirmasi_pembayaran',
            'menunggu_verifikasi_pembayaran',
            'menyiapkan_pesanan',
            'diproses',
            'siap_diambil',
            'siap_diambil_dikirim',
            'dikirim',
            'sedang_diantar',
            'pesanan_telah_diambil',
            'selesai',
            'dibatalkan'
        ) DEFAULT 'menunggu_konfirmasi'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse as allowing more enums is generally safe
    }
};
