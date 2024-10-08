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
    Schema::create('addresses', function (Blueprint $table) {
      $table->id();
      $table->string('addressable_type');
      $table->string('addressable_id');
      $table->text('address');
      $table->string('subdistrict');
      $table->string('district');
      $table->string('city');
      $table->string('province');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('addresses');
  }
};
