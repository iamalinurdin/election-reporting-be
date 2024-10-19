<?php

namespace App\Imports;

use App\Models\Address;
use App\Models\User;
use App\Models\Volunteer;
use Error;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class VolunteerImport implements ToModel, WithHeadingRow, SkipsEmptyRows, SkipsOnError, SkipsOnFailure, WithValidation
{
  use SkipsErrors, SkipsFailures, Importable;

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
        'coordinate' => '-7.817332517610728, 112.0124719413919',
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

  public function rules(): array
  {
    return [
      'nama' => ['required'],
      'email' => ['required'],
      'no_telepon' => ['required'],
      'nik' => ['required'],
    ];
  }

  /**
   * @param \Throwable $e
   */
  public function onError(\Throwable $e)
  {
    dd($e);
    // Handle the exception how you'd like.
  }
}
