<?php

namespace App\Http\Controllers\Admin\Bills;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RechargeBill;
use App\User;

class RechargeController extends Controller
{
    public function index() {
    	return view('admin.bills.recharge');
    }

    public function update(Request $request, RechargeBill $recharge) {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        if ($request->action === 'confirm') {
            if ($recharge->confirm === 0) {
                $discount = 0;
                if ($recharge->type === 'card') {
                    $discount = (int) preg_replace('/%/', '', $recharge->card->sim->discount);
                }
                $money = $recharge->money - ($recharge->money * $discount / 100);
            	$recharge->user->cash += $money;
            	$recharge->user->save();

                $recharge->confirm = 1;
                $recharge->save();

                return response('Xác nhận hóa đơn thành công!', 200);
            } else {
                return response('Hóa đơn đã được xác nhận.', 200);
            }
        } elseif ($request->action === 'reject') {
            $recharge->confirm = -1;
            $recharge->reason = $request->reason;
            $recharge->save();
        	return response('Hóa đơn này đã bị loại bỏ.', 200);
        }
        return response(null, 204);
    }
}
