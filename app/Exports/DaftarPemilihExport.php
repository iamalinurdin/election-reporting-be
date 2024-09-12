<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DaftarPemilihExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $daftar_pemilih;

    public function __construct($daftar_pemilih)
    {
        $this->daftar_pemilih = $daftar_pemilih;
    }

    public function view(): View
    {
        return view('exports.daftar-pemilih', [
            'daftar_pemilihs' => $this->daftar_pemilih,
        ]);
    }

    public function headings(): array
    {
        return [
          'No', 'Nama', 'NIK', 'No HP', 'Alamat', 'Kordinat', 'Foto',
        ];
    }
}
