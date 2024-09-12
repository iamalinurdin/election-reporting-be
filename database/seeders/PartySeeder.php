<?php

namespace Database\Seeders;

use App\Models\Party;
use Illuminate\Database\Seeder;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parties = [
          [
            'abbr'      => 'Golkar',
            'full_name' => 'Partai Golongan Karya',
          ],
          [
            'abbr'      => 'Gerindra',
            'full_name' => 'Partai Gerindra',
          ],
          [
            'abbr'      => 'PDIP',
            'full_name' => 'Partai Demokrasi Indonesia Perjuangan',
          ],
          [
            'abbr'      => 'Demokrat',
            'full_name' => 'Partai Demokrat',
          ],
          [
            'abbr'      => 'PKS',
            'full_name' => 'Partai Keadilan Sejahtera',
          ],
          [
            'abbr'      => 'PPP',
            'full_name' => 'Partai Persatuan Pembangungan',
          ],
          [
            'abbr'      => 'PSI',
            'full_name' => 'Partai Solidaritas Indonesia',
          ],
          [
            'abbr'      => 'PKN',
            'full_name' => 'Partai Kebangkitan Nusantara',
          ],
          [
            'abbr'      => 'Garuda',
            'full_name' => 'Partai Garuda',
          ],
          [
            'abbr'      => 'PBB',
            'full_name' => 'Partai Bulan Bintang',
          ],
          [
            'abbr'      => 'Gelora',
            'full_name' => 'Partai Gelora',
          ],
        ];

        foreach ($parties as $party) {
            Party::create([
              'abbr'      => $party['abbr'],
              'full_name' => $party['full_name'],
            ]);
        }
    }
}
