<?php

namespace App\Http\Controllers\Admin;

use App\Shake;
use App\ShakePrize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShakeController extends Controller
{
    public function index() {
        $shakes = Shake::all();
        $shake_prizes = ShakePrize::all();
        return view('admin.shake', compact('shakes', 'shake_prizes'));
    }

    public function destroy(Shake $shake) {
        $shake->delete();
        return;
    }
}
