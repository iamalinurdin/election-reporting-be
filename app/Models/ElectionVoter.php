<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kra8\Snowflake\HasSnowflakePrimary;

class ElectionVoter extends Model
{
  use HasFactory, HasSnowflakePrimary;

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
  protected $appends = [
    'latitude',
    'longitude'
  ];

  /**
   * Undocumented variable
   *
   * @var array
   */
  protected $casts = [
    'id' => 'string',
  ];

  /**
   * Get the volunteer that owns the ElectionVoter
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function volunteer(): BelongsTo
  {
    return $this->belongsTo(Volunteer::class);
  }

  /**
   * Undocumented function
   *
   * @return MorphOne
   */
  public function address(): MorphOne
  {
    return $this->morphOne(Address::class, 'addressable');
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  public function getLatitudeAttribute()
  {
    $coordinate = explode(', ', $this->coordinate);

    return (float) $coordinate[0];
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  public function getLongitudeAttribute()
  {
    $coordinate = explode(', ', $this->coordinate);

    return (float) $coordinate[1];
  }
}
