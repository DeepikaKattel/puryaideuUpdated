<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table='vehicles';

    protected $fillable = ([
        'rider_id','vehicle_type','brand','model','vehicle_year','vehicle_colour','license_number','status'
    ]);

    public function rider() {
        return $this->belongsTo(Rider::class,'rider_id','id');
    }

    public function vehicleType() {
        return $this->belongsTo(VehicleType::class,'vehicle_type','id');
    }
}
