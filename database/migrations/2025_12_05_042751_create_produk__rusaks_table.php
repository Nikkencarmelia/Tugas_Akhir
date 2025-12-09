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
        Schema::create('produk_rusaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produk')->constrained('produks')->onDelete('cascade');
            $table->foreignId('id_batch')->constrained('batches')->onDelete('cascade');
            $table->date('tgl_rusak');
            $table->integer('jumlah_rusak');
            $table->enum('tingkat_rusak', ['ringan', 'sedang', 'berat']);
            $table->string('keterangan');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_rusaks');
    }
};
