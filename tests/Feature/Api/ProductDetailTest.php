<?php
namespace Tests\Feature\Api;
use Tests\TestCase;

class ProductDetailTest extends TestCase 
{
    /**
     * product detail endpoint WORKING test
     *
     * @return void
     */
    public function testProductDetailEndpoint()
    {
        $product = factory('App\Product')->create();
        $stock = factory('App\Stock')->create();

        // update stock's product id
        $stock->product_id = $product->id;
        $stock->save();

        $response = $this->get(route('api.product.detail', ['productId' => $product->id]));
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'serial' => $stock->serial
        ]);
    }    

    /**
     * product detail endpoint FAIL (Empty) test
     *
     * @return void
     */
    public function testFailProductDetailEndpoint()
    {
        $product = factory('App\Product')->create();
        $stock = factory('App\Stock')->create();

        // update stock's product id
        $stock->product_id = $product->id;
        $stock->save();

        // other product
        $otherProduct = factory('App\Product')->create();
        $otherStock = factory('App\Stock')->create();

        // update other stock's product id
        $otherStock->product_id = $otherProduct->id;
        $otherStock->save();


        $response = $this->get(route('api.product.detail', ['productId' => $product->id]));

        $response->assertJsonMissing([
            'serial' => $otherStock->serial
        ]);
    }
}
