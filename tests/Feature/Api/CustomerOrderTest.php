<?php
namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Order;

class CustomerOrderTest extends TestCase
{
    public function test_user_can_create_new_order_and_new_orders_status_equals_OPEN()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $customer = factory('App\Customer')->create();
        $user->customers()->save($customer);

        $response = $this->get(route('api.order.create', ['customer' => $customer->id]));
        $response->assertStatus(201);
        $response->assertJson([
            'customer_id' => $customer->id,
            'status' => 'OPEN',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_retrieve__own_order__from_orders_route()
    {
        //when
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        //given
        $customer = factory('App\Customer')->create();

        $user->customers()->save($customer);

        $order = Order::make(['user_id' => $user->id]);

        $customer->orders()->save($order);

        //then
        //see my order
        $response = $this->post(route('api.customer.orders'));
        $response->assertStatus(200);
        $response->assertJson([[
            'customer_id' => $customer->id,
            'user_id' => $user->id,
        ]]);
    }

    public function test_is_user_CANT_retrieve__ANOTHER_USERs_order__from_orders_route()
    {
        //when
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $secondUser = factory('App\User')->create();
        //given
        $customer = factory('App\Customer')->create();

        $user->customers()->save($customer);

        $order = Order::make(['user_id' => $secondUser->id]);

        $customer->orders()->save($order);

        //then
        //see my order
        $response = $this->post(route('api.customer.orders'));
        $response->assertStatus(200);
        $response->assertJsonMissing([[
            'customer_id' => $customer->id,
            'user_id' => $secondUser->id,
        ]]);
    }

    public function test_user_can_get_own_orders_WHEN_status_equals_OPEN()
    {
        //when
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        //add new order belongsto me - OPEN STATUS
        $customer = factory('App\Customer')->create();
        $user->customers()->save($customer);

        $order = Order::make(['user_id' => $user->id]);
        $order->status = Order::STATUS['OPEN'];
        $customer->orders()->save($order);

        $response = $this->post(route('api.customer.orders', ['status' => Order::STATUS['OPEN']]));
        $response->assertStatus(200);
        $response->assertJson([[
            'customer_id' => $customer->id,
            'status' => Order::STATUS['OPEN'],
            'user_id' => $user->id,
        ]]);
    }


    public function test_user_can_get_own_orders_WHEN_status_equals_WAITING()
    {
        //when
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        //add new order belongsto me - WAITING STATUS
        $customer = factory('App\Customer')->create();

        $order = Order::make(['user_id' => $user->id]);
        $order->status = Order::STATUS['WAITING'];

        $customer->orders()->save($order);

        $response = $this->post(route('api.customer.orders', ['status' => Order::STATUS['WAITING']]));
        $response->assertStatus(200);
        $response->assertJson([[
            'customer_id' => $customer->id,
            'status' => Order::STATUS['WAITING'],
            'user_id' => $user->id,
        ]]);
    }

    public function test_status_validation_method()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $response = $this->post(route('api.customer.orders', ['status' => 'INCORRECT_STATUS']));

        $response->assertStatus(422);
    }

    /**
     * is user can see specific orders for customer
     *
     * @return void
     */
    public function testIsUserCanSeeSpecificOrdersForCustomer()
    {
        //when
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        //given
        $customer = factory('App\Customer')->create();
        $user->customers()->save($customer);
        $order = Order::make(['user_id' => $user->id]);
        $customer->orders()->save($order);

        $customer2 = factory('App\Customer')->create();
        $user->customers()->save($customer2);
        $order2 = Order::make(['user_id' => $user->id]);
        $customer2->orders()->save($order2);


        $response = $this->post(route('api.customer.orders', [
            'customer_id' => $customer->id
            ]));
        $response->assertStatus(200);
        $response->assertJson([[
            'customer_id' => $customer->id,
            'user_id' => $user->id,
        ]]);
        $response->assertJsonMissing([[
            'customer_id' => $customer2->id,
        ]]);
    }
}
