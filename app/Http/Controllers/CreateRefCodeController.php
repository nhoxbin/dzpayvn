<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class CreateRefCodeController extends Controller
{
    public function __invoke() {
    	$users = User::where('ref_code', null)->get();
    	$tested = [];
    	
    	foreach ($users as $user) {
	    	do {
		    	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		        $r = substr(str_shuffle(str_repeat($pool, 16) . time()), 0, 16);
		        if (!in_array($r, $tested)) {
		        	array_push($tested, $r);
		        	break;
		        }
	    	} while(1);
    		$user->ref_code = $r;
    		$user->save();
    	}
    }
}
