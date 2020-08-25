<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Temperature;
use Faker\Generator as Faker;

$factory->define(Temperature::class, function (Faker $faker) {
    return [
        'temperature' => '98.6',
        'scale' => 'F'
    ];
});
