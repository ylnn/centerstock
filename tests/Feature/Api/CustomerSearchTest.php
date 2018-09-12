<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerSearchTest extends TestCase
{
    
    /**
     * customer search endpoint WORKING test
     *
     * @return void
     */
    public function testCustomerSearchEndpoint()
    {
        $customer = factory('App\Customer')->create();
        $customerName = str_limit($customer->name, 3, '');
        $response = $this->get(route('api.customer.search', ['customerName' => $customerName]));
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $customer->name]);
    }


    /**
     * customer search endpoint FAIL (not found) test
     *
     * @return void
     */
    public function testFailForMinimum3CharValidationCustomerSearchEndpoint()
    {
        $customer = factory('App\Customer')->create();
        $customerName = "xx";
        $response = $this->get(route('api.customer.search', ['customerName' => $customerName]));
        $response->assertStatus(404);
    }
}
