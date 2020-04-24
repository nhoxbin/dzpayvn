<?php

namespace App\Http\Controllers;

use App\Link;
use App\ServiceNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LinkController extends Controller
{
    private function quickRandom($length = 16) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length) . time()), 0, $length);
    }

    public function index() {
        $links = Link::where('user_id', auth()->id())->orderBy('created_at', 'DESC')->get();
        return view('link.index', compact('links'));
    }

    public function create() {
        $service_numbers = ServiceNumber::all();
        return view('link.create', compact('service_numbers'));
    }

    public function store(Request $request) {
        $tested = [];
        do {
            $token = $this->quickRandom();
            if (in_array($token, $tested)) {
                continue;
            }
            array_push($tested, $token);
            $count = DB::table('links')->where('token', $token)->count();
        } while ($count > 0);

        $request->user()->links()->create($request->validate([
            'url' => 'required|url',
            'service_number' => 'required|numeric|exists:service_numbers,number'
        ], [
            '*.required' => 'Vui lòng điền :attribute',
            'url.url' => ':attribute phải là :other'
        ]) + [
            'code' => rand(1000, 9999),
            'token' => $token
        ]);

        return back()->withSuccess('Thêm link thành công.');
    }
}
