<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\BuyBill;
use App\RechargeBill;
use App\TransferBill;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
    }

    public function transaction_history() {
        $user = User::with([
            'shakes.shake_prize',
            'recharge_bills.card.sim',
            'withdraw_bills',
            'buy_bills.package.game',
            'shoot_money.sim',
            'unlocks.link.service',
            'transfer_bills_sender' => function($q) {
                $q->with('from', 'to');
            }, 'transfer_bills_receiver' => function($q) {
                $q->with('from', 'to');
            }
        ])->find(auth()->id())->toArray();
        
        // $this->array_sort_by_column($histories, 'date', SORT_DESC);
    	return view('histories', compact('user'));
    }

    public function checkCard(Request $rq, RechargeBill $recharge_bill) {
        if ($recharge_bill->user->id === Auth::id() || Auth::user()->role === 1) {
            $telcoId = ['Viettel' => 1, 'Vinaphone' => 2, 'Mobiphone' => 3];
            if ($recharge_bill->type === 'card' && array_key_exists($recharge_bill->card->sim->name, $telcoId)) {
                $sunwin = config('sunwin');
                $curl = json_decode(Curl::to('https://api.2ahvqkxsuzrrlvqigar8.com/id')
                    ->withData($sunwin)->post(), true);

                if ($curl['status'] == 0) {
                    $accessToken = $curl['data']['accessToken'];

                    $url = "https://api.2ahvqkxsuzrrlvqigar8.com/paygate?command=fetchCardHistory&limit=1500&skip=0";
                    $curl = json_decode(Curl::to($url)->withHeader('authorization: ' . $accessToken)->get(), true);

                    $serial = $recharge_bill->card->serial;
                    $card = array_filter($curl['data']['items'], function($card) use ($serial) {
                        return $card['serial'] == $serial;
                    });
                    if (!empty($card)) {
                        $card = reset($card);

                        // 1099: thẻ đang được xử lý
                        if ($card['status'] == 1010) {
                            // Giao dịch thất bại
                            $recharge_bill->confirm = -1;
                            $recharge_bill->reason = 'Thẻ không hợp lệ. '.$card['statusMessage'];
                            $recharge_bill->save();

                            return redirect()->back()->withError($card['statusMessage']);
                        } elseif ($card['status'] == 0) {
                            // Giao dịch thành công
                            if ($recharge_bill->confirm === 0) {
                                $discount = (int) preg_replace('/%/', '', $recharge_bill->card->sim->discount);

                                $cards = [
                                    10000 => [5000, 9000],
                                    20000 => [10000, 17200],
                                    30000 => [17201, 27000],
                                    50000 => [27001, 49999],
                                    100000 => [50000, 90000],
                                    200000 => [100000, 172000],
                                    300000 => [172001, 270000],
                                    500000 => [270001, 499990]
                                ];
                                foreach ($cards as $amount => $range) {
                                    if ($card['netValue'] >= $range[0] && $card['netValue'] <= $range[1]) {
                                        $money = $amount;
                                        $cash = Auth::user()->cash + ($amount - ($amount * $discount / 100));
                                        break;
                                    }
                                }
                                
                                Auth::user()->cash = $cash;
                                Auth::user()->save();

                                $recharge_bill->money = $money;
                                $recharge_bill->confirm = 1;
                                $recharge_bill->save();

                                if ($recharge_bill->user->ref !== null) { // nếu có người giới thiệu
                                    $recharge_bill->user->ref->user->income_from_card($recharge_bill, $recharge_bill->money);
                                }

                                return redirect()->back()->withSuccess($card['statusMessage']);
                            }
                            return redirect()->back()->withError('Thẻ này đã được kiểm tra thành công.');
                        }
                        return redirect()->back()->withError("Error code: $card[status]. $card[statusMessage]");
                    }
                    $recharge_bill->delete();
                    return redirect()->back()->withError('Thẻ không nằm trên hệ thống.');
                }
                return redirect()->back()->withError('Lỗi nạp thẻ, vui lòng liên hệ Admin.');
            }
            return redirect()->back()->withError('Lỗi khi kiểm tra thẻ cào!');
        }
        return redirect()->back()->withError('Lỗi không thể kiểm tra hóa đơn!');
    }
}
