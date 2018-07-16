<?php

use Faker\Generator as Faker;
use App\Area;


$factory->define(Area::class, function(Faker $faker){
    return [
        'name' => $faker->city
    ];
});