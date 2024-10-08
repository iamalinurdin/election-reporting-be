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
   * Undocumented variable
   *
   * @var array
   */
  protected $appends = [
    'latitude',
    'longitude'
  ];

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
   * Get the addedBy that owns the Volunteer
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function addedBy(): BelongsTo
  {
    return $this->belongsTo(User::class, 'added_by');
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

  /**
   * Get the party that owns the Volunteer
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function party(): BelongsTo
  {
    return $this->belongsTo(Party::class);
  }

  /**
   * Get the organization that owns the Volunteer
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function organization(): BelongsTo
  {
    return $this->belongsTo(Organization::class);
  }
}
