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
    Schema::create('public_figures', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('phone_number');
      $table->string('coordinate');
      $table->enum('type', ['agama', 'masyarakat']);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('public_figures');
  }
};
