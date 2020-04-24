<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
	public $incrementing = false;
    public $timestamps = false;
	protected $keyType = 'string';
    protected $fillable = ['number'];
}
