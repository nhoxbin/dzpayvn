<?php

namespace App\Http\Controllers\Admin;

use App\ShootMoney;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShootMoneyController extends Controller
{
    public function index() {
        $shoot_money = ShootMoney::orderBy('created_at', 'desc')->get();
        return view('admin.shoot_money', compact('shoot_money'));
    }

    public function show(ShootMoney $shootMoney) {
        return response($shootMoney);
    }

    public function update(Request $request, ShootMoney $shootMoney) {
        if ($request->confirm == -1) {
            preg_match('/(\d+)/', $shootMoney->sim->{$shootMoney->method.'_discount'}, $discount);
            $shootMoney->user->cash += ($shootMoney->money - ($shootMoney->money * $discount[0] / 100));
            $shootMoney->user->save();
        }

        $shootMoney->update($request->all());
        return response('Cập nhật hóa đơn thành công.');
    }
}
