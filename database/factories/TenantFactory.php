<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tenant;
use Faker\Generator as Faker;

$factory->define(Tenant::class, function (Faker $faker) {
    return [
        'surname' => $faker->firstName(),
        'other_names' => $faker->lastName(),
        'gender' => 'male',
        'national_id' => $faker->randomNumber(),
        'phone_no' => $faker->e164PhoneNumber(),
        'email' => $faker->email(),
    ];
});
