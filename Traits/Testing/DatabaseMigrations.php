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

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('module:migrate-rollback');
        });
    }
}
