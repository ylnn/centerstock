<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Auth\User;

class CustomerDetailTest extends TestCase
{
    /**
     * customer detail endpoint WORKING test
     *
     * @return void
     */
    public function testCustomerDetailEndpoint()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $customer = factory('App\Customer')->make();
        $user->addCustomer($customer);

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
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $this->expectException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $customer = factory('App\Customer')->create();
        $response = $this->get(route('api.customer.detail', ['customerId' => 1000]));
    }
}
