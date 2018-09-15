<?php

namespace Tests\Unit;

use App\Stock;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Order;

class CustomerOrderTest extends TestCase
{
    /**
     * is customer add order method is working
     *
     * @return void
     */
    public function test_customer_add_order_method_is_working()
    {
        // user
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        //customer
        $customer = factory('App\Customer')->create();

        $order =  Order::make();

        $customer->addOrder($order, $user);

        $customersOrder = $customer->orders()->first();

        $this->assertEquals($customer->id, $customersOrder->customer_id);
    }
}
