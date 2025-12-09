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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produk')->constrained('produks')->onDelete('cascade');
            $table->date('tgl_masuk');
            $table->integer('stok');
            $table->enum('status_stok', ['tersedia', 'menipis', 'habis']);
            $table->integer('harga_normal');
            $table->integer('harga_saat_ini');
            $table->date('tgl_perubahan_harga');
            $table->date('tgl_kadaluwarsa');
            $table->enum('keterangan_harga', ['normal', 'harga naik', 'diskon']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
