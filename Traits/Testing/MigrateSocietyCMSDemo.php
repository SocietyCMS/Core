<?php

namespace Modules\Core\Traits\Testing;

trait DatabaseMigrations
{
    /**
     * @before
     */
    public function runDatabaseMigrations()
    {
        $this->artisan('module:migrate-reset', ['--database' => 'sqlite']);
        $this->artisan('module:migrate', ['--database' => 'sqlite']);
        $this->artisan('module:seed', ['--database' => 'sqlite']);
    }
}
