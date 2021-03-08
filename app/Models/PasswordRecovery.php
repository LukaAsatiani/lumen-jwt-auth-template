<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordRecovery extends Model{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'recovery_uri'
    ];
}
