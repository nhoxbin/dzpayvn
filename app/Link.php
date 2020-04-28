<?php

namespace App;

use App\Phone;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
	protected $fillable = ['url', 'service_number', 'token'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function phones() {
        return $this->hasMany('App\Phone');
    }

    public function service() {
    	return $this->belongsTo('App\ServiceNumber', 'service_number', 'number');
    }

    public function code_links() {
        return $this->hasMany('App\CodeLink');
    }

    public function code($mobile) {
        return $this->code_links()->where('phone_number', $mobile)->first()->code;
    }

    public function createCode($mobile, $link_id) {
        $phone = Phone::firstOrCreate(['number' => $mobile]);
        // create if phone number not exists and insert to code_links table
        $phone->code_links()->updateOrCreate([
            'phone_number' => $mobile,
            'link_id' => $link_id
        ]);
        return $this->code($mobile);
    }

    public function unlock_link() {
        $this->increment('unlock_count');
        $this->user->cash += $this->service->amount;
        $this->user->save();
    }
}
