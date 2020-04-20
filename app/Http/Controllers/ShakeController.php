<?php

namespace App\Http\Controllers;

use Auth;
use App\Crate;
use App\Shake;
use App\ShakePrize;
use Illuminate\Http\Request;

class ShakeController extends Controller
{
    public function index() {
        //
    }

    public function create() {
        $shake_prize = ShakePrize::first();
        $crate = Crate::first();
        if (!empty($shake_prize)) {
            return view('shake', compact('crate', 'shake_prize'));
        }
        return redirect()->back()->withError('Chức năng đang được phát triển! Vui lòng quay lại sau');
    }

    public function store(Request $request) {
        $fee = 10000;
        if (Auth::user()->cash - $fee >= 0) {
            $create = [
                'user_id' => auth()->id(),
                'shake_prize_id' => 1
            ];
            $shake = Shake::latest('id')->first();
            if ($shake !== null) {
                $id = substr($shake->id+1, -1);
                if ($id == '0') {
                    $create['shake_prize_id'] = 10;
                } else {
                    $prizes = ShakePrize::all();
                    foreach ($prizes as $prize) {
                        if ($id == $prize->id) {
                            $create['shake_prize_id'] = $prize->id;
                            break;
                        }
                    }
                }
            }
            $shake = Shake::create($create);
            $bounty = $shake->shake_prize->bounty;

            Auth::user()->cash += $bounty;
            Auth::user()->cash -= $fee;
            Auth::user()->save();

            $crate = Crate::first();
            $crate->amount += $bounty;
            $crate->save();

            $msg = 'Chúc mừng bạn đã mở được bao Lì Xì<br />' . number_format($bounty) . 'đ<br />Số tiền đã được cộng vào tài khoản.';
            return response(['bounty' => $bounty, 'msg' => $msg]);
        } else {
            return response('Bạn vui lòng nạp thêm tiền để chơi!', 422);
        }
    }
}
