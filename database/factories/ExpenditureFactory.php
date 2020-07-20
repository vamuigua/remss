<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Expenditure;
use Faker\Generator as Faker;

$factory->define(Expenditure::class, function (Faker $faker) {
    return [
        'outgoings' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'amount' => $faker->numberBetween($min = 1000, $max = 9000),
        'particulars' => $faker->text($maxNbChars = 100),
        'expenditure_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});
