<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['id', 'money', 'money_in_game', 'game_id', 'discount'];

    public function buy_bills() {
    	return $this->hasMany('App\BuyBill');
    }

    public function game() {
        return $this->belongsTo('App\Game');
    }
}
