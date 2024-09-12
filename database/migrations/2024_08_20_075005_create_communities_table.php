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
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->string('volunteer_id');
            $table->string('name');
            $table->string('nik')->nullable();
            $table->string('phone_number');
            $table->string('coordinate');
            $table->string('religion');
            $table->string('education');
            $table->date('birthdate');
            $table->enum('sex', ['male', 'female']);
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};
