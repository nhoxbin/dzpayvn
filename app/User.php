<?php

namespace App;


use Illuminate\Support\Arr;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'role', 'password', 'ref_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function links() {
        return $this->hasMany('App\Link');
    }

    public function games() {
        return $this->hasMany('App\Game');
    }

    public function recharge_bills() {
        return $this->hasMany('App\RechargeBill')->orderBy('created_at', 'DESC');
    }

    public function shoot_money() {
        return $this->hasMany('App\ShootMoney')->orderBy('created_at', 'desc');
    }

    public function withdraw_bills() {
        return $this->hasMany('App\WithdrawBill')->orderBy('created_at', 'desc');
    }
    
    public function buy_bills() {
        return $this->hasMany('App\BuyBill')->orderBy('created_at', 'desc');
    }

    public function transfer_bills_sender() {
        return $this->hasMany('App\TransferBill')->orderBy('created_at', 'desc');
    }

    public function transfer_bills_receiver() {
        return $this->hasMany('App\TransferBill', 'to_user_id')->orderBy('created_at', 'desc');
    }

    public function shakes() {
        return $this->hasMany('App\Shake')->orderBy('created_at', 'desc');
    }

    public function unlocks() {
        return $this->hasMany('App\UserUnlockLink');
    }

    public function ref_users() {
        return $this->hasMany('App\Refable');
    }

    public function ref() {
        return $this->hasOne('App\Ref');
    }

    public function refsAt() {
        return $this->hasMany('App\Ref', 'ref_at');
    }

    public function income_from_cards() {
        return $this->morphedByMany('App\RechargeBill', 'refable')->withPivot('income')->withTimestamps();
    }

    public function income_from_links() {
        return $this->morphedByMany('App\Link', 'refable')->withPivot('income')->withTimestamps();
    }

    public function income_from_card(RechargeBill $card, $income) {
        $income_card = $this->income_from_cards();
        return $this->income_from_ref($income_card, $card, $income);
    }

    public function income_from_link(Link $link, $income) {
        $income_link = $this->income_from_links();
        return $this->income_from_ref($income_link, $link, $income);
    }

    public function income_from_ref($relationship, $model, $income) {
        $income *= 0.01;
        $relationship->attach($model, ['income' => $income, 'from_id' => $model->user->id]);

        $model->user->ref->user->cash += ($income);
        $model->user->ref->user->save();
    }

    public function getIncomeAttribute() {
        $data = collect();
        foreach ($this->income_from_cards as $card) {
            $item['name'] = $card->user->name;
            $item['type'] = 'Card ' . number_format($card->money);
            $item['income'] = $card->pivot->income;
            $item['datetime'] = $card->created_at;
            $data->push($item);
        }
        foreach ($this->income_from_links as $link) {
            $item['name'] = $link->user->name;
            $item['type'] = 'Link. ' . $link->service->number;
            $item['income'] = $link->pivot->income;
            $item['datetime'] = $link->created_at;
            $data->push($item);
        }
        return $data;
    }

    public function getIncomesAttribute() {
        $users = $this->with(['income_from_cards' => function($q) {
            $q->withPivot('income');
        }, 'income_from_links' => function($q) {
            $q->withPivot('income');
        }])->has('income_from_cards')
            ->orHas('income_from_links')
            ->get();
        
        $data = collect();
        foreach ($users as $user) {
            $item['name'] = $user->name;
            foreach ($user->income_from_cards as $card) {
                $item['type'] = 'Card ' . number_format($card->money);
                $item['income'] = $card->pivot->income;
                $item['datetime'] = $card->created_at;
                $data->push($item);
            }
            foreach ($user->income_from_links as $link) {
                $item['type'] = 'Link. ' . $link->service->number;
                $item['income'] = $link->pivot->income;
                $item['datetime'] = $link->created_at;
                $data->push($item);
            }
        }
        return $data;
    }

    public function getUserRefAttribute() {
        $users = \DB::table('refs')
            ->selectRaw('name, SUM(CASE WHEN income IS NOT NULL THEN income END) AS total_income, MIN(refs.created_at) as joined_at')
            ->leftJoin('refables as r', 'r.from_id', '=', 'refs.user_id')
            ->join('users as u', 'u.id', '=', 'refs.user_id')
            ->where('refs.ref_at', auth()->id())
            ->groupBy('refs.user_id')
            ->get();
        return $users;
    }

    public function getUserRefsAttribute() {
        $users = \DB::table('refs')
            ->selectRaw('u1.name, u2.name as ref, SUM(CASE WHEN income IS NOT NULL THEN income END) AS total_income, MIN(refs.created_at) as joined_at')
            ->join('users as u1', 'u1.id', '=', 'refs.ref_at')
            ->join('users as u2', 'u2.id', '=', 'refs.user_id')
            ->leftJoin('refables as r', 'r.from_id', '=', 'refs.user_id')
            ->groupBy('refs.user_id', 'ref_at')
            ->get();
        return $users;
    }
}
