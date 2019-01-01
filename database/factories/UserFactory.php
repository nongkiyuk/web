<?php

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'picture' => '',
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'is_active' => rand(0,1),
        'username' => $faker->userName,
        'password' => '123456',
        'remember_token' => str_random(10),
    ];
});
