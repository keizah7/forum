<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thread;
use App\User;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => User::count() ? User::pluck('id')->random() : factory(User::class),
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});
