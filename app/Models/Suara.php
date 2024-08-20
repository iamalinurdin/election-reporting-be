<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasSnowflakePrimary;
use App\Traits\FilterSortTrait;

class Suara extends Model
{
    use HasFactory;
    use HasSnowflakePrimary;
    protected $table      = 'suara';
    protected $primaryKey = 'id';
    protected $casts      = [
      'id' => 'string',
      'id_calon' => 'string',
      'id_tps' => 'string'
    ];

    protected $fillable = [
        'id_calon',
        'id_tps',
        'total_perolehan',
    ];

    public function calon(){
        return $this->belongsTo(Calon::class, 'id_calon', 'id');
    }

    public function tps(){
        return $this->belongsTo(Tps::class, 'id_tps', 'id');
    }
}
