<?php

namespace Database\Seeders;

use App\Models\DaftarPemilih;
use Illuminate\Database\Seeder;

class DaftarPemilihSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DaftarPemilih::factory(20)->create();
    }
}
