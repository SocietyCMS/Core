<?php

namespace Modules\Core\Traits\Testing;

/**
 * Class DatabaseMigrations
 * @package Modules\Core\Traits\Testing
 */
trait DatabaseMigrations
{
    /**
     * @before
     */
    public function runDatabaseMigrations()
    {
        //$this->artisan('module:migrate-reset', ['--database' => config('database.default')]);
        $this->artisan('module:migrate', ['--database' => config('database.default')]);
        $this->artisan('module:seed', ['--database' => config('database.default')]);
    }
}
