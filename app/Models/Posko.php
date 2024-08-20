<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasSnowflakePrimary;
use App\Traits\FilterSortTrait;

class Posko extends Model
{
    use HasFactory;
    use HasSnowflakePrimary;
    use FilterSortTrait;


    protected $table      = 'posko';
    protected $primaryKey = 'id';
    protected $casts      = [
        'id' => 'string',
    ];
    protected $fillable = [
        'alamat',
        'kordinat',
        'penanggungjawab',
        'no_handphone'
    ];

    public function relawan(){
      return $this->hasMany(Relawan::class, 'id_posko', 'id');
    }
}
