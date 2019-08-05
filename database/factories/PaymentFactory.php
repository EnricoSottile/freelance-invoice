<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'net_amount' => $faker->randomNumber(8) . "." . $faker->randomNumber(2),
        'due_date' => rand(0,1) ? null : $faker->date(),
        'payed_date' => rand(0,1) ? null : $faker->date(),
    ];
});
