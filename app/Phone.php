<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
	public $incrementing = false;
    public $timestamps = false;
	protected $keyType = 'string';
    protected $primaryKey = 'number';
    protected $fillable = ['number'];

    public function code_links() {
    	return $this->hasMany('App\CodeLink');
    }
}
