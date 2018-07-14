<?php

namespace Tests\Feature\Admin;

use App\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomersDBTest extends TestCase
{
    /**
     * show admin dashboard
     *
     * @return void
     */
    public function testCustomerDBCreateAndRead()
    {
        $customer = factory("App\Customer")->create();
        
        $exists = Customer::where('id', $customer->id)->exists();

        $this->assertTrue($exists);
    }
}
