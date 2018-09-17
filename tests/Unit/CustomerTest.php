<?php

namespace Tests\Unit;

use App\Stock;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Order;

class CustomerTest extends TestCase
{
    /**
     * is customer set order method is working
     *
     * @return void
     */
    public function test_customer_set_order_method_is_working()
    {
        // user
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        //customer
        $customer = factory('App\Customer')->create();
        $customer->setUser($user);

        //set order to customer
        $order = Order::make();
        $order->setUser($user);

        $customer->setOrder($order);
        $customer->save();

        $customersOrder = $customer->orders()->first();

        $this->assertEquals($customer->id, $customersOrder->customer_id);
    }

    public function test_customer_set_user_method()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $customer = factory('App\Customer')->create();

        $customer->setUser($user);

        $customer->save();

        $dbUser = $customer->user;

        $this->assertEquals($user->id, $dbUser->id);
        $this->assertEquals($user->email, $dbUser->email);
    }
}
