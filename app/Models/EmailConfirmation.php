<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailConfirmation extends Model{
    protected $fillable = [
        'user_id', 'confirmation_uri'
    ];
}
