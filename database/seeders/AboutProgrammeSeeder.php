<?php

namespace Database\Seeders;

use App\Models\AboutProgramme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutProgrammeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    AboutProgramme::factory(3)->create();
  }
}
