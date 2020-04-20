<?php

namespace App\Http\Controllers\Admin;

use App\BuyBill;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffReportController extends Controller
{
    public function index() {
        $reports = BuyBill::where('picture_to_confirm', '<>', null)->orWhere('require_cancel', 1)->get();

        return view('admin.staff', compact('reports'));
    }

    public function update(Request $request, BuyBill $bill) {
        if ($bill->confirm === 0) {
            if ($bill->require_cancel === 1) {
                $bill->user->cash += $bill->package->money;
                $bill->user->save();

                $bill->confirm = -1;
            } else {
                $bill->confirm = 1;
            }
            $bill->save();

            return redirect()->back()->withSuccess('Đã xác nhận.');
        } else {
            return redirect()->back()->withError('Lỗi! Đơn này đã được xác nhận.');
        }
    }
}
