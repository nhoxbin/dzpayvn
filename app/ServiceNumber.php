<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceNumber extends Model
{
	public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'number';
    protected $keyType = 'string';

    public function links() {
    	return $this->hasMany('App\Link', 'service_number', 'number');
    }
}
