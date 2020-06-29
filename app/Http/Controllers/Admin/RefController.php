<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Ref;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefController extends Controller
{
    public function index() {
    	$users = new User;
    	$income = $users->income;
    	$refs = $users->user_refs;
    	return view('admin.ref', compact('income', 'refs'));
    }
}
