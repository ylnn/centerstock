<?php

use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Customer', 20)->create();
        factory('App\Product', 20)->create();
        factory('App\Stock', 200)->create();
        factory('App\Area', 3)->create();
    }
}
