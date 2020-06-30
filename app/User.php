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
        return $this->morphedByMany('App\RechargeBill', 'refable')->withTimestamps();
    }

    public function income_from_links() {
        return $this->morphedByMany('App\Link', 'refable')->withTimestamps();
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

    public function getUserRefsAttribute() {
        $users = \DB::table('refables as r')
            ->selectRaw('u1.name as name, SUM(income) AS total_income, u2.name as ref')
            ->join('users as u1', 'u1.id', '=', 'r.user_id')
            ->join('users as u2', 'u2.id', '=', 'r.from_id')
            ->groupBy('user_id', 'from_id')
            ->get();
        return $users;
    }
}
