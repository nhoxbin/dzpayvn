<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refable extends Model
{
    public function ref() {
    	return $this->belongsTo('App\User', 'from_id');
    }
}
