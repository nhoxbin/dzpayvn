<?php

use App\User;
use App\Link;
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
        factory(User::class, 5)->create()->each(function($u) {
        	$u->links()->saveMany(
        		factory(Link::class, rand(5, 10))->make()
        	);
        });
    }
}
