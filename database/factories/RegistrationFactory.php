<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $faker = fake('id_ID');
    $sex = $faker->randomElement(['M', 'F']);

    return [
      'token' => (string) fake()->randomNumber(9, true),
      'name' => $faker->name($sex == 'M' ? 'male' : 'female'),
      'id_number' => (string) fake()->randomNumber(8, true) . (string) fake()->randomNumber(8, true),
      'sex' => $sex,
      'blood_type' => $faker->randomElement(['A', 'B', 'AB', 'O']),
      'birthplace' => $faker->city(),
      'birthdate' => $faker->date('Y-m-d'),
      'nationality' => 'indonesia',
      'religion' => $faker->randomElement(['islam', 'kristen', 'katholik', 'hindu', 'buddha', 'konghuchu']),
      'address' => $faker->address(),
      'disability' => '-',
      'father_name' => $faker->name('male'),
      'father_id_number' => (string) fake()->randomNumber(8, true) . (string) fake()->randomNumber(8, true),
      'father_occupation' => $faker->jobTitle(),
      'father_birthplace' => $faker->city(),
      'father_birthdate' => $faker->date('Y-m-d'),
      'father_religion' => $faker->randomElement(['islam', 'kristen', 'katholik', 'hindu', 'buddha', 'konghuchu']),
      'father_income' => (int) $faker->numberBetween(1, 9) . '000000',
      'father_phone_number' => $faker->phoneNumber(),
      'mother_name' => $faker->name('female'),
      'mother_id_number' => (string) fake()->randomNumber(8, true) . (string) fake()->randomNumber(8, true),
      'mother_occupation' => $faker->jobTitle(),
      'mother_birthplace' => $faker->city(),
      'mother_birthdate' => $faker->date('Y-m-d'),
      'mother_religion' => $faker->randomElement(['islam', 'kristen', 'katholik', 'hindu', 'buddha', 'konghuchu']),
      'mother_income' => (int) $faker->numberBetween(1, 9) . '000000',
      'mother_phone_number' => $faker->phoneNumber(),
      'parent_address' => $faker->address(),
      'height' => $faker->numberBetween(100, 150),
      'number_of_siblings' => $faker->numberBetween(1, 9),
      'number_of_child' => 1,
      'distance_to_school' => $faker->numberBetween(1, 9),
    ];
  }
}
