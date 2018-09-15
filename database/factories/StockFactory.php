<?php

use App\User;
use App\Stock;
use App\Product;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Stock::class, function (Faker $faker) {
    if (!Product::first()) {
        $product = factory(Product::class)->create();
    } else {
        $product = Product::inRandomOrder()->first();
    }
    
    $percents = array(0.6, 0.7, 0.8, 0.9);
    $randomPercent = $faker->randomElement($percents);

    // set purchase price
    $purchasePrice = round($product->base_price * $randomPercent, 2);

    //set sale price
    $salePrice = round($purchasePrice * 1.2, 2);

    // set quantity
    $quantityArray = array(55,110,260,340,580,727,1450);

    // quantity array key
    $qKey = array_rand($quantityArray);


    if (!User::first()) {
        factory(User::class)->create();
    }

    return [
        'serial' => rand(100000, 500000),
        'purchase_price' => $purchasePrice,
        'sale_price' => $salePrice,
        'quantity' => $quantityArray[$qKey],
        'user_id' => User::latest()->first()->id,
        'product_id' => $product->id,
        'expiration_at' => Carbon::now()->addDays(rand(50, 365))->toDateTimeString()
    ];
});
