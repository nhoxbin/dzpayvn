<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sim extends Model
{
    protected $fillable = ['name', 'discount', 'fast_discount', 'slow_discount', 'maintenance'];
    public $timestamps = false;
    
    public function cards() {
    	return $this->hasMany('App\Card');
    }
}
