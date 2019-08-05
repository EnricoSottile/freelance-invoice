<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'number' => (String) $faker->randomNumber(),
        'net_amount' => $faker->randomNumber(8) . "." . $faker->randomNumber(2),
        'tax' => $faker->randomFloat(2, $min = 0, $max = 99.99),
        'description' => rand(0,1) ? null : $faker->text(),
        'date' => rand(0,1) ? null : $faker->date(),
        'sent_date' => rand(0,1) ? null : $faker->date(),
        'registered_date' => rand(0,1) ? null : $faker->date(),
    ];
});
