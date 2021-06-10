<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class available_riders extends Model
{
    protected $table='available_riders';
    protected $fillable = [
        'rider_id','location','status'
    ];
    public function rider() {
        return $this->belongsTo(Rider::class,'rider_id','id');
    }
}
