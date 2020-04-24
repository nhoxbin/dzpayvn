<?php

namespace App;

use App\Phone;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
	protected $fillable = ['url', 'service_number', 'code', 'token'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function number() {
    	return $this->belongsTo('App\ServiceNumber', 'service_number', 'number');
    }

    public function unlock_link($mobile) {
    	$phone = Phone::where('number', $mobile)->first();
    	if (!$phone) {
        	Phone::create(['number' => $mobile]);
    	}
    	$this->user->cash += $this->number->amount;
    	$this->user->save();
        $this->increment('unlock_count');
    }
}
