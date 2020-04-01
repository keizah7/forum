<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Favorite;
use App\Reply;
use App\User;
use Faker\Generator as Faker;

$factory->define(Favorite::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'favorable_id' => $reply = factory(Reply::class)->create(),
        'favorable_type' => get_class($reply),
    ];
});
