<?php

namespace App\Imports;

use App\Models\Address;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VolunteerImport implements ToModel, WithHeadingRow, SkipsEmptyRows, SkipsOnError, SkipsOnFailure
{
  use SkipsErrors, SkipsFailures;

  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    try {
      $user = User::create([
        'name' => $row['nama'],
        'email' => $row['email'],
        'password' => Hash::make($row['email'])
      ]);

      $user->assignRole('volunteer');

      $volunteer = Volunteer::create([
        'added_by' => '-', // '718870429883831899',
        'user_id' => $user->id,
        'nik' => $row['nik'],
        'voting_location_id' => '-', // '-',
        'post_id' => '-', // '-',
        'phone_number' => $row['no_telepon'],
        'party_id' => '-', // $row['partai'],
        'organization_id' => '-', // $row['organisasi'],
        'coordinate' => '-',
      ]);

      // $volunteer = new Volunteer([
      //   'added_by' => '-', // '718870429883831899',
      //   'user_id' => $user->id,
      //   'nik' => $row['nik'],
      //   'phone_number' => $row['no_telepon'],
      //   'party_id' => '-', // $row['partai'],
      //   'organization_id' => '-', // $row['organisasi'],
      //   'voting_location_id' => '-',
      //   'post_id' => '-',
      //   'coordinate' => '-',
      // ]);

      Address::create([
        'addressable_type' => Volunteer::class,
        'addressable_id' => $volunteer->id,
        'address' => $row['alamat'],
        'subdistrict' => $row['kelurahan'],
        'district' => $row['kecamatan'],
        'city' => "Kota Kediri",
        'province' => "Jawa Timur",
        'rw' => $row['rw'],
        'rt' => $row['rt'],
      ]);

      return $volunteer;

      // return new Volunteer([
      //   'added_by' => '718870429883831899',
      //   'user_id' => $user->id,
      //   'nik' => $row['nik'],
      //   'phone_number' => $row['no_telepon'],
      //   'party_id' => $row['partai'],
      //   'organization_id' => $row['organisasi'],
      //   'voting_location_id' => '-',
      //   'post_id' => '-',
      //   'coordinate' => '-',
      // ]);
    } catch (\Exception $e) {
      // Optionally, log the error for further analysis
      // \Log::error('Import error: ' . $e->getMessage());
    }
  }
}
