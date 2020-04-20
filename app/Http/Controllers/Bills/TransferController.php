<?php

namespace App\Http\Controllers\Bills;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\TransferBill;
use App\User;

class TransferController extends Controller
{
    public function create() {
    	return view('bills.transfer');
    }

    public function store(Request $request) {
    	try {
            if (!$request->ajax()) {
        		return response(null, 400);
        	}
            if ($request->to == auth()->id()) {
                return response(['success' => false, 'msg' => 'Bạn không được chuyển tiền cho chính bạn!'], 200);
            }
            $to = User::find($request->to);
            if ($to === null) {
                return response(['success' => false, 'msg' => 'Không có người dùng nào thuộc ID này!'], 200);
            }

            $money = $request->money;
        	$user = User::find(auth()->id());
        	if ($money > $user->cash) {
        		return response(['success' => false, 'msg' => 'Bạn không được chuyển lớn hơn số tiền bạn đang có!'], 200);
        	}
            if (!is_numeric($money) || $money < 1000) {
                return response(['success' => false, 'msg' => 'Số tiền phải là số và chuyển lớn hơn 1000'], 200);
            }
        	
        	$user->cash -= $money;
        	$user->save();
        	$to->cash += $money;
        	$to->save();

        	TransferBill::create([
        		'id' => (string) Str::uuid(),
        		'user_id' => auth()->id(),
        		'to_user_id' => $to->id,
        		'money' => $money
        	]);
        	return response(['success' => true, 'msg' => 'Chuyển tiền thành công!'], 200);
        } catch (\Exception $e) {
            return response(['success' => false, 'msg' => 'Lỗi hệ thống. Vui lòng contact admin'], 200);
        }
    }
}
