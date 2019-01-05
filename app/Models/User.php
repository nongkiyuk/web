<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Hash;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * this is define setter for password attribute
     *
     * @param [type] $pass
     * @return void
     */
    public function setPasswordAttribute($pass){
        $this->attributes['password'] = Hash::make($pass);
    }

    public function getPictureAttribute(){
        if(!empty($this->attributes['picture'])){
            return asset(env('PLACE_PROFILE_PATH').$this->attributes['picture']);
        }
        return asset('img/logo.png');
        
    }
}
