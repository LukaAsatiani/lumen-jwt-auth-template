<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EmailConfirmation extends Model{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'confirmation_uri'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
