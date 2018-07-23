<?php

use Faker\Generator as Faker;
use App\Area;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    $area = Area::inRandomOrder()->first();
    if(!$area){
        $area = factory(Area::class)->create();
    }
    return [
        'name' => $faker->name(),
        'status' => 1,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'area_id' => $area->id,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'remember_token' => str_random(10),
    ];
});
