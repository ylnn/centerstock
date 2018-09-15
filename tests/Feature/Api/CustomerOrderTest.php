<?php
namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Order;

class CustomerOrderTest extends TestCase
{
    /**
     * is user can create new open order
     *
     * @return void
     */
    public function testIsUserCanCreateNewOrderWithOpenStatus()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $customer = factory('App\Customer')->create();

        $order = Order::make([
            'user_id' => $user->id
        ]);

        $customer->addOrder($order, $user);

        $response = $this->get(route('api.order.create', ['customerId' => $customer->id]));
        $response->assertStatus(201);
        $response->assertJson([
            'customer_id' => $customer->id,
            'status' => 'OPEN',
            'user_id' => $user->id,
        ]);
    }
}
