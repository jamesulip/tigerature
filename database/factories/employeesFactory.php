<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\employees;
use Faker\Generator as Faker;

$factory->define(employees::class, function (Faker $faker) {

    return [
        'employee_id' => $faker->randomDigitNotNull,
        'first_name' => $faker->word,
        'last_name' => $faker->word,
        'address' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
