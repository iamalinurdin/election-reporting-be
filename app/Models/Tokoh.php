<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasSnowflakePrimary;
use App\Traits\FilterSortTrait;

class Tokoh extends Model
{
    use HasFactory;
    use HasSnowflakePrimary;
    use FilterSortTrait;

    protected $table      = 'tokoh';
    protected $primaryKey = 'id';
    protected $casts      = [
        'id' => 'string',
    ];
    protected $fillable = [
        'nama',
        'alamat',
        'no_handphone',
        'kategori'
    ];
    protected $hidden = [
        'deleted_at',
    ];
}
