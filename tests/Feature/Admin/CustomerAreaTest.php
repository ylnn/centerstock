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
}
