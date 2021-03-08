<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\UserHasRole;
use App\Models\Role;

trait User {
    public function getRole(){
        $role_id = UserHasRole::where('user_id', Auth::user()->id)->first()->role_id;
        return Role::find($role_id)->name;
    }   
}