<?php 

namespace App\Models;

use App\Models\EmailConfirmation;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject {
    use Authenticatable, Authorizable;

    protected $fillable = [
        'username', 'email'
    ];

    protected $hidden = [
        'password',
    ];

    protected $attributes = [
        'confirmed' => false
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function emailConfirmation(){
        return $this->hasOne(EmailConfirmation::class, 'user_id');
    }

    public function passwordRecovery(){
        return $this->hasOne(EmailConfirmation::class, 'user_id');
    }

    public function getRole(){
        $role_id = UserHasRole::where('user_id', $this->id)->first()->role_id;
        return Role::find($role_id)->name;
    }   

    public function setRole($role){
        $role_id = Role::where('name', $role)->first()->id;
        $userRole = new UserHasRole();
        $userRole->user_id = $this->id;
        $userRole->role_id = $role_id;
        $userRole->save();
    }
}