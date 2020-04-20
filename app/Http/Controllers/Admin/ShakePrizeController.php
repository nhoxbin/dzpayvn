<?php

namespace App\Http\Controllers\Admin;

use App\ShakePrize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShakePrizeController extends Controller
{
    public function edit(Request $request, ShakePrize $prize) {
        return response($prize);
    }

    public function update(Request $request, ShakePrize $prize) {
        $request->validate([
            'bounty' => 'required|numeric'
        ]);
        $prize->bounty = $request->bounty;
        $prize->save();

        return response('Cập nhật thành công.');
    }
}
