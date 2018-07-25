<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerDetailTest extends TestCase
{
    
    /**
     * customer detail endpoint WORKING test
     *
     * @return void
     */
    public function testCustomerDetailEndpoint()
    {
        $customer = factory('App\Customer')->create();
        $response = $this->get(route('api.customer.detail', ['customerId' => $customer->id]));
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $customer->name]);
    }

    /**
     * customer detail endpoint FAIL test
     *
     * @return void
     * 
     */
    public function testFailCustomerDetailEndpoint()
    {
        $this->expectException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $customer = factory('App\Customer')->create();
        $response = $this->get(route('api.customer.detail', ['customerId' => 1000]));
    }

}
