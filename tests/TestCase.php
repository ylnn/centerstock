<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    // use DatabaseMigrations;
    use CreatesApplication;

    public function setUp()
    {
        // dd(env('DB_CONNECTION')); // these are correct
        // dd(env('DB_DATABASE'));
        parent::setUp();
    }
}
