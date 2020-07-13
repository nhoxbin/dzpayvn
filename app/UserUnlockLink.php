<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserUnlockLink extends Model
{
    protected $fillable = ['user_id', 'link_id'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function link() {
    	return $this->belongsTo('App\Link');
    }
}
