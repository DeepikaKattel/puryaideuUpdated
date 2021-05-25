<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanType extends Model
{
    protected $table='plan_types';

    protected $fillable = [
        'name','percentage','criteria','remarks'
    ];
//    public function user() {
//        return $this->belongsTo(User::class,'user_id','id');
//    }
//    public function vehicle(){
//        return $this->hasMany(Vehicle::class);
//    }
}
