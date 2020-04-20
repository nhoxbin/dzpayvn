<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyBill extends Model
{
	public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'user_id', 'package_id', 'account_type', 'info', 'nv_id', 'name_character', 'confirm', 'require_cancel', 'picture_to_confirm'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function package() {
    	return $this->belongsTo('App\Package');
    }
}
