<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use App\Thread;
use App\User;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => User::count() ? User::pluck('id')->random() : factory(User::class),
        'channel_id' => factory(Channel::class),
        'title' => $title = $faker->sentence,
        'slug' => Str::slug($title),
        'body' => $faker->paragraph,
        'visits' => 0,
    ];
});
