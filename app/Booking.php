<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'origin','destination','passenger_number','name','phone_number','vehicle_type','user_id','status'
    ];
    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function vehicle_type(){
        return $this->belongsTo(VehicleType::class,'vehicle_type','id');
    }
}
