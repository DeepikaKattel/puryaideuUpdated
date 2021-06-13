<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $table='reviews';

    protected $fillable = [
        'ride_id','rider_id','user_id','rate','rate_date','comment'
    ];

}
