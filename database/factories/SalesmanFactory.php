<?php

use App\Area;
use App\Salesman;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;


$factory->define(Salesman::class, function(Faker $faker){

    if (!Area::first()) {
        $area = factory(Area::class)->create();
    } else {
        $area = Area::inRandomOrder()->first();
    }

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