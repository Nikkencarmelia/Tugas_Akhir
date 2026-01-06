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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('id_google')->nullable()->unique();
            $table->string('nama_lengkap');
            $table->enum('role',['staff_produk', 'staff_purchasing', 'super_admin', 'user', 'kurir'])->default('user');
            $table->string('email')->unique();
            $table->string('no_telepon')->nullable();
            $table->string('password')->nullable();
            $table->enum('status_online', ['aktif', 'tidak_aktif'])->default('tidak_aktif');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });



        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');

        Schema::dropIfExists('sessions');
    }
};
