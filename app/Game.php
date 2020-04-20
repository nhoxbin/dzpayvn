<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['name', 'picture', 'currency', 'sort_currency', 'type', 'maintenance'];

    public function packages() {
        return $this->hasMany('App\Package');
    }

    public function buy_bills() {
    	return $this->hasManyThrough('App\BuyBill', 'App\Package');
    }
}
