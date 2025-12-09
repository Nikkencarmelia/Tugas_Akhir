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
        Schema::create('kode_pos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kecamatan')->constrained('kecamatans')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->constrained('kelurahans')->onDelete('cascade');
            $table->integer('kode_pos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_pos');
    }
};
