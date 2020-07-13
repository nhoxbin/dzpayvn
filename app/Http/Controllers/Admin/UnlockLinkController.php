<?php

namespace App\Http\Controllers\Admin;

use App\UserUnlockLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnlockLinkController extends Controller
{
    public function index() {
        $users = UserUnlockLink::all();
        return view('admin.user_unlock_link', compact('users'));
    }
}
