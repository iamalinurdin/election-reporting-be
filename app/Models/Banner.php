<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasSnowflakePrimary;
use App\Traits\FilterSortTrait;

class Banner extends Model
{
    use HasFactory;
    use HasSnowflakePrimary;
    use FilterSortTrait;

    protected $table      = 'banner';
    protected $primaryKey = 'id';
    protected $casts      = [
      'id' => 'string',
  ];

    protected $fillable = [
        'photo',
        'title',
        'description',
        'link'
    ];
}
