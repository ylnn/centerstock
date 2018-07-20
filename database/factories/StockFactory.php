<?php

use App\User;
use App\Stock;
use App\Product;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Stock::class, function (Faker $faker) {
    $purchase_price = $faker->numberBetween(300, 2000);
    $diff_price = $faker->numberBetween(100, 1000);
    $quantityArray = array(5,0,55,110,260,340,580,727,1450);
    $qKey = array_rand($quantityArray);
    if (!Product::first()) {
        factory(Product::class)->create();
    }
    if (!User::first()) {
        factory(User::class)->create();
    }
    return [
        'serial' => rand(100, 500000),
        'quantity' => 2000,
        'purchase_price' => $purchase_price,
        'sale_price' => $diff_price,
        'quantity' => $quantityArray[$qKey],
        'user_id' => User::latest()->first()->id,
        'product_id' => Product::latest()->first()->id,
        'sale_price' => $purchase_price + $diff_price,
        'expiration_at' => Carbon::now()->addDays(rand(50,365))->toDateTimeString()
    ];
});
