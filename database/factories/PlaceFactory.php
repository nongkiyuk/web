<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Place::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text(),
        'address' => $faker->address,
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude,
    ];
});
