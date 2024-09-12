<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
          ArticleSeeder::class,
          // GallerySeeder::class,
          // TestimonySeeder::class,
          // MissionSeeder::class,
          RolePermissionSeeder::class,
          UserSeeder::class,
          PostSeeder::class,
          VotingLocationSeeder::class,
          RegistrationSeeder::class,
          CommunitySeeder::class,
          // FlagshipProgrammeSeeder::class,
          // RegistrationSeeder::class,
          PoskoSeeder::class,
          RelawanSeeder::class,
          // TokohSeeder::class,
          TpsSeeder::class,
          DaftarPemilihSeeder::class,
          // BannerSeeder::class,
        ]);
    }
}
