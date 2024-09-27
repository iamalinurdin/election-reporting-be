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
    Schema::table('addresses', function (Blueprint $table) {
      $table->string('rw')->nullable();
      $table->string('rt')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('addresses', function (Blueprint $table) {
      $table->dropColumn('rw');
      $table->dropColumn('rt');
    });
  }
};
