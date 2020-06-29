<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RefController extends Controller
{
    public function index() {
    	$user = request()->user()->refs()->get();
    	return view('ref', compact('user'));
    }
}
