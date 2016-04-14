<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Modules\Core\Traits\Testing\DatabaseMigrations;

class InstalledTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function tests_if_SocietyCMS_boots()
    {
        $this->visit('/')
            ->see('SocietyCMS');
    }

    public function tests_if_backend_route_exists()
    {
        $this->visit(route('dashboard.index'))
            ->see('Welcome to SocietyCMS');
    }
}
