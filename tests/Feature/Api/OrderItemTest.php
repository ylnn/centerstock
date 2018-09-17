<?php
namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Order;

class OrderItemTest extends TestCase
{
    public function test_user_can_add_order_items_to_own_order_with_POST()
    {
        // $this->markTestSkipped('must be revisited.');
        
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $customer = factory('App\Customer')->create();

        $order = Order::make(['user_id' => $user->id]);

        $customer->orders()->save($order);

        $stock = factory('App\Stock')->create([
            'user_id' => $user->id,
            'quantity' => 150
        ]);

        $response = $this->post(route('api.orderitem.create', [
            'order_id' => $order->id,
            'stock_id' => $stock->id,
            'customer_id' => $customer->id,
            'quantity' => 30,
        ]));

        $response->assertStatus(201);

        $response->assertJson([
            'order_id' => $order->id,
            'stock_id' => $stock->id,
            'customer_id' => $customer->id,
            'quantity' => 30,
            'user_id' => $user->id,
        ]);
    }
}
