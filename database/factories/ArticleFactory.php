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
    $fakerId = fake('id_ID');
    $fakerEn = fake('en_GB');
    $titleId = $fakerId->words(5, true);
    $titleEn = $fakerEn->words(5, true);

    return [
      'image' => 'https://placebear.com/640/360',
      'title_id' => $titleId,
      'title_en' => $titleEn,
      'slug_id' => Str::slug($titleId),
      'slug_en' => Str::slug($titleEn),
      'description_id' => $fakerId->words(25, true),
      'description_en' => $fakerEn->words(25, true),
      'body_id' => $fakerId->words(150, true),
      'body_en' => $fakerEn->words(150, true),
    ];
  }
}
