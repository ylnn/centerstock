<?php

namespace Tests\Unit;

use App\Stock;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Order;

class OrderTest extends TestCase
{
    public function test_order_is_open_method()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $order = Order::make(['status' => Order::STATUS['WAITING']]);

        $this->assertEquals($order->isOpen(), false);

        $secondOrder = Order::make(['status' => Order::STATUS['OPEN']]);

        $this->assertEquals($secondOrder->isOpen(), true);
    }
}
