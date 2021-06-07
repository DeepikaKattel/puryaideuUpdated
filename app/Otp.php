<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Otp extends Model
{
    use Notifiable, HasApiTokens;
    protected $table = 'otps';
    protected $fillable = [
        'phone','code','code_status'
    ];


    public function verified()
    {
        return $this->code_status == 'Verified' ? TRUE : FALSE;
    }

}
