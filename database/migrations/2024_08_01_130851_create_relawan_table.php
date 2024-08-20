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
        Schema::create('relawan', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('id_posko');
          $table->unsignedBigInteger('id_tps')->nullable();
          $table->unsignedBigInteger('id_user')->nullable();
          $table->string('nama');
          $table->string('alamat');
          $table->string('no_handphone');
          $table->integer('count_pemilih')->nullable();
          $table->integer('star')->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relawan');
    }
};
