<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AboutProgramme>
 */
class AboutProgrammeFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $fakerId = fake('id_ID');
    $fakerEn = fake('en_GB');

    return [
      'text_id' => $fakerId->words(5, true),
      'text_en' => $fakerEn->words(5, true),
    ];
  }
}
