<?php

use App\Area;
use App\Salesman;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;


$factory->define(Salesman::class, function(Faker $faker){

    $area = factory(Area::class)->create();

    return [
        'name' => $faker->name,
        'status' => $faker->boolean,
        'area_id' => $area->id,
        'email' => $faker->email,
        'password' => Hash::make('password'),
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
    ];
});