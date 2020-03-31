<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Reply;
use App\Thread;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'user_id' => User::count() ? User::pluck('id')->random() : factory(User::class),
        'thread_id' => factory(Thread::class),
        'body' => $faker->paragraph,
    ];
});
