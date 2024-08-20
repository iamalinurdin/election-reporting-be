<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Posko;
use App\Models\Tps;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Relawan>
 */
class RelawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      $fakerId = fake('id_ID');
      $titleId = $fakerId->words(5, true);

      return [
        'id_posko' => Posko::factory(),
        'id_tps'  => Tps::factory(),
        'nama' => $titleId,
        'alamat' => $titleId,
        'no_handphone' =>"+628570000000",
        'count_pemilih' => 0,
        'star' => 0,
      ];
    }
}
