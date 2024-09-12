<?php

namespace Database\Seeders;

use App\Models\VotingLocation;
use Illuminate\Database\Seeder;

class VotingLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VotingLocation::create([
          "name"         => "TPS Mampang VIII 1",
          "coordinator"  => "Ruhiyat",
          "phone_number" => "081234567890",
          "coordinate"   => "-6.247046187661611, 106.83210611343385",
        ])->address()->create([
          "address"     => "Jl. Mampang VIII",
          "subdistrict" => "Tegal Parang",
          "district"    => "Mampang Prapatan",
          "city"        => "Jakarta Selatan",
          "province"    => "DKI Jakarta",
        ]);
    }
}
