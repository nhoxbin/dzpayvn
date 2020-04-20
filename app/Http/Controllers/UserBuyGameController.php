<?php

namespace App\Http\Controllers;

use Auth;
use App\Game;
use App\BuyBill;
use App\RechargeBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserBuyGameController extends Controller
{
    public function index() {
        $manage_game = json_decode(Auth::user()->manage_game) ?? [];
        $games = Game::with(['buy_bills' => function($q) {
            $q->with(['package', 'user']);
        }])->whereIn('id', $manage_game)->get()->toArray();

        return view('staff', compact('games'));
    }

    public function update(Request $request, BuyBill $bill) {
        if ($request->command === 'send') {
            if ($bill->require_cancel === 1) {
                return redirect()->back()->withError('Bạn đã YC hủy đơn này!');
            }

            $images = ['imgBefore' => $request->images[0], 'imgAfter' => $request->images[1]];
            $imgRules = ['images' => 'required|image'];
            foreach ($images as $image) {
                $validation = Validator::make(['images' => $image], $imgRules, ['images.image' => 'Sai định dạng các file hình ảnh']);
                if ($validation->fails()) {
                    $msg = $validation->messages();
                    return redirect()->back()->withErrors($msg);
                }
            }

            foreach ($images as $key => $image) {
                $imgName = time();
                $image->move("uploads/buybill/{$bill->id}", "$key-$imgName");
                $name = "uploads/buybill/{$bill->id}/$key-$imgName";
                $aImg[$key] = $name;
            }
            $bill->picture_to_confirm = json_encode($aImg);
            $bill->nv_id = Auth::id();
        } elseif ($request->command === 'require_cancel') {
            if (!empty($bill->picture_to_confirm)) {
                return redirect()->back()->withError('Bạn đã gửi ảnh xác nhận đơn này!');
            }

            $bill->require_cancel = 1;
            $bill->reason = $request->reason;
        }
        $bill->save();
        return redirect()->back()->withSuccess('Gửi yêu cầu thành công!');
    }
}
