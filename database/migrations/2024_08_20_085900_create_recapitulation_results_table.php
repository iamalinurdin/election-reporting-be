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
    Schema::create('recapitulation_results', function (Blueprint $table) {
      $table->id();
      $table->string('voting_location_id');
      $table->string('election_participant_id');
      $table->integer('vote_counts')->default(0);
      $table->string('evidence');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('recapitulation_results');
  }
};
