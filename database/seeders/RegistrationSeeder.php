<?php

namespace Database\Seeders;

use App\Models\Registration;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Registration::create([
          "name"         => "Enjang",
          "email"        => "enjang@gmail.com",
          "phone_number" => "081234567891",
          "nik"          => "1234567890123457",
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
