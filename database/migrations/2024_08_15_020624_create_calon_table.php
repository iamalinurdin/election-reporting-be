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
        Schema::create('calon', function (Blueprint $table) {
            $table->id();
            $table->string('no_urut');
            $table->string('nama_calon');
            $table->string('nama_wakil_calon');
            $table->string('foto_calon');
            $table->string('foto_wakil_calon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon');
    }
};
