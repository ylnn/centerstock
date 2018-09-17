<?php

namespace Tests\Unit;

use App\Stock;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Order;

class CustomerTest extends TestCase
{
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
