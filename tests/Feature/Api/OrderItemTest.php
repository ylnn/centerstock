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

        $response = $this->json('POST', route('api.orderitem.create', [
            'order_id' => $order->id,
            'stock_id' => $stock->id,
            'customer_id' => $customer->id,
            'quantity' => 30
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


    public function test_check_stock_quantity_before_saving_order_item()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $customer = factory('App\Customer')->create();

        $order = Order::make(['user_id' => $user->id]);

        $customer->orders()->save($order);

        $stock = factory('App\Stock')->create([
            'user_id' => $user->id,
            'quantity' => 50
        ]);

        $response = $this->json('POST', route('api.orderitem.create', [
            'order_id' => $order->id,
            'stock_id' => $stock->id,
            'customer_id' => $customer->id,
            'quantity' => 55
        ]));

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'stock is not enough.'
        ]);
    }

    public function test_user_cant_add_item_to_order_which_status_NOT_equals_to_OPEN()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $customer = factory('App\Customer')->create();

        $order = Order::make(['user_id' => $user->id]);

        $order->status = Order::STATUS['WAITING'];

        $customer->orders()->save($order);

        $stock = factory('App\Stock')->create([
            'user_id' => $user->id,
            'quantity' => 150
        ]);

        $response = $this->json('POST', route('api.orderitem.create', [
            'order_id' => $order->id,
            'stock_id' => $stock->id,
            'customer_id' => $customer->id,
            'quantity' => 30
        ]));

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'order status is not open.'
        ]);
    }


    public function test_user_can_remove_item_from_open_order()
    {
        $this->markTestIncomplete();
    }

    public function test_user_cant_remove_item_from_not_open_order()
    {
    }
}
