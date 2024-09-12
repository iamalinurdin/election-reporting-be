<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Community;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Community::factory(10)->has(Address::factory())->create();
    }
}
