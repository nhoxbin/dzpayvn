<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function number() {
    	return $this->belongsTo('App\ServiceNumber', 'service_number', 'number');
    }

    public function unlock_link() {
    	$this->increment('unlock_count');
    }
}
