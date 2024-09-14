<?php

namespace App\Exports;

use App\Models\ElectionVoter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VoterExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return ElectionVoter::with('address', 'volunteer', 'votingLocation')->get();
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
      'Ditambahkan Oleh',
      'TPS',
      'NIK',
      'Klasifikasi Umur',
      'Jenis Kelamin',
      'URL Foto',
      'Jenis Pemilih',
      'Koordinat'
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
      $item->name,
      $item->volunteer->user->name,
      $item->votingLocation->name,
      $item->nik,
      $this->getAgeClassification($item->age_classification),
      $item->sex == 'male' ? 'Laki-laki' : 'Wanita',
      $item->evidence,
      $item->voter_type == 'dpt' ? 'Pemilih' : 'Bukan Pemilih',
      $item->coordinate
    ];
  }

  /**
   * Undocumented function
   *
   * @param string $type
   * @return string
   */
  private function getAgeClassification(string $type): string
  {
    if ($type == 'elderly') {
      return 'Lansia';
    } else if ($type == 'adult') {
      return 'Dewasa';
    } else {
      return 'Remaja';
    }
  }
}
