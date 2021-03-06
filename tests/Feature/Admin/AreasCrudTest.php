<?php

namespace Tests\Feature\Admin;

use App\Area;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AreasCrudTest extends TestCase
{
    const model = "App\Area";
    const baseRoute = "admin.area";
    const singularName = "area";
    /**
     * is index page working test
     *
     * @return void
     */
    public function testAreasIndexShowTest()
    {
        $first = Area::create(['name' => "AAAA"]);
        $second = Area::create(['name' => "BBBB"]);

        $response = $this->get(route(self::baseRoute . '.index'));
        $response->assertStatus(200);
        $response->assertSee($first->name);
        $response->assertSee($second->name);
    }

    /**
     * is create page working test
     *
     * @return void
     */
    public function testAreaShowCreatePage()
    {
        $response = $this->get(route(self::baseRoute . '.create'));
        $response->assertStatus(200);
    }

    /**
     * is store feature working test
     *
     * @return void
     */
    public function testAreaStore()
    {
        $record = factory(self::model)->make();
        $response = $this->post(route(self::baseRoute . '.store', ['name' => $record->name]));
        $this->assertTrue((self::model)::where('name', $record->name)->exists());
    }

    /**
     * is show page working test
     *
     * @return void"
     */
    public function testShowAreaPage()
    {
        $record = factory(self::model)->create();
        $response = $this->get(route(self::baseRoute . '.show', [self::singularName => $record->id]));
        $response->assertStatus(200);
        $response->assertSee(e($record->name));
    }

    /**
     * is edit page working test
     *
     * @return void
     */
    public function testEditAreaPage()
    {
        $record = factory(self::model)->create();
        $response = $this->get(route(self::baseRoute . '.edit', [self::singularName => $record->id]));
        $response->assertStatus(200);
        $response->assertSee(e($record->name));
    }

    /**
     * is update feature working test
     *
     * @return void
     */
    public function testAreaUpdate()
    {
        $record = factory(self::model)->create();
        $this->post(route(self::baseRoute . '.update', [self::singularName => $record->id]), [
            'name' => $record->name . "_test",
        ]);
        $this->assertTrue((self::model)::where('id', $record->id)->where('name', $record->name . "_test")->exists());
    }

    /**
     * is delete feature working test
     *
     * @return void
     */
    public function testAreaDelete()
    {
        $record = factory(self::model)->create();
        $this->post(route(self::baseRoute . '.delete', [self::singularName => $record->id]));
        $this->assertFalse((self::model)::where('id', $record->id)->exists());
    }
}
