<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\migrations;
use Faker\Generator as Faker;

$factory->define(migrations::class, function (Faker $faker) {

    return [
        'migration' => $faker->word,
        'batch' => $faker->randomDigitNotNull
    ];
});
