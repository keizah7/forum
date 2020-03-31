<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thread;
use App\User;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => User::pluck('id')->random(),
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});
