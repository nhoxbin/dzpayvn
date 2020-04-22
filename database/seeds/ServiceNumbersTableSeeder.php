<?php

use Illuminate\Database\Seeder;

class ServiceNumbersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_numbers')->insert([
        	['number' => '8785', 'amount' => 4000],
        	['number' => '8685', 'amount' => 2500],
        	['number' => '8585', 'amount' => 1160],
        	['number' => '8485', 'amount' => 900],
        	['number' => '8385', 'amount' => 720],
        	['number' => '8285', 'amount' => 480],
        	['number' => '8185', 'amount' => 243],
        	['number' => '8085', 'amount' => 120]
        ]);
    }
}
