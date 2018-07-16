<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Customer;
use App\Area;
use Illuminate\Foundation\Testing\DatabaseTransactions;



class CustomerAreaTest extends TestCase 
{

    public function testCustomerRelatedArea()
    {
        $area = factory(Area::class)->create();

        $customer = factory(Customer::class)->create(['area_id' => $area->id]);

        $this->assertTrue($customerArea = Customer::where('area_id', $area->id)->exists());

    }

    public function testCustomerAreaRelationStore()
    {
        $area = factory(Area::class)->create();

        $customer = factory(Customer::class)->make(['name' => 'test_relation_customer']);

        $response = $this->post(route('admin.customer.store'), [
            'name' => $customer->name, 
            'area_id'=> $area->id
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('customers', [
            'name' => 'test_relation_customer',
            'area_id' => $area->id
        ]);
    }

    public function testCustomerAreaRelationUpdate()
    {
        $area = factory(Area::class)->create();

        $customer = factory(Customer::class)->create(['area_id' => $area->id, 'name' => 'CustomerAreaUpdateCustomerTestName']);

        $secondArea = factory(Area::class)->create();

        $response = $this->post(route('admin.customer.update', ['customer'=>$customer->id]), [
            'name' => $customer->name,
            'area_id'=> $secondArea->id
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'area_id' => $secondArea->id
        ]);
    }
}
