<?php

namespace App\Models;

use App\Traits\FilterSortTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasSnowflakePrimary;

class Calon extends Model
{
    use HasFactory;
    use HasSnowflakePrimary;
    use FilterSortTrait;

    protected $table      = 'calon';
    protected $primaryKey = 'id';
    protected $casts      = [
      'id' => 'string',
    ];

    protected $fillable = [
        'no_urut',
        'nama_calon',
        'nama_wakil_calon',
        'foto_calon',
        'foto_wakil_calon',
    ];

    public function suaras()
    {
        return $this->hasMany(Suara::class, 'id_calon', 'id');
    }
}
