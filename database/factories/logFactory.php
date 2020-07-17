<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\log;
use Faker\Generator as Faker;

$factory->define(log::class, function (Faker $faker) {

    return [
        'temp' => $faker->randomDigitNotNull,
        'user_id' => $faker->word,
        'device_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
