<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');
        $title = $faker->words(5, true);

        return [
          'image'       => 'https://placebear.com/640/360',
          'title'       => $title,
          'slug'        => Str::slug($title),
          'description' => $faker->words(25, true),
          // 'body' => $faker->randomHtml(),
          'body' => $faker->words(150, true),
        ];
    }
}
