<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuration::create([
          'app_name' => 'Web Calon Walikota',
          'color'    => '#eaeaea',
          'logo'     => 'http://via.placeholder.com/120',
        ]);
    }
}
