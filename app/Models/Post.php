<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kra8\Snowflake\HasSnowflakePrimary;

class Post extends Model
{
    use HasFactory;
    use HasSnowflakePrimary;

    /**
     * Undocumented variable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Undocumented variable.
     *
     * @var array
     */
    protected $casts = [
      'id' => 'string',
    ];

    /**
     * Undocumented function.
     *
     * @return MorphOne
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
