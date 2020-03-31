<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Reply;
use App\Thread;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'user_id' => User::pluck('id')->random(),
        'thread_id' => factory(Thread::class),
        'body' => $faker->paragraph,
    ];
});
