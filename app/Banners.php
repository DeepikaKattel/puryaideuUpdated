<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    protected $table='banner';

    protected $fillable = ([
        'banner','name','expire_date','added_date','status'
    ]);
}
