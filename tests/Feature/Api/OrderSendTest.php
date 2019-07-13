<?php

namespace Tests\Feature\Api;

use App\Order;
use App\OrderItem;
use Tests\TestCase;

class OrderSendTest extends TestCase
{
    public function test_user_can_send_own_orders_for_approval()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $customer = factory('App\Customer')->create();

        $order = Order::make(['user_id' => $user->id]);
        $order->status = Order::STATUS['OPEN'];
        $customer->orders()->save($order);

        $stock = factory('App\Stock')->create([
            'user_id' => $user->id,
            'quantity' => 150
        ]);

        $stock2 = factory('App\Stock')->create([
            'user_id' => $user->id,
            'quantity' => 200
        ]);

        $orderItem = OrderItem::make([
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'stock_id' => $stock->id,
            'quantity' => 50
        ]);

        $orderItem2 = OrderItem::make([
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'stock_id' => $stock2->id,
            'quantity' => 70
        ]);

        $order->items()->saveMany([$orderItem, $orderItem2]);

        $response = $this->json('POST', route('api.order.update', [
            'order_id' => $order->id
        ]));

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'order sent.'
        ]);

        $updatedOrder = Order::findOrFail($order->id);
        $this->assertEquals(Order::STATUS['WAITING'], $updatedOrder->getStatus());
    }
}
