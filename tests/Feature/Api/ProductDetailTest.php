<?php
namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Stock;

class ProductDetailTest extends TestCase
{
    /**
     * product detail endpoint WORKING test
     *
     * @return void
     */
    public function testProductDetailEndpoint()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');
        
        $product = factory('App\Product')->create();

        $stock = Stock::make([
            'serial' => '123456',
            'quantity' => 150,
            'purchase_price' => 10,
            'sale_price' => 15,
            'user_id' => $user->id
        ]);

        // add stock to product
        $product->addStock($stock);

        $response = $this->get(route('api.product.detail', ['productId' => $product->id]));
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'serial' => "$stock->serial"
        ]);
    }

    /**
     * product detail endpoint FAIL (Empty) test
     *
     * @return void
     */
    public function testFailProductDetailEndpoint()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');
        
        $product = factory('App\Product')->create();
        $stock = factory('App\Stock')->create();

        // add stock to product
        $product->addStock($stock);

        // other product
        $otherProduct = factory('App\Product')->create();
        $otherStock = factory('App\Stock')->create();

        // add otherStock to otherProduct
        $otherProduct->addStock($otherStock);


        $response = $this->get(route('api.product.detail', ['productId' => $product->id]));

        $response->assertJsonMissing([
            'serial' => $otherStock->serial
        ]);
    }
}
