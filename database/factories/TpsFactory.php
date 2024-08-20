<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tps>
 */
class TpsFactory extends Factory
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
        'nama_tps' => $titleId,
        'alamat' => $titleId,
        'kordinat' => '-6.193125,106.821810',
        'penanggungjawab' => Str::slug($titleId),
      ];
    }
}
