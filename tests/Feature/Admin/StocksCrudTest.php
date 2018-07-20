<?php

namespace Tests\Feature\Admin;

use App\Stock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Product;
use App\User;

class StocksCrudTest extends TestCase
{
    const model = "App\Stock";
    const baseRoute = "admin.stock";
    const singularName = "stock";
    /**
     * is index page working test
     *
     * @return void
     */
    public function testStocksIndexShowTest()
    {
        //create stocks with product and user
        $record = factory(self::model)->create();

        //get index page
        $route = route(self::baseRoute . '.index', ['product' => $record->product_id]);
        $response = $this->get($route);

        //check status
        $response->assertStatus(200);

        //check product name and serial is showing on page
        $response->assertSee(e($record->product->name));
        $response->assertSee(e($record->serial));
    }

    /**
     * is create page working test
     *
     * @return void
     */
    public function testStockShowCreatePage()
    {
        //create product
        $product = factory('App\Product')->create();

        //get create page
        $r = route(self::baseRoute . '.create', ['product' => $product->id]);
        $response = $this->get($r);

        //check status is 200
        $response->assertStatus(200);
    }

    /**
     * is store feature working test
     *
     * @return void
     */
    public function testStockStore()
    {
        // make stock
        $record = factory(self::model)->make();

        // post stock data
        $response = $this->post(route(self::baseRoute. '.store', ['product' => $record->product_id]), $record->toArray());
        
        //check is record added to db
        $this->assertTrue((self::model)::where(['serial' => $record->serial, 'product_id' => $record->product_id])->exists());
    }

    /**
     * is show page working test
     *
     * @return void"
     */
    public function testShowStockPage()
    {
        //create stock
        $record = factory(self::model)->create();

        // get show page
        $response = $this->get(route(self::baseRoute . '.show',['product' => $record->product_id, self::singularName => $record->id]));

        //check status
        $response->assertStatus(200);

        //check serial num.
        $response->assertSee(e($record->serial));

        //check product name
        $response->assertSee(e($record->product->name));
    }

    /**
     * is edit page working test
     *
     * @return void
     */
    public function testEditStockPage()
    {
        //create stock
        $record = factory(self::model)->create();

        //get edit page
        $response = $this->get(route(self::baseRoute . '.edit',['product' => $record->product_id, self::singularName => $record->id]));

        //check status
        $response->assertStatus(200);

        //check serial num.
        $response->assertSee(e($record->serial));

        //check product name
        $response->assertSee(e($record->product->name));
    }

    /**
     * is update feature working test
     *
     * @return void
     */
    public function testStockUpdate()
    {
        //create stock
        $record = factory(self::model)->create();

        $orginalSerial = $record->serial;
        $record->serial = $orginalSerial . "9999";


        //post update data
        $this->post(route('admin.stock.update', ['product' => $record->product_id,  self::singularName => $record->id]), $record->toArray());

        // check record is updated in db

        $this->assertTrue((self::model)::where('id', $record->id)->where('serial', $orginalSerial . '9999')->exists());
    }

    /**
     * is delete feature working test
     *
     * @return void
     */
    public function testStockDelete()
    {
        //create stock
        $record = factory(self::model)->create();
        
        //delete post
        $this->post(route(self::baseRoute . '.delete', ['product' => $record->product_id, self::singularName => $record->id]));

        //check not exists on db
        $this->assertFalse((self::model)::where('id', $record->id)->exists());
    }
}
