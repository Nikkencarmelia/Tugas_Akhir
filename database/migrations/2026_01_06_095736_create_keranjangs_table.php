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
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete();
            $table->foreignId('id_produk')->constrained('produks')->cascadeOnDelete();
            $table->foreignId('id_batch')->nullable()->constrained('batches')->nullOnDelete();
            $table->integer('quantity');
            $table->timestamps();

            // Unique constraint: satu user tidak bisa punya item yang sama (produk + batch) lebih dari sekali
            $table->unique(['id_user', 'id_produk', 'id_batch'], 'unique_user_product_batch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjangs');
    }
};
