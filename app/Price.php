<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table='prices';

    protected $fillable = [
        'vehicle_type','rate','distance','total_amount'
    ];

    public function vehicleType() {
        return $this->belongsTo(VehicleType::class,'vehicle_type','id');
    }
}
