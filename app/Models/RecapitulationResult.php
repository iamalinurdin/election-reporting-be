<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

  /**
   * Get the participant that owns the RecapitulationResult
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function participant(): BelongsTo
  {
    return $this->belongsTo(ElectionParticipant::class, 'election_participant_id', 'id');
  }

  /**
   * Get the votingLocation that owns the RecapitulationResult
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function votingLocation(): BelongsTo
  {
    return $this->belongsTo(VotingLocation::class);
  }
}
