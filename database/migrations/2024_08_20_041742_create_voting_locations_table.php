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
        Schema::create('voting_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('coordinator');
            $table->string('phone_number');
            $table->string('coordinate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voting_locations');
    }
};
