<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name(),
        'email' => rand(0,1) ? null : $faker->safeEmail,
        'phone' => rand(0,1) ? null :  $faker->phoneNumber,
        'vat_code' => rand(0,1) ? null :  (String) $faker->randomNumber,
    ];
});
