<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table='plans';

    protected $fillable = [
        'title','plan_type','value'
    ];

    public function planType() {
        return $this->belongsTo(PlanType::class,'plan_type','id');
    }
}
