<?php

namespace App\Http\Controllers;

use Auth;
use App\ShootMoney;
use App\Sim;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ShootMoneyController extends Controller
{
    public function create() {
        $sims = Sim::all();
        return view('shoot_money', compact('sims'));
    }

    public function store(Request $request) {
        $v = Validator::make($request->all(), [
            'method' => 'required|in:fast,slow',
            'sim_name' => 'in:viettel,mobiphone,vinaphone',
            'sim_id' => 'required|numeric|exists:sims,id',
            'type' => 'required_if:method,slow|string',
            'password' => 'nullable|string',
            'phone' => ['required', 'regex:/^(0|\+84)[\d+]{9}$/'],
            'money' => ['required', 'numeric', 'min:10000', function($attribute, $value, $fail) {
                if (Input::get('method') === 'fast') {
                    if (Input::get('sim_name') !== 'mobiphone') {
                        if($value % 50000 != 0) {
                            return $fail(__('Số tiền phải chia hết cho 50K'));
                        }
                    }
                }
                if($value % 10000 != 0) {
                    return $fail(__('Số tiền phải chia hết cho 10K'));
                }
            }]
        ], [
            '*.required' => ':attribute không được bỏ trống!',
            '*.numeric' => ':attribute không hợp lệ!',
            'password.string' => ':attribute phải là 1 chuỗi',
            'phone.regex' => 'Sai định dạng số điện thoại!',
            'money.min' => 'Số tiền không được nhỏ hơn :min!',
            'money.mod_if_else' => 'Số tiền phải chẵn và :value thì chia hết cho :mod_value_if còn các nhà mạng khác thì chia hết cho :mod_value_else'
        ]);
        $v->sometimes('password', 'required', function ($input) {
            return $input->method == 'slow' && $input->sim_name === 'mobiphone';
        });
        $v->validate();

        if ($request->method === 'fast') {
            if ($request->money < 10000) {
                return back()->withErrors(['money' => 'Min bắn là 10K']);
            }
        } else {
            if ($request->money < 20000) {
                return back()->withErrors(['money' => 'Min nạp là 20K']);
            }
        }

        $sim = Sim::find($request->sim_id);
        preg_match('/\d+/', $sim->{$request->method.'_discount'}, $discount);
        Auth::user()->cash -= ($request->money - ($request->money * $discount[0] / 100));
        if (Auth::user()->cash < 0) {
            return back()->withErrors(['money' => 'Số tiền hiện tại không đủ để thực hiện yêu cầu!']);
        }
        Auth::user()->save();

        $request->user()->shoot_money()->create($request->all() + ['id' => (string) Str::uuid()]);
        return back()->withSuccess('Tạo đơn hàng thành công. Vui lòng chờ duyệt!');
    }
}
