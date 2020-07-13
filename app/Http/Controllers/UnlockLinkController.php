<?php

namespace App\Http\Controllers;

use App\Link;
use App\ServiceNumber;
use Illuminate\Http\Request;

class UnlockLinkController extends Controller
{
	public function show($token) {
		$link = Link::where('token', $token)->firstOrFail();
		return view('link.show', compact('link'));
	}

	public function sms(Request $request) {
		$code = $request->code; // Ma chinh (ON)
        $subCode = $request->subCode; // Ma phu (DZLINK)
        $mobile = $request->mobile; // So dien thoai +84
        $serviceNumber = $request->serviceNumber;
        $info = $request->info; // Noi dung tin nhan
        $arr = explode(' ', $info);

        if (count($arr) == 3 && $arr[0] == $code && $arr[1] == $subCode && is_numeric($arr[2])) {
            $link = Link::find($arr[2]);
            if ($link) {
                if ($serviceNumber == $link->service_number) {
	                $code = $link->createCode($mobile, $arr[2]);
	                $responseInfo = "Chuc mung ban da mo khoa link thanh cong! Chuc ban 1 ngay lam viec vui ve\nCode Link: {$code}";
                } else {
                    $responseInfo = "Gui sai so dich vu\nVui long gui dung so!";
                }
            } else {
                $responseInfo = "Link: ".$arr[2]." khong ton tai tren he thong.\n Vui long kiem tra lai.";
            }
        } else {
            $responseInfo = "Sai cu phap\nVui long nhap dung cu phap";
        }
        
        return '0|'.$responseInfo;
	}

    public function unlock(Request $request, $token) {
    	$link = Link::where('token', $token)->firstOrFail();
        if ($request->user_unlock_link == 1) {
            if (\Auth::user()->cash < (int) $link->service->amount) {
                return back()->withError('Bạn không đủ tiền, vui lòng nạp thêm tiền!');
            }

            $link->user_unlock_link();
            return redirect($link->url);
        }

    	if (is_numeric($request->code)) {
            $code_link = $link->code_links()->where('code', $request->code)->first();
            if ($code_link) {
        		$link->unlock_link($request->code);
        		return redirect($link->url);
            }
    	}
    	return back()->withError('Bạn đã nhập sai code, vui lòng nhập lại!');
    }
}
