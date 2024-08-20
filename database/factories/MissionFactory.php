<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mission>
 */
class MissionFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $random = fake()->numberBetween(10, 15);
    $fakerId = fake('id_ID');
    $fakerEn = fake('en_GB');

    return [
      'text_id' => $fakerId->words($random, true),
      'text_en' => $fakerEn->words($random, true)
    ];
  }

  public function vision(): Factory
  {
    return $this->state(function (array $attributes) {
      return [
        'type' => 'vision'
      ];
    });
  }
  
  public function mission(): Factory
  {
    return $this->state(function (array $attributes) {
      return [
        'type' => 'mission'
      ];
    });
  }
}
