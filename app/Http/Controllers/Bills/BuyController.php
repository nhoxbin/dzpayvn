<?php

namespace App\Http\Controllers\Bills;

use App\BuyBill;
use App\Game;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class BuyController extends Controller
{
    public function create($game_id) {
        $game = Game::with(['packages' => function($q) {
            $q->select('id', 'game_id', 'money', 'money_in_game');
        }])->find($game_id);
        if ($game !== null) {
            $game = $game->toArray();
            if ($game['maintenance']) {
                return redirect()->route('dashboard')->withErrors('Game này đang bảo trì!');
            }
            if (!empty($game['packages'])) {
                return view('bills.buy', compact('game'));
            } else {
                return redirect()->route('dashboard')->withErrors('Hiện tại game này chưa có gói để mua!');
            }
        } else {
            return redirect()->route('dashboard')->withErrors('Game này chưa có trong hệ thống!');
        }
    }

    public function store(Request $request, $game_id) {
        $user = User::find(auth()->id());
        // lấy ra gói user chọn
        $pack_user_choose = $request->package;
        $game = Game::with(['packages' => function($q) use ($pack_user_choose) {
            $q->find($pack_user_choose);
        }])->find($game_id);

        if ($game === null) {
            return response('Game này không có trong hệ thống!', 422);
        }
        $game = $game->toArray();
        if ($game['maintenance']) {
            return redirect()->route('dashboard')->withErrors('Game này đang bảo trì!');
        }

        $package = $game['packages'];
        if (empty($package)) {
            return response('Gói này không có trong hệ thống!', 422);
        }
        $package = reset($package);
        if ($package['money'] > $user->cash) {
            return response('Số tiền hiện có không đủ để mua gói này! Vui lòng nạp thêm tiền!', 422);
        }

        if (empty($request->info['name_character'])) {
            return response('Bạn phải điền tên nhân vật!', 422);
        }

        $accType = $request->info['account_type'];
        if ($game['type'] === 1) { // tài khoản
            $media = ['facebook', 'twitter', 'gmail', 'garena', 'vtc'];
            if (in_array($accType, $media)) {
                $username = trim($request->info['username']);
                $password = trim($request->info['password']);
                $server = trim($request->info['server']);
                if ($username !== '' && $password !== '') {
                    $info = "Server: $server | Tài khoản: $username | Mật khẩu: $password | Code: ";
                    $aCode = explode("\n", $request->info['code']);
                    $c = count($aCode)-1;
                    foreach ($aCode as $key => $code) {
                        $info .= trim($code);
                        if ($key != $c) {
                            $info .= ' - ';
                        }
                    }
                }
            }
        } elseif ($game['type'] === 0) { // ID
            $id = trim($request->info['id']);
            if ($id !== '') {
                $accType = 'id';
                $info = $id;
            }
        }
        if (empty($info)) {
            return response('Bạn phải điền đúng và đủ thông tin bên dưới!', 422);
        }

        BuyBill::create([
            'id' => (string) Str::uuid(),
            'user_id' => auth()->id(),
            'package_id' => $pack_user_choose,
            'account_type' => $accType,
            'info' => $info,
            'name_character' => $request->info['name_character']
        ]);
        $user->cash -= $package['money'];
        $user->save();
        return response('Đã gửi đơn hàng lên hệ thống, nếu đơn hàng bị lỗi, số tiền tương ứng sẽ được hoàn trả!', 200);
    }
}
