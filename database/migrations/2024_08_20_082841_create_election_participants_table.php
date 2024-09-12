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
        Schema::create('election_participants', function (Blueprint $table) {
            $table->id();
            $table->string('election_number', 2);
            $table->enum('election_type', ['presiden', 'gubernur', 'walikota', 'bupati']);
            $table->string('participant_name');
            $table->string('vice_participant_name');
            $table->string('participant_photo');
            $table->string('vice_participant_photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('election_participants');
    }
};
