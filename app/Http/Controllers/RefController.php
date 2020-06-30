<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RefController extends Controller
{
    public function index() {
    	$users = request()->user();
    	$refs_detail = $users->ref_users()->get();
    	$refs = \DB::table('refables as r')
            ->selectRaw('u2.name as ref, SUM(income) AS total_income, MIN(r.created_at) as created_at')
            ->join('users as u1', 'u1.id', '=', 'r.user_id')
            ->join('users as u2', 'u2.id', '=', 'r.from_id')
            ->where('r.user_id', auth()->id())
            ->groupBy('user_id', 'from_id')
            ->get();
    	return view('ref', compact('refs_detail', 'refs'));
    }
}
