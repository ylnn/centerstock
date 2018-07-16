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
            $response->assertSee(e($customers[$i]->name));
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

    public function testShowCustomerPage()
    {
        $customer = factory(Customer::class)->create();
        $response = $this->get(route('admin.customer.show',['customer' => $customer->id]));
        $response->assertStatus(200);
        $response->assertSee(e($customer->name));
    }

    public function testEditCustomerPage()
    {
        $customer = factory(Customer::class)->create();
        $response = $this->get(route('admin.customer.edit',['customer' => $customer->id]));
        $response->assertStatus(200);
        $response->assertSee(e($customer->name));
    }

    public function testUpdateCustomer()
    {
        $customer = factory(Customer::class)->create();
        $this->post(route('admin.customer.update', ['customer' => $customer->id]), [
            'name' => $customer->name,
            'phone' => '123456'
        ]);
        $this->assertTrue(Customer::where('id', $customer->id)->where('phone', '123456')->exists());
    }

    public function testCustomerDelete()
    {
        $customer = factory(Customer::class)->create();
        $this->post(route('admin.customer.delete', ['customer' => $customer->id]));
        $this->assertFalse(Customer::where('id', $customer->id)->exists());
    }
}
