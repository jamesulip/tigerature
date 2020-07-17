<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\question_answers;
use Faker\Generator as Faker;

$factory->define(question_answers::class, function (Faker $faker) {

    return [
        'user_id' => $faker->word,
        'question_id' => $faker->word,
        'answer' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
