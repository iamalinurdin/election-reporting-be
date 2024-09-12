<?php

namespace Database\Factories;

use App\Models\Relawan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DaftarPemilih>
 */
class DaftarPemilihFactory extends Factory
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
          'id_relawan'   => Relawan::factory(),
          'nama_pemilih' => $titleId,
          'alamat'       => $titleId,
          'nik'          => "35780212010001",
          'kordinat'     => 0,
          'photo'        => "https://placebear.com/640/360",
        ];
    }
}
