<?php

namespace Modules\Core\Traits\Testing;

trait DatabaseMigrations
{
    /**
     * @before
     */
    public function runDatabaseMigrations()
    {
        $this->artisan('module:migrate');

        $this->artisan('module:seed');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('module:migrate-rollback');
        });
    }
}