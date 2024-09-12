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
        Schema::create('flagship_programmes', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('text_id');
            $table->string('text_en');
            $table->string('description_id');
            $table->string('description_en');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flagship_programmes');
    }
};
