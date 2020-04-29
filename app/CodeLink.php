<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeLink extends Model
{
	public $incrementing = false;
    protected $primaryKey = null;
    protected $fillable = ['phone_number', 'link_id'];
    protected $hidden = ['code'];

    public function phones() {
    	return $this->hasMany('App\Phone');
    }

    public function links() {
    	return $this->hasMany('App\Link');
    }
}
