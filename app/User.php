<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;

use App\Notifications\Reminder;

class User extends Authenticatable implements \Illuminate\Contracts\Auth\CanResetPassword
{
    use Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'active', 'activated_at', 'discount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function activation()
    {
        return $this->hasOne('App\Activation');
    }

    public function invoiceAddress()
    {
        return $this->hasOne('App\Address')->where('type','invoice');
    }


    public function deliveryAddresses()
    {
        return $this->hasMany('App\Address')->where('type','delivery');
    }


    public function cart()
    {
        return $this->hasOne('App\Cart');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Reminder($token));
    }

}
