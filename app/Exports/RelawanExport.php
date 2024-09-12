<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RelawanExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $relawan;

    public function __construct($relawan)
    {
        $this->relawan = $relawan;
    }

    public function view(): View
    {
        return view('exports.relawan', [
            'relawans' => $this->relawan,
        ]);
    }

    public function headings(): array
    {
        return [
          'No', 'Nama', 'Alamat', 'No HP', 'Jumlah Pemilih', 'Bintang', 'Alamat Posko', 'Penanggung Jawab', 'Nama TPS', 'Alamat TPS',
        ];
    }
}
