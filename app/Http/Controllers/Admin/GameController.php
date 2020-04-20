<?php

namespace App\Http\Controllers\Admin;

use App\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function all() {
        $game = Game::all();
        return response($game);
    }

    public function maintenance(Game $game) {
        if ($game->maintenance == 1) {
            $game->maintenance = 0;
        } else {
            $game->maintenance = 1;
        }
        $game->save();
        return redirect()->back()->withSuccess('Cập nhật trạng thái thành công!');
    }

    public function index() {
        return view('admin.game.index');
    }

    public function store(Request $request) {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        if (!$request->hasFile('picture') && !$request->picture->isValid()) {
            return response('file ko đúng định dạng!', 500);
        }
        $url = time() . '.' . $request->picture->getClientOriginalExtension();
        $request->picture->move('uploads', $url);
        $game = Game::create([
            'name' => $request->name,
            'picture' => 'uploads/' . $url,
            'type' => $request->type,
            'currency' => $request->currency,
            'sort_currency' => $request->sort_currency
        ]);
        return response('ok', 201);
    }

    public function edit(Request $request, Game $game) {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        return response($game, 200);
    }

    public function update(Request $request, Game $game) {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        if ($game === null) {
            return response(null, 204);
        }
        if ($request->picture !== 'null' && $request->hasFile('picture') && $request->picture->isValid()) {
            $url = time() . '.' . $request->picture->getClientOriginalExtension();
            $request->picture->move('uploads', $url);
            $game->picture = 'uploads/' . $url;
        }
        $game->name = $request->name;
        $game->type = $request->type;
        $game->currency = $request->currency;
        $game->sort_currency = $request->sort_currency;
        $game->save();
        return response('ok', 200);
    }

    public function destroy(Request $request, Game $game) {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        $game->delete();
        return response('ok', 200);
    }
}
