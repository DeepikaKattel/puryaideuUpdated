<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    protected $fillable = [
        'user_id','license_number','license','experience','trained','status','wallet'
    ];
    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function vehicle(){
        return $this->hasMany(Vehicle::class);
    }
}
