<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kra8\Snowflake\HasSnowflakePrimary;

class Volunteer extends Model
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
   * Undocumented function
   *
   * @return MorphOne
   */
  public function address(): MorphOne
  {
    return $this->morphOne(Address::class, 'addressable');
  }

  /**
   * Get the user that owns the Volunteer
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Get the post that owns the Volunteer
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function post(): BelongsTo
  {
    return $this->belongsTo(Post::class);
  }

  /**
   * Get the votingLocation that owns the Volunteer
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function votingLocation(): BelongsTo
  {
    return $this->belongsTo(VotingLocation::class);
  }

  /**
   * Get all of the voters for the Volunteer
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function voters(): HasMany
  {
    return $this->hasMany(ElectionVoter::class);
  }
}
