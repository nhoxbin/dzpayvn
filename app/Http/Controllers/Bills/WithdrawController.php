<?php

namespace App\Http\Controllers\Bills;

use Auth;
use App\Bank;
use App\WithdrawBill;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WithdrawController extends Controller
{
    public function create() {
    	return view('bills.withdraw');
    }

    public function store(Request $request) {
        $user = Auth::user();
		$request->validate([
            'withdraw_type' => 'in:bank,momo,zalopay',
			'bank_name' => 'requiredIf:withdraw_type,bank|string',
            'branch' => 'requiredIf:withdraw_type,bank|string',
			'stk' => 'requiredIf:withdraw_type,bank|numeric|min:10',
			'master_name' => 'requiredIf:withdraw_type,bank|string',
            'phone' => 'sometimes|required|digits:10',
            'name' => 'sometimes|required|string',
			'money' => 'required|numeric|min:200000',
            'password' => ['required', 'string', function($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('Mật khẩu xác nhận không đúng với mật khẩu hiện tại!'));
                }
            }]
		], [
            'withdraw_type.in' => 'Sai lệnh rút tiền!',
            '*.required' => 'Ô này không được để trống!',
			'money.between' => 'Chỉ được phép rút trên :min đ. Phí chuyển 11k.',
            'stk.min' => 'STK phải trên 10 số.',
            'money.min' => 'Rút ít nhất :min'
		]);

    	if ($request->withdraw_type === 'bank') {
            $user->cash -= ($request->money + 11000);

            $info = json_encode([
                'bank_name' => $request->bank_name,
                'branch' => $request->branch,
                'stk' => $request->stk,
                'master_name' => $request->master_name
            ]);
    	} else {
            $user->cash -= $request->money;

            $info = json_encode(['phone' => $request->phone_number, 'name' => $request->name]);
    	}

        if ($user->cash < 0) {
            return back()->withErrors(['money' => 'Số dư không đủ để rút!']);
        }
        $user->save();

        $request->user()->withdraw_bills()->create([
            'id' => (string) Str::uuid(),
            'info' => $info,
            'money' => $request->money,
            'type' => $request->withdraw_type
        ]);

    	return redirect()->back()->withSuccess('Tạo lệnh rút tiền thành công! Chờ Admin chuyển tiền.');
    }
}
