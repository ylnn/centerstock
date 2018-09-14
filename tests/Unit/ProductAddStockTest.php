<?php

namespace Tests\Unit;

use App\Stock;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductAddStockTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIsStockCanBeAddedToProductWithAddStockMethod()
    {
        $product = factory('App\Product')->create();
        $stock = Stock::make([
            'serial' => '000123456',
            'quantity' => 50,
            'purchase_price' => 10,
            'sale_price' => 15,
            'user_id' => 1
        ]);

        $this->assertEmpty($product->stocks()->first());

        $product->addStock($stock);

        $this->assertNotEmpty($product->stocks()->first());
    }
}
