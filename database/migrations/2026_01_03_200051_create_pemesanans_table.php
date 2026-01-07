<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete();
            $table->foreignId('id_alamat')->nullable()->constrained('alamats')->nullOnDelete();
            $table->foreignId('id_kurir')->nullable()->constrained('users')->nullOnDelete(); // Assign to User (Role Kurir)
            $table->string('kode_pesanan')->unique();
            $table->enum('opsi_pengiriman', ['diantar', 'dipick_up']);
            $table->string('nama_penerima');
            $table->string('no_telepon', 20);
            $table->text('alamat_lengkap')->nullable();
            $table->string('nama_kecamatan')->nullable();
            $table->string('nama_kelurahan')->nullable();
            $table->string('kode_pos', 5)->nullable();
            $table->enum('kendaraan', ['mobil', 'motor'])->nullable();
            $table->integer('subtotal');
            $table->integer('ongkir');
            $table->integer('total');
            $table->enum('status_pesanan', [
                'menunggu_konfirmasi',
                'menunggu_cari_kurir',
                'menunggu_konfirmasi_kurir',
                'ditolak_kurir',
                'menunggu_pembayaran',
                'menunggu_konfirmasi_pembayaran',
                'diproses',
                'siap_diambil',
                'pesanan_telah_diambil',
                'dikirim',
                'sedang_diantar',
                'selesai',
                'dibatalkan',
                'ditolak_staff'
            ])->default('menunggu_konfirmasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
