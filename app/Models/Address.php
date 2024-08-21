<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kra8\Snowflake\HasSnowflakePrimary;

class Address extends Model
{
  use HasFactory, HasSnowflakePrimary;

  protected $appends = ['full_address'];

  /**
   * Undocumented variable
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * Undocumented variable
   *
   * @var array
   */
  protected $casts = [
    'id' => 'string',
  ];

  /**
   * Undocumented function
   *
   * @return MorphTo
   */
  public function addressable(): MorphTo
  {
    return $this->morphTo();
  }

  public function getFullAddressAttribute()
  {
    return "$this->address, $this->subdistrict, $this->district, $this->city, $this->province";
  }
}
