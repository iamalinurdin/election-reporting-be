<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
          "name"         => "Posko Cabang Mampang VIII 1",
          "post_type"    => "deputy",
          "coordinator"  => "Dadang",
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
