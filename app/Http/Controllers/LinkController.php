<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    private function quickRandom($length = 16) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length) . time()), 0, $length);
    }

    public function index() {
        $links = Link::where('user_id', auth()->id())->get();
        return view('link.index', compact('links'));
    }

    public function create() {
        return view('link.create');
    }

    public function store(Request $request) {
        do {
            $token = $this->quickRandom();
            $count = DB::table('links')->where('token', $token)->count();
        } while ($count > 0);

        $request->user()->links()->create($request->validate([
            'url' => 'required|url',
            'service_number' => 'required|exists:service_numbers,number',
            'code' => rand(1000, 9999)
        ]) + [
            'token' => $token
        ]);

        return back()->withSuccess('Thêm link thành công.');
    }

    public function show(Link $link)
    {
        //
    }

    public function edit(Link $link)
    {
        //
    }

    public function update(Request $request, Link $link) {
        //
    }

    public function destroy(Link $link) {
        $link->delete();
        return back();
    }
}
