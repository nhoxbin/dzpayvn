<?php

namespace App\Http\Controllers\Bills;

use Auth;
use App\Card;
use App\User;
use App\NganLuong;
use App\Momo;
use App\RechargeBill;
use App\Sim;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NLAPI;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Str;

class RechargeController extends Controller {
    public function withSms(Request $rq) {
        $code = $rq->code; // Ma chinh (ON)
        $subCode = $rq->subCode; // Ma phu (DZ)
        $mobile = $rq->mobile; // So dien thoai +84
        $serviceNumber = $rq->serviceNumber; // Dau so 8x85 (8785: 4000, 8685: 2500, 8585: 1200)
        $info = $rq->info; // Noi dung tin nhan
        $arr = explode(' ', $info);

        if (count($arr) == 3 && $arr[0] == $code && $arr[1] == $subCode && is_numeric($arr[2])) {
            $user = User::find($arr[2]);
            if ($user === null) {
                $responseInfo = "User: ".$arr[2]." khong ton tai tren he thong.\n Vui long kiem tra lai.";
            } else {
                if ($serviceNumber == 8785) {
                    $money = 4000;
                } elseif ($serviceNumber == 8685) {
                    $money = 2500;
                } elseif ($serviceNumber == 8585) {
                    $money = 1200;
                } else {
                    return '0|'."Gui sai so dich vu\nVui long gui dung so";
                }
                $user->cash += $money;
                $user->save();
                RechargeBill::create([
                    'id' => (string) Str::uuid(),
                    'user_id' => $user->id,
                    'money' => $money,
                    'type' => 'sms',
                    'confirm' => 1
                ]);
                $responseInfo = "Chuc mung ban da nap tien thanh cong! Chuc ban 1 ngay thuc su vui ve\nSo tien hien tai: ".$user->cash;
            }
        } else {
            $responseInfo = "Sai cu phap\nVui long nhap dung cu phap";
        }
        
        return '0|'.$responseInfo;
    }

	public function create() {
		$sims = Sim::all()->toArray();
		return view('bills.recharge', compact('sims'));
	}

	public function store(Request $request) {
		$request->validate([
            'type' => 'in:card,momo',
			'sim_id' => 'requiredIf:type,card|numeric|exists:sims,id',
			'serial' => 'requiredIf:type,card|string|unique:cards',
			'code' => 'requiredIf:type,card|string|unique:cards',
            'phone' => 'requiredIf:type,momo|numeric',
            'code_momo' => 'requiredIf:type,momo|string|unique:momos,code',
			'money' => ['required', 'regex:/^\d+(K|0.+)$/'],
		], [
            '*.required' => ':attribute không thể bỏ trống!',
            '*.required_if' => ':attribute không thể bỏ trống!',
            '*.unique' => 'Thẻ đã được sử dụng',
            'money.regex' => 'Số tiền không hợp lệ!'
        ]);
		try {
			if ($request->type === 'card') {
				$sim = Sim::find($request->sim_id);
                if ($sim->maintenance) {
                    return redirect()->back()->withError('Đã nói là đang bảo trì mà!!!');
                }
				$amount = (int) preg_replace('/K/', '000', $request->money);
                
                $telcoId = ['Viettel' => 1, 'Vinaphone' => 2, 'Mobiphone' => 3];
                if (array_key_exists($sim->name, $telcoId)) {
                    $sunwin = config('sunwin');
                    $curl = json_decode(Curl::to('https://api.2ahvqkxsuzrrlvqigar8.com/id')
                        ->withData($sunwin)->post(), true);

                    if ($curl['status'] == 0) {
                        $accessToken = $curl['data']['accessToken'];

                        $url = "https://api.2ahvqkxsuzrrlvqigar8.com/paygate?command=chargeCard&serial={$request->serial}&code={$request->code}&telcoId={$telcoId[$sim->name]}&amount={$amount}";
                        $curl = json_decode(Curl::to($url)->withHeader('authorization: ' . $accessToken)->get(), true);

                        if ($curl['status'] == 1099) {
                            // thẻ đang được xử lý
                            $msg = $curl['data']['message'] . '. Sau 5p, vui lòng vào lịch sử giao dịch để kiểm tra thẻ cào!';
                        } else {
                            // 1099: thẻ sử dụng sucess, 1: serial, code sai
                            return redirect()->back()->withError($curl['data']['message']);
                        }
                    } else {
                        // ko đăng nhập được
                        return redirect()->back()->withError($curl['data']['message']);
                    }
                }
			}

            $uuid = (string) Str::uuid();
            $request->user()->recharge_bills()->create([
                'id' => $uuid,
                'money' => $amount ?? $request->money,
                'type' => $request->type
            ]);
            if ($request->type === 'card') {
                Card::create([
                    'recharge_bill_id' => $uuid,
                    'sim_id' => $sim->id,
                    'serial' => $request->serial,
                    'code' => $request->code
                ]);
            } else {
                Momo::create([
                    'recharge_bill_id' => $uuid,
                    'phone' => $request->phone,
                    'code' => $request->code_momo
                ]);
            }

            return redirect()->back()->withSuccess($msg ?? 'Hóa đơn đã được ghi nhận, số tiền tương ứng sẽ được cộng vào tài khoản khi hóa được xác nhận.');
		} catch (\Exeption $e) {
			return redirect()->back()->withError('Có lỗi xảy ra, vui lòng thử lại hoặc liên hệ Admin');
		}
	}
}
