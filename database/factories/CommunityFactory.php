<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Community>
 */
class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'volunteer_id' => '1',
          'name'         => fake()->name(),
          'nik'          => fake()->randomNumber(5, true),
          'phone_number' => fake()->phoneNumber(),
          'coordinate'   => fake()->latitude() . ', ' . fake()->longitude(),
          'religion'     => fake()->randomElement(['islam', 'protestan', 'katholik', 'hindu', 'buddha', 'khonghucu']),
          'education'    => fake()->randomElement(['sd', 'smp', 'sma/smk', 'diploma 1', 'diploma 2', 'diploma 3', 'sarjana', 'magister', 'doktoral']),
          'birthdate'    => fake()->date(),
          'sex'          => fake()->randomElement(['male', 'female']),
          'description'  => fake()->text(),
          'photo'        => fake()->imageUrl(),
        ];
    }
}
