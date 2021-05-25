<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','role','email', 'password','gender','dob','contact1','contact2','city','area','approved_at'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
        return $this->belongsTo(Roles::class,'role');
    }

    public function isAdmin() {
        return $this->role == 1 ? TRUE : FALSE;
    }

    public function isRider() {
        return $this->role == 2 ? TRUE : FALSE;
    }


    public function isCustomer() {
        return $this->role == 3 ? TRUE : FALSE;
    }

    public function riders(){
        return $this->hasMany(Rider::class,'user_id','id');
    }
}
