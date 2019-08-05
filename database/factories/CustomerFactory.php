<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name(),
        'email' => $faker->safeEmail,
        'phone' => $faker->phoneNumber,
        'vat_code' => $faker->randomNumber,
    ];
});
