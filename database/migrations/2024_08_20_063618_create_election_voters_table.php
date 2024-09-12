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
        Schema::create('election_voters', function (Blueprint $table) {
            $table->id();
            $table->string('volunteer_id');
            $table->string('voting_location_id');
            $table->string('name');
            $table->enum('age_classification', ['teenager', 'adult', 'elderly']);
            $table->enum('sex', ['male', 'female']);
            $table->string('nik')->unique();
            $table->string('coordinate');
            $table->string('evidence');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('election_voters');
    }
};
