<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $table='vehicle_types';

    protected $fillable = ([
        'name','price_km','price_min','base_fare','commission','capacity','status'
    ]);

    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }
    public function prices(){
        return $this->hasMany(Price::class);
    }

}
