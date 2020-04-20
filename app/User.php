<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'role', 'password'
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

    public function games() {
        return $this->hasMany('App\Game');
    }

    public function recharge_bills() {
        return $this->hasMany('App\RechargeBill')->orderBy('created_at', 'DESC');
    }

    public function shoot_money() {
        return $this->hasMany('App\ShootMoney')->orderBy('created_at', 'desc');
    }

    public function withdraw_bills() {
        return $this->hasMany('App\WithdrawBill')->orderBy('created_at', 'desc');
    }
    
    public function buy_bills() {
        return $this->hasMany('App\BuyBill')->orderBy('created_at', 'desc');
    }

    public function transfer_bills_sender() {
        return $this->hasMany('App\TransferBill')->orderBy('created_at', 'desc');
    }

    public function transfer_bills_receiver() {
        return $this->hasMany('App\TransferBill', 'to_user_id')->orderBy('created_at', 'desc');
    }

    public function shakes() {
        return $this->hasMany('App\Shake')->orderBy('created_at', 'desc');
    }
}
