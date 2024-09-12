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
    Schema::table('registrations', function (Blueprint $table) {
      $table->string('organization_id')->nullable()->after('has_organization');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('registrations', function (Blueprint $table) {
      $table->dropColumn('organization_id');
    });
  }
};
