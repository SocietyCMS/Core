<?php

namespace Modules\Core\Traits\Testing;

/**
 * Class MigrateSocietyCMSDemo.
 */
trait MigrateSocietyCMSDemo
{
    /**
     * @before
     */
    public function runMigrateSocietyCMSDemo()
    {
        $this->demoSeedCoreModules();
    }

    /**
     * @var array
     */
    protected $modules = [
        'Core',
        'User',
        'Setting',
        'Modules',
        'Menu',
        'Dashboard',
    ];

    private function demoSeedCoreModules()
    {
        foreach ($this->modules as $module) {
            $this->runDemoSeed($module);
        }
    }

    /**
     * @param $moduleName
     */
    private function runDemoSeed($moduleName)
    {
        $demoSeederClass = "Modules\\{$moduleName}\\Database\\Seeders\\DemoTableSeeder";
        if (!class_exists($demoSeederClass)) {
            return;
        }
        $this->artisan('db:seed', ['--class' => $demoSeederClass, '--database' => config('database.default')]);
    }
}
