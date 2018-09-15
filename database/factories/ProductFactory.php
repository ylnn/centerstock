<?php

use Faker\Generator as Faker;
use App\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence($nbWords = 2, $variableNbWords = false) . " " . $faker->randomElement($array = array('50CC', '75CC', '100CC', '25GR', '50GR', '100GR')),
        'base_price' => random_int(300, 9000),
    ];
});
