<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasSnowflakePrimary;

class RecapitulationResult extends Model
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
  protected $casts = [
    'id' => 'string',
  ];
}
