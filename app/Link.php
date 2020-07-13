<?php

namespace App;

use App\Phone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function user_unlock_links() {
        return $this->hasMany('App\UserUnlockLink');
    }

    public function code($mobile) {
        return $this->code_links()->where('phone_number', $mobile)->first()->code;
    }

    public function createCode($mobile, $link_id) {
        $phone = Phone::firstOrCreate(['number' => $mobile]);
        // create if phone number not exists and insert to code_links table
        DB::table('code_links')->updateOrInsert([
            'phone_number' => $mobile,
            'link_id' => $link_id
        ], ['code' => rand(1000, 999999)]);
        return $this->code($mobile);
    }

    public function unlock() {
        $this->increment('unlock_count');
        $this->user->cash += $this->service->amount;
        $this->user->save();
        
        if ($this->user->ref !== null) { // nếu có người giới thiệu
            $this->user->ref->user->income_from_link($this, $this->service->amount);
        }
    }

    public function unlock_link($code) {
        DB::table('code_links')->where([
            'code' => $code,
            'link_id' => $this->id
        ])->update(['code' => rand(1000, 999999)]);

        $this->unlock();
    }

    public function user_unlock_link() {
        \Auth::user()->cash -= $this->service->amount;
        \Auth::user()->save();

        $this->user_unlock_links()->create(['user_id' => auth()->id()]);
        $this->unlock();
    }
}
