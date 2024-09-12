<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimony>
 */
class TestimonyFactory extends Factory
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
          'image_path' => 'https://placebear.com/360/360',
          'name'       => fake()->name(),
          'detail_id'  => $fakerId->jobTitle(),
          'detail_en'  => $fakerEn->jobTitle(),
          'body_id'    => $fakerId->words(30, true),
          'body_en'    => $fakerEn->words(30, true),
        ];
    }
}
