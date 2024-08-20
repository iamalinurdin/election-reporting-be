<?php

namespace App\Exports;

use App\Models\Community;
use Maatwebsite\Excel\Concerns\FromCollection;

class CommunityExport implements FromCollection
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Community::all();
  }
}
