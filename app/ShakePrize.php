<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShakePrize extends Model
{
	protected $fillable = ['id', 'bounty'];
	public $incrementing = false;
    public $timestamps = false;
}
