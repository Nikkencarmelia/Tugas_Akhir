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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori')->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('id_satuan')->constrained('satuans')->onDelete('cascade');
            $table->foreignId('id_supplier')->constrained('suppliers')->onDelete('cascade');
            $table->string('nama_produk');
            $table->integer('jumlah_satuan');
            $table->integer('estimasi_kadaluwarsa_hari')->nullable();
            $table->enum('status_tampil', ['Ditampilkan', 'Diarsipkan'])->default('Ditampilkan');
            $table->string('deskripsi');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
