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
        $response = $this->post(route('api.order.index'));
        $response->assertStatus(200);
        $response->assertJson([[
            'customer_id' => $myCustomer->id,
            'user_id' => $user->id,
        ]]);
    }

    /**
     * is user can retrieve own orders list with status equals OPEN
     *
     * @return void
     */
    public function testIsUserCanRetrieveOwnOrdersListWithStatusEqualsOPEN()
    {
        //when
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        //add new order belongsto me - OPEN STATUS
        $myCustomer = factory('App\Customer')->create();
        $user->addCustomer($myCustomer);
        $myOrder = Order::make();
        $myOrder->status = Order::STATUS['OPEN'];
        $myCustomer->addOrder($myOrder, $user);

        $response = $this->post(route('api.order.index', ['status' => Order::STATUS['OPEN']]));
        $response->assertStatus(200);
        $response->assertJson([[
            'customer_id' => $myCustomer->id,
            'status' => Order::STATUS['OPEN'],
            'user_id' => $user->id,
        ]]);
    }


    /**
     * is user can retrieve own orders list with status equals WAITING
     *
     * @return void
     */
    public function testIsUserCanRetrieveOwnOrdersListWithStatusEqualsWAITING()
    {
        //when
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        //add new order belongsto me - WAITING STATUS
        $myCustomer = factory('App\Customer')->create();
        $user->addCustomer($myCustomer);
        $myOrder = Order::make();
        $myOrder->status = Order::STATUS['WAITING'];
        $myCustomer->addOrder($myOrder, $user);


        $response = $this->post(route('api.order.index', ['status' => Order::STATUS['WAITING']]));
        $response->assertStatus(200);
        $response->assertJson([[
            'customer_id' => $myCustomer->id,
            'status' => Order::STATUS['WAITING'],
            'user_id' => $user->id,
        ]]);
    }

    /**
     * in order list method: is status validation working
     *
     * @return void
     */
    public function testIsStatusValidationIsWorking()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $response = $this->post(route('api.order.index', ['status' => 'INCORRECT_STATUS']));

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
        $myCustomer = factory('App\Customer')->create();
        $user->addCustomer($myCustomer);
        $myOrder = Order::make();
        $myCustomer->addOrder($myOrder, $user);

        $customer2 = factory('App\Customer')->create();
        $user->addCustomer($customer2);
        $order2 = Order::make();
        $customer2->addOrder($order2, $user);


        $response = $this->post(route('api.customer.orders', [
            'customer_id' => $myCustomer->id
            ]));
        $response->assertStatus(200);
        $response->assertJson([[
            'customer_id' => $myCustomer->id,
            'user_id' => $user->id,
        ]]);
        $response->assertJsonMissing([[
            'customer_id' => $customer2->id,
        ]]);
    }
}
