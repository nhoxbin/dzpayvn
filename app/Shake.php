<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shake extends Model
{
    protected $fillable = ['user_id', 'shake_prize_id'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function shake_prize() {
    	return $this->belongsTo('App\ShakePrize');
    }
}
