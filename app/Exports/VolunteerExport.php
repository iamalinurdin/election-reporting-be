<?php

namespace App\Exports;

use App\Models\Volunteer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VolunteerExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Volunteer::with('address', 'user', 'post', 'organization', 'party', 'votingLocation')->get();
  }

  /**
   * Undocumented function
   *
   * @return array
   */
  public function headings(): array
  {
    return [
      'Nama Lengkap',
      'Email',
      'Partai',
      'Organisasi',
      'Posko',
      'Penugasan TPS',
      'NIK',
      'No. Telepon',
      'Alamat Lengkap'
    ];
  }

  /**
   * Undocumented function
   *
   * @param [type] $item
   * @return array
   */
  public function map($item): array
  {
    return [
      $item->user->name,
      $item->user->email,
      $item->party->full_name ?? 'N/A',
      $item->organization->name ?? 'N/A',
      $item->post->name ?? 'N/A',
      $item->votingLocation->name ?? 'N/A',
      $item->nik,
      $item->phone_number,
      $item->address->full_address,
    ];
  }
}
