<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\failed_jobs;
use Faker\Generator as Faker;

$factory->define(failed_jobs::class, function (Faker $faker) {

    return [
        'connection' => $faker->text,
        'queue' => $faker->text,
        'payload' => $faker->text,
        'exception' => $faker->text,
        'failed_at' => $faker->date('Y-m-d H:i:s')
    ];
});
