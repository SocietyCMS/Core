<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Core\Traits\Testing\DatabaseMigrations;

class ExampleTest extends TestCase
{

    use DatabaseMigrations, DatabaseTransactions;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('SocietyCMS');
       
    }
}
