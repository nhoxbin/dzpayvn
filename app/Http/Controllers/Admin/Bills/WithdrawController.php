<?php

namespace App\Http\Controllers\Admin\Bills;

use App\WithdrawBill;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index() {
        return view('admin.bills.withdraw');
    }

    public function update(Request $request, WithdrawBill $withdraw) {
        $msg = '';
        if ($request->action === 'confirm') {
            $withdraw->confirm = 1;
            $withdraw->save();

            $msg = 'Hóa đơn đã được xác nhận!';
        } elseif ($request->action === 'reject') {
            $withdraw->confirm = -1;
            $withdraw->reason = $request->reason ?? null;
            $withdraw->save();

            // hoàn tiền
            $fee = 0;
            if ($withdraw->type === 'bank') {
                $fee = 11000;
            }
            $withdraw->user->cash += ($withdraw->money + $fee);
            $withdraw->user->save();

            $msg = 'Đã hủy đơn.';
        }
        return response($msg);
    }

    public function destroy(WithdrawBill $withdraw) {
        $withdraw->delete();
        return response('Đã xóa đơn.');
    }
}
