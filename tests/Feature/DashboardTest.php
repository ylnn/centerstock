<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    /**
     * show admin dashboard
     *
     * @return void
     */
    public function testShowAdminDashboard()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
