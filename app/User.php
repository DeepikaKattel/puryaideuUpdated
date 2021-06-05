<?php

namespace App;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Twilio\Rest\Client;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','role','email', 'password','gender','dob','phone','contact2','city','area','approved_at','google_id','facebook_id','code','code_status'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasVerifiedPhone()
    {
        return ! is_null($this->phone_verified_at);
    }

    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }


    public function roles() {
        return $this->belongsTo(Roles::class,'role');
    }

    public function isAdmin() {
        return $this->role == 1 ? TRUE : FALSE;
    }

    public function isRider() {
        return $this->role == 2 ? TRUE : FALSE;
    }


    public function isCustomer() {
        return $this->role == 3 ? TRUE : FALSE;
    }

    public function riders(){
        return $this->hasMany(Rider::class,'user_id','id');
    }


//    public function callToVerify()
//    {
//        $code = random_int(100000, 999999);
//
//        $this->forceFill([
//            'verification_code' => $code
//        ])->save();
//
//        $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
//
//        $client->calls->create(
//            $this->phone,
//            "+17082653883", // REPLACE WITH YOUR TWILIO NUMBER
//            ["url" => "http://your-ngrok-url>/build-twiml/{$code}"]
//        );
//    }

    public function store($request)
    {
        $this->fill($request->all());
        $sms = $this->save();
        return response()->json($sms, 200);
    }

    public function updateModel($request)
    {
        $this->update($request->all());
        return $this;
    }
}
