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
        Schema::table('election_voters', function (Blueprint $table) {
            $table->enum('voter_type', ['dpt', 'non-dpt'])->nullable()->after('evidence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('election_voters', function (Blueprint $table) {
            $table->dropColumn('voter_type');
        });
    }
};
