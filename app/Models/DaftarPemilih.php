<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FilterSortTrait;
use Kra8\Snowflake\HasSnowflakePrimary;

class DaftarPemilih extends Model
{
    use HasFactory;
    use HasSnowflakePrimary;
    use FilterSortTrait;

    protected $table      = 'daftar_pemiih';
    protected $primaryKey = 'id';
    protected $casts      = [
        'id' => 'string',
        'id_relawan' => 'string'
    ];
    protected $fillable = [
        'id_relawan',
        'nama_pemilih',
        'nik',
        'alamat',
        'kordinat',
        'photo'
    ];
    protected $hidden = [
        'deleted_at',
    ];

    public function relawan(){
      return $this->belongsTo(Relawan::class, 'id_relawan', 'id');
    }
}
