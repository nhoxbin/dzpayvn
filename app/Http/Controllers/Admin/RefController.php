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
    	return view('admin.ref', compact('users'));
    }
}
