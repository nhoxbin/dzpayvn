<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;

$factory->define(App\Link::class, function (Faker $faker) {
    return [
    	'url' => $faker->unique()->url,
    	'token' => str_random(16),
    	'service_number' => App\ServiceNumber::pluck('number')->random(),
        'code' => $faker->randomNumber(5)
    ];
});
