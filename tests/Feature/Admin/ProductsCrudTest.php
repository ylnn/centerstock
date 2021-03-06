<?php

namespace Tests\Feature\Admin;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsCrudTest extends TestCase
{
    const model = "App\Product";
    const baseRoute = "admin.product";
    const singularName = "product";
    /**
     * is index page working test
     *
     * @return void
     */
    public function testProductsIndexShowTest()
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
    public function testProductShowCreatePage()
    {
        $response = $this->get(route(self::baseRoute . '.create'));
        $response->assertStatus(200);
    }

    /**
     * is store feature working test
     *
     * @return void
     */
    public function testProductStore()
    {
        $record = factory(self::model)->make();
        $response = $this->post(route(self::baseRoute . '.store', [
            'name' => $record->name, 
            'base_price' => $record->base_price
        ]));
        $this->assertTrue((self::model)::where('name', $record->name)->exists());
    }

    /**
     * is show page working test
     *
     * @return void"
     */
    public function testShowProductPage()
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
    public function testEditProductPage()
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
    public function testProductUpdate()
    {
        $record = factory(self::model)->create();
        $this->post(route(self::baseRoute . '.update', [self::singularName => $record->id]), [
            'name' => $record->name . '_test',
            'base_price' => $record->base_price,
        ]);
        $this->assertTrue((self::model)::where('id', $record->id)->where('name', $record->name . '_test')->exists());
    }

    /**
     * is delete feature working test
     *
     * @return void
     */
    public function testProductDelete()
    {
        $record = factory(self::model)->create();
        $this->post(route(self::baseRoute . '.delete', [self::singularName => $record->id]));
        $this->assertFalse((self::model)::where('id', $record->id)->exists());
    }
}
