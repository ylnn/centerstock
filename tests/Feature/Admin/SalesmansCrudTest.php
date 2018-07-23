<?php

namespace Tests\Feature\Admin;

use App\Salesman;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Area;
use App\User;

class SalesmansCrudTest extends TestCase
{
    const baseRoute = "admin.salesman";
    const singularName = "user";
    const model = "App\User";
    /**
     * is index page working test
     *
     * @return void
     */
    public function testSalesmansIndexShowTest()
    {
        $records = factory(User::class)->create();
        $response = $this->get(route(self::baseRoute . '.index'));
        $response->assertStatus(200);
        $response->assertSee(e($records->name));
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

        $response = $this->post(route(self::baseRoute . '.update', [self::singularName => $record->id]), [
            'name' => $record->name . "_test",
            'email' => $record->email,
            'status' => $record->status,
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

}
