<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref extends Model
{
    protected $fillable = ['user_id', 'ref_at'];

    public function user() {
    	return $this->belongsTo('App\User');
    }
}
