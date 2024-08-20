<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tokoh>
 */
class TokohFactory extends Factory
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
          'nama' => $titleId,
          'alamat' => $titleId,
          'no_handphone' =>"+628570000000",
        ];
    }
}
