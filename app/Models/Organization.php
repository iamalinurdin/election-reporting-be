<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kra8\Snowflake\HasSnowflakePrimary;

class Organization extends Model
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
     * Get all of the volunteers for the Party.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function volunteers(): HasMany
    {
        return $this->hasMany(Volunteer::class);
    }
}
