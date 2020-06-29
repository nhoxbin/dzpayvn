<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RefController extends Controller
{
    public function index() {
    	$user = request()->user()->ref_users()->get();
    	return view('ref', compact('user'));
    }
}
