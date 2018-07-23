<?php

namespace Tests\Feature\Admin;

use App\Salesman;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Area;

class SalesmansCrudTest extends TestCase
{
    const model = "App\Salesman";
    const baseRoute = "admin.salesman";
    const singularName = "salesman";
    /**
     * is index page working test
     *
     * @return void
     */
    public function testSalesmansIndexShowTest()
    {
        $records = factory(self::model, 3)->create();
        $response = $this->get(route(self::baseRoute . '.index'));
        $response->assertStatus(200);
        for ($i=0; $i < 3; $i++) {
            $response->assertSee(e($records[$i]->name));
        }
    }

    /**
     * is create page working test
     *
     * @return void
     */
    public function testSalesmanShowCreatePage()
    {
        $response = $this->get(route(self::baseRoute . '.create'));
        $response->assertStatus(200);
    }

    /**
     * is store feature working test
     *
     * @return void
     */
    public function testSalesmanStore()
    {
        $record = factory(self::model)->make();
        $response = $this->post(route(self::baseRoute . '.store', [
            'name' => $record->name,
            'email' => $record->email,
            'password' => 'password',
            'status' => 0,
            'area_id' => $record->area_id,
            'phone' => $record->phone,
            'address' => $record->address,
            'desc' => $record->desc,
        ]));
        $this->assertTrue((self::model)::where('name', $record->name)->exists());
    }

    /**
     * is show page working test
     *
     * @return void"
     */
    public function testShowSalesmanPage()
    {
        $record = factory(self::model)->create();
        $response = $this->get(route(self::baseRoute . '.show',[self::singularName => $record->id]));
        $response->assertStatus(200);
        $response->assertSee(e($record->name));
    }

    /**
     * is edit page working test
     *
     * @return void
     */
    public function testEditSalesmanPage()
    {
        $record = factory(self::model)->create();
        $response = $this->get(route(self::baseRoute . '.edit',[self::singularName => $record->id]));
        $response->assertStatus(200);
        $response->assertSee(e($record->name));
    }

    /**
     * is update feature working test
     *
     * @return void
     */
    public function testSalesmanUpdate()
    {
        $record = factory(self::model)->create();

        $area = Area::first();
        if(!$area) {
            $area = factory(Area::class)->create();
        }

        $this->post(route(self::baseRoute . '.update', [self::singularName => $record->id]), [
            'name' => $record->name . "_test",
            'email' => $record->email,
            'password' => $record->password,
            'status' => 1,
            'area_id' => $record->area_id,
            'phone' => $record->phone,
            'address' => $record->address,
            'desc' => $record->desc,
        ]);
        $this->assertTrue((self::model)::where('id', $record->id)->where('name', $record->name . "_test")->exists());
    }

    /**
     * is delete feature working test
     *
     * @return void
     */
    public function testSalesmanDelete()
    {
        $record = factory(self::model)->create();
        $this->post(route(self::baseRoute . '.delete', [self::singularName => $record->id]));
        $this->assertFalse((self::model)::where('id', $record->id)->exists());
    }

    /**
     * is query with area_id feature working test
     *
     * @return void
     */
    public function testSalesmanFilterWithArea()
    {
        // create record
        $record = factory(self::model)->create();
        
        //create record for don't see
        $record2 = factory(self::model)->create();

        //get index page with area name query
        $response = $this->get(route(self::baseRoute . '.index', ['area_id' => $record->area_id]));

        //assert see name and area name
        $response->assertSeeText(e($record->area->name));
        
        //assert dont see name and area name
        $response->assertDontSeeText(e($record2->area->name));

    }
}
