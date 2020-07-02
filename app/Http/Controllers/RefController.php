<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RefController extends Controller
{
    public function index() {
    	$user = request()->user();
    	$refs = $user->user_ref;
        $refs_detail = $user->income;
    	return view('ref', compact('refs_detail', 'refs'));
    }
}
