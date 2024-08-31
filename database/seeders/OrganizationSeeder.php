<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $organizations = [
      'Suket Teki',
      'Projo',
      'Kombat',
      'IPK'
    ];

    foreach ($organizations as $organization) {
      Organization::create([
        'name' => $organization
      ]);
    }
  }
}
