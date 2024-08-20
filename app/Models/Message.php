<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasSnowflakePrimary;

class Message extends Model
{
    use HasFactory;
    use HasSnowflakePrimary;

    protected $table      = 'message';
    protected $primaryKey = 'id';
    protected $casts      = [
        'id_user' => 'string',
    ];
    protected $fillable = [
        'id_user',
        'title',
        'description'
    ];
}
