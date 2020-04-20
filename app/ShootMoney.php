<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShootMoney extends Model
{
    protected $fillable = ['id', 'sim_id', 'method', 'type', 'money', 'phone', 'password', 'confirm', 'reason'];
    public $keyType = 'string';

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function sim() {
    	return $this->belongsTo(Sim::class);
    }
}
