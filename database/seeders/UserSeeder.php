<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    User::factory()->superadmin()->create()->assignRole('super-admin');
    User::factory()->admin()->create()->assignRole('admin');
    User::factory()->volunteer()->create()->assignRole('volunteer');
  }
}
