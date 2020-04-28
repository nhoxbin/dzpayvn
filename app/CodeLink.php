<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeLink extends Model
{
	public $incrementing = false;
    protected $fillable = ['phone_number', 'link_id'];
    protected $hidden = ['code'];

    public function setLinkIdAttribute($value) {
    	$this->attributes['link_id'] = $value;
    	$this->attributes['code'] = rand(1000, 999999);
    }

    public function phones() {
    	return $this->hasMany('App\Phone');
    }

    public function links() {
    	return $this->hasMany('App\Link');
    }

    public function random_code() {
    	$this->code = rand(1000, 999999);
    	$this->save();
    }
}
