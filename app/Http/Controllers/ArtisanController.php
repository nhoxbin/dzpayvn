<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtisanController extends Controller
{
	public function __invoke($password, $command) {
		if ($password === 'VAv76iu99q') {
	        $exitCode = \Artisan::call($command, [
	            '--force' => true,
	        ]);
	        echo $exitCode;
	    }
	}
}
