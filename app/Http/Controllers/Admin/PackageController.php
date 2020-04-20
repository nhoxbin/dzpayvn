<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Game;
use App\Package;

class PackageController extends Controller
{
    public function index($game_id) {
        $game = Game::select('id', 'name', 'currency')->where('id', $game_id)->first();
        if ($game === null) {
            return redirect()->route('admin.game.index');
        }
        $game = $game->toArray();
        return view('admin.game.package', compact('game'));
    }

    public function edit(Request $request, $game_id, $package) {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        $package = Package::find($package);
        if ($package === null) {
            return response(null, 204);
        }
        return response($package, 200);
    }

    public function update(Request $request, $game_id, Package $package) {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        $package->money = $request->money;
        $package->money_in_game = $request->money_in_game;
        $package->save();
        
        return response('Cập nhật gói thành công.', 200);
    }

    public function store(Request $request) {
        $request->validate([
            'money' => 'required|numeric',
            'money_in_game' => 'required|numeric'
        ]);
        Package::create([
            'game_id' => $request->game_id,
            'money' => $request->money,
            'money_in_game' => $request->money_in_game
        ]);
        return response('Thêm thành công!', 201);
    }

    public function destroy(Request $request, $game_id, $id) {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        try {
            Package::find($id)->delete();
            return response('ok', 200);
        } catch(\Exception $e) {
            return response($e->getMessage(), 200);
        }
    }
}
