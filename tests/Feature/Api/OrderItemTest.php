<?php
namespace Tests\Feature\Api;

use App\Order;
use Exception;
use App\OrderItem;
use Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        // $this->markTestIncomplete();

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

        $orderItem = OrderItem::make([
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'stock_id' => $stock->id,
            'quantity' => 50
            ]);

        $order->items()->save($orderItem);

        $response = $this->json('POST', route('api.orderitem.destroy', [
            'customer_id' => $customer->id,
            'order_id' => $order->id,
            'orderitem_id' => $orderItem->id
        ]));

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'deleted'
        ]);
    }

    public function test_user_cant_remove_item_from_not_open_order()
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

        $orderItem = OrderItem::make([
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'stock_id' => $stock->id,
            'quantity' => 50
            ]);

        $order->items()->save($orderItem);

        $response = $this->json('POST', route('api.orderitem.destroy', [
            'customer_id' => $customer->id,
            'order_id' => $order->id,
            'orderitem_id' => $orderItem->id
        ]));

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'order status is not open.'
        ]);
    }

    public function test_user_CANT_remove_items_from_another_users_order()
    {
        $this->expectException(ModelNotFoundException::class);

        $user = factory('App\User')->create();

        $this->actingAs($user, 'api');

        $user2 = factory('App\User')->create();

        $customer = factory('App\Customer')->create();

        $order = Order::make(['user_id' => $user2->id]);

        $order->status = Order::STATUS['OPEN'];

        $customer->orders()->save($order);

        $stock = factory('App\Stock')->create([
            'user_id' => $user2->id,
            'quantity' => 150
        ]);

        $orderItem = OrderItem::make([
            'user_id' => $user2->id,
            'customer_id' => $customer->id,
            'stock_id' => $stock->id,
            'quantity' => 50
            ]);

        $order->items()->save($orderItem);

        $response = $this->json('POST', route('api.orderitem.destroy', [
            'customer_id' => $customer->id,
            'order_id' => $order->id,
            'orderitem_id' => $orderItem->id
        ]));

        $response->assertStatus(422);

    }

    public function test_user_can_get_orderitems_for_own_order()
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

        $response = $this->json('POST', route('api.orderitem.index', [
            'order_id' => $order->id
        ]));

        $response->assertStatus(200);

        $this->assertEquals($response->original[0]->order_id, $order->id);
        $this->assertEquals($response->original[0]->customer_id, $customer->id);
        $this->assertEquals($response->original[0]->stock_id, $stock->id);
        $this->assertEquals($response->original[0]->quantity, $orderItem->quantity);

        $this->assertEquals($response->original[1]->order_id, $order->id);
        $this->assertEquals($response->original[1]->customer_id, $customer->id);
        $this->assertEquals($response->original[1]->stock_id, $stock2->id);
        $this->assertEquals($response->original[1]->quantity, $orderItem2->quantity);

   }


   public function test_user_cant_retrieve_other_users_order_items()
   {
        $this->expectException(\Exception::class);

        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $user2 = factory('App\User')->create();

        $customer = factory('App\Customer')->create();

        $customer2 = factory('App\Customer')->create();

        $order = Order::make(['user_id' => $user->id]);
        $order->status = Order::STATUS['OPEN'];
        $customer->orders()->save($order);

        $order2 = Order::make(['user_id' => $user2->id]);
        $order2->status = Order::STATUS['OPEN'];
        $customer->orders()->save($order2);

        $stock = factory('App\Stock')->create([
            'user_id' => $user->id,
            'quantity' => 150
        ]);

        $orderItem = OrderItem::make([
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'stock_id' => $stock->id,
            'quantity' => 50
        ]);

        $order->items()->save($orderItem);

        $response = $this->json('POST', route('api.orderitem.index', [
            'order_id' => $order2->id
        ]));
   }
}
