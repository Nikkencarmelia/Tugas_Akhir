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
        Schema::create('alamats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kecamatan')->constrained('kecamatans')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->constrained('kelurahans')->onDelete('cascade');
            $table->foreignId('id_kode_pos')->constrained('kode_pos')->onDelete('cascade');
            $table->string('nama_penerima');
            $table->integer('no_telpon');
            $table->string('alamat_lengkap');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamats');
    }
};
