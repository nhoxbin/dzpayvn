<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'cash' => 100000,
            'email' => Str::random(10).'@gmail.com',
            'phone' => '0365664356',
            'password' => bcrypt('password'),
        ]);
    }
}
