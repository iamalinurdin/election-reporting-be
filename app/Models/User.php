<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kra8\Snowflake\HasSnowflakePrimary;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanResetPassword
{
  use HasFactory, Notifiable, HasRoles, HasApiTokens, Notifiable, HasSnowflakePrimary;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'roles'
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
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Undocumented variable
   *
   * @var string
   */
  protected $guard_name = 'web';

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  /**
   * Undocumented variable
   *
   * @var array
   */
  protected $appends = [
    'role'
  ];

  /**
   * Undocumented function
   *
   * @return string
   */
  public function getRoleAttribute(): string
  {
    return $this->roles[0]->name;
  }
}
