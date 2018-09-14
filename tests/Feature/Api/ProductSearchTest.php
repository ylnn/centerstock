<?php
namespace Tests\Feature\Api;

use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    /**
     * product search endpoint WORKING test
     *
     * @return void
     */
    public function testProductSearchEndpoint()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $product = factory('App\Product')->create();
        $productName = str_limit($product->name, 4, '');
        $response = $this->get(route('api.product.search', ['productName' => $productName]));
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $product->name]);
    }

    /**
     * product search endpoing FAIL
     *
     * @return void
     */
    public function testFailProductSearchEndpoint()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $product = factory('App\Product')->create();
        $productName = str_limit($product->name, 2, '');
        $response = $this->get(route('api.product.search', ['productName' => $productName]));
        $response->assertStatus(404);
    }
}
