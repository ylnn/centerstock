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

    public function test_order_isStatusValid_method_is_working()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $order = Order::make(['status' => Order::STATUS['OPEN']]);

        $this->assertEquals($order->isStatusValid(Order::STATUS['WAITING']), true);

        $this->assertEquals($order->isStatusValid(Order::STATUS['DONE']), true);

        $this->assertEquals($order->isStatusValid(Order::STATUS['OPEN']), true);

        $this->assertEquals($order->isStatusValid('HATALI'), false);

        $this->assertEquals($order->isStatusValid('ERR'), false);

    }


    public function test_order_setStatus_method_is_working()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user, 'api');

        $customer = factory('App\Customer')->create();

        $order = Order::make(['user_id' => $user->id]);
        $order->status = Order::STATUS['OPEN'];
        $customer->orders()->save($order);

        $this->assertEquals(Order::STATUS['OPEN'], $order->getStatus());

        $order->setStatus(Order::STATUS['WAITING']);

        $this->assertEquals(Order::STATUS['WAITING'], $order->getStatus());

        $order->setStatus(Order::STATUS['DONE']);

        $this->assertEquals(Order::STATUS['DONE'], $order->getStatus());


    }
}
