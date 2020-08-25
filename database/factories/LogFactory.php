<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Log;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Log::class, function (Faker $faker) {
    return [
        'title' => 'My Log',
        'daily_count' => 1,
        'max_temp' => 99,
        'notify_max_temp' => true,
        'notify_daily_count' => true,
        'daily_count_at' => '17:00',
        'join_code' => Str::random(8),
    ];
});
