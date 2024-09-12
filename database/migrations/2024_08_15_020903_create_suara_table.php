<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suara', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_calon');
            $table->unsignedBigInteger('id_tps');
            $table->integer('total_perolehan');
            $table->foreign('id_calon')->references('id')->on('calon');
            $table->foreign('id_tps')->references('id')->on('tps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suara');
    }
};
