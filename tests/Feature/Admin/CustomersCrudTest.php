<?php

namespace Tests\Feature\Admin;

use App\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomersCrudTest extends TestCase
{
    /**
     * show admin dashboard
     *
     * @return void
     */
    public function testCustomersIndexShowTest()
    {
        $customers = factory("App\Customer", 3)->create();
        $response = $this->get(route('admin.customer.index'));
        $response->assertStatus(200);
        for ($i=0; $i < 3; $i++) {
            $response->assertSee($customers[$i]->name);
        }
    }

    public function testCustomerShowCreatePage()
    {
        $response = $this->get(route('admin.customer.create'));
        $response->assertStatus(200);
    }

    public function testCustomerStore()
    {
        $customer = factory(Customer::class)->make();
        $response = $this->post(route('admin.customer.store', ['name' => $customer->name]));
        $this->assertTrue(Customer::where('name', $customer->name)->exists());
    }
}
