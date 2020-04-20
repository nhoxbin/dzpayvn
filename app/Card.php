<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['recharge_bill_id', 'sim_id', 'serial', 'code'];

    public function sim() {
    	return $this->belongsTo('App\Sim');
    }

    public function recharge_bill() {
    	return $this->belongsTo('App\RechargeBill');
    }
}
