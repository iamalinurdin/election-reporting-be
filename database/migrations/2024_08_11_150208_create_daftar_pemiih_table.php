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
        Schema::create('daftar_pemiih', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_relawan')->nullable();
            $table->string('nama_pemilih');
            $table->string('nik');
            $table->string('alamat');
            $table->string('kordinat');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_pemiih');
    }
};
