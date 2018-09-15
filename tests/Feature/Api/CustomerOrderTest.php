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

        $order = Order::make();

        $customer->addOrder($order, $user);

        $response = $this->get(route('api.order.create', ['customerId' => $customer->id]));
        $response->assertStatus(201);
        $response->assertJson([
            'customer_id' => $customer->id,
            'status' => 'OPEN',
            'user_id' => $user->id,
        ]);
    }

    /**
     * is user can retrieve own order list and not others
     *
     * @return void
     */
    public function testIsUserCanRetrieveOwnOrdersList()
    {
        //when
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');


        //given
        //add new order belongsto me
        //add new order belongsto another user
        $anotherUser = factory('App\User')->create();

        $myCustomer = factory('App\Customer')->create();
        $anotherCustomer = factory('App\Customer')->create();

        $user->addCustomer($myCustomer);
        $anotherUser->addCustomer($anotherCustomer);

        $myOrder = Order::make();
        $anotherOrder = Order::make();

        $myCustomer->addOrder($myOrder, $user);
        $anotherCustomer->addOrder($anotherOrder, $anotherUser);

        //then
        //see my order
        //dont see another users order
        $response = $this->get(route('api.order.index'));
        $response->assertStatus(200);
        $response->assertJson([[
            'customer_id' => $myCustomer->id,
            'user_id' => $user->id,
        ]]);
    }
}
