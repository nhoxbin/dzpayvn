<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MigrateController extends Controller
{
    public function migrate($password) {
	    if ($password === 'VAv76iu99q') {
	        $exitCode = \Artisan::call('migrate', [
	            '--force' => true,
	        ]);
	        echo $exitCode;
	    }
	}

	public function seed($password) {
		if ($password === 'VAv76iu99q') {
	        $exitCode = \Artisan::call('db:seed', [
	            '--force' => true,
	        ]);
	        echo $exitCode;
	    }
	}
}
