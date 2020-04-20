<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Momo extends Model
{
    protected $fillable = ['recharge_bill_id', 'phone', 'code'];
}
