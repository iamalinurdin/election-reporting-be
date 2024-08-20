<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasSnowflakePrimary;
use App\Traits\FilterSortTrait;

class Tps extends Model
{
    use HasFactory;
    use HasSnowflakePrimary;
    use FilterSortTrait;

    protected $table      = 'tps';
    protected $primaryKey = 'id';
    protected $casts      = [
        'id' => 'string',
    ];
    protected $fillable = [
        'nama_tps',
        'alamat',
        'kordinat',
        'penanggungjawab'
    ];
    protected $hidden = [
        'deleted_at',
    ];

    public function relawan(){
      return $this->hasMany(Relawan::class, 'id_tps', 'id');
    }

    public function suaras(){
      return $this->hasMany(Suara::class, 'id_tps', 'id');
    }
}
