<?php

namespace App\Http\Controllers\Admin;

use App\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    public function index() {
    	$links = Link::orderBy('created_at', 'desc')->get();
    	return view('admin.link', compact('links'));
    }
}
