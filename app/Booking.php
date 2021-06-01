<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table='booking';

    protected $fillable = [
        'origin','destination','distance','duration','passenger_number','name','phone_number','vehicle_type','user_id','status','rider_id','ride_status','vehicle_id'
    ];
    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function vehicleType(){
        return $this->belongsTo(VehicleType::class,'vehicle_type','id');
    }
    public function vehicle() {
        return $this->belongsTo(Vehicle::class,'vehicle_id','id');
    }
}
