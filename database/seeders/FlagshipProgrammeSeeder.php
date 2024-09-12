<?php

namespace Database\Seeders;

use App\Models\FlagshipProgramme;
use Illuminate\Database\Seeder;

class FlagshipProgrammeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FlagshipProgramme::factory(3)->create();
    }
}
