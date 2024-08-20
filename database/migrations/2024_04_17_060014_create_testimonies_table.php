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
    Schema::create('testimonies', function (Blueprint $table) {
      $table->id();
      $table->string('image_path');
      $table->string('name');
      $table->string('detail_id');
      $table->string('detail_en');
      $table->text('body_id');
      $table->text('body_en');
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('testimonies');
  }
};
