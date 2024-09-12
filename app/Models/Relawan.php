<?php

namespace App\Models;

use App\Traits\FilterSortTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasSnowflakePrimary;

class Relawan extends Model
{
    use HasFactory;
    use HasSnowflakePrimary;
    use FilterSortTrait;

    protected $table      = 'relawan';
    protected $primaryKey = 'id';
    protected $casts      = [
        'id'       => 'string',
        'id_user'  => 'string',
        'id_posko' => 'string',
    ];
    protected $fillable = [
        'id_posko',
        'id_tps',
        'id_user',
        'nama',
        'alamat',
        'no_handphone',
        'count_pemilih',
        'star',
    ];
    protected $hidden = [
        'deleted_at',
    ];

    public function posko()
    {
        return $this->belongsTo(Posko::class, 'id_posko', 'id');
    }

    public function tps()
    {
        return $this->belongsTo(Tps::class, 'id_tps', 'id');
    }

    public function daftarPemilih()
    {
        return $this->hasMany(DaftarPemilih::class, 'id_relawan', 'id');
    }
}
