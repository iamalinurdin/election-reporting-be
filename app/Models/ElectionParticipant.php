<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kra8\Snowflake\HasSnowflakePrimary;

class ElectionParticipant extends Model
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
     * Get all of the recapitulations for the ElectionParticipant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recapitulationResults(): HasMany
    {
        return $this->hasMany(RecapitulationResult::class, 'election_participant_id', 'id');
    }
}
