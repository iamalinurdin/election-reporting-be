<?php

namespace Database\Seeders;

use App\Models\Tokoh;
use Illuminate\Database\Seeder;

class TokohSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Tokoh::factory(20)->create();
    }
}
