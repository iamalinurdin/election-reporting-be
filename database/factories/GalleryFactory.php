<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
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
          'path'       => 'https://placebear.com/640/360',
          'caption_id' => $fakerId->words(5, true),
          'caption_en' => $fakerEn->words(5, true),
        ];
    }
}
