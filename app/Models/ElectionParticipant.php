<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kra8\Snowflake\HasSnowflakePrimary;

class ElectionParticipant extends Model
{
  use HasFactory, HasSnowflakePrimary;

  /**
   * Undocumented variable
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * Get all of the recapitulations for the ElectionParticipant
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function recapitulations(): HasMany
  {
    return $this->hasMany(RecapitulationResult::class);
  }
}
