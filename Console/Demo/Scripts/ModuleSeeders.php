<?php

namespace Modules\Core\Console\Demo\Scripts;

use Illuminate\Console\Command;
use Modules\Core\Console\Installers\SetupScript;

class ModuleSeeders implements SetupScript
{
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

    /**
     * Fire the install script.
     *
     * @param Command $command
     *
     * @return mixed
     */
    public function fire(Command $command)
    {
        if ($command->option('verbose')) {
            $command->blockMessage('Seeds', 'Running the module seeds ...', 'comment');
        }

        $this->demoSeedCoreModules($command);
        $this->demoSeedAdditionalModules($command);
    }

    private function demoSeedCoreModules($command)
    {
        foreach ($this->modules as $module) {
            $this->runDemoSeed($command, $module);
        }
    }

    /**
     * @param Command $command
     */
    private function demoSeedAdditionalModules(Command $command)
    {
        foreach (app('modules')->enabled() as $module) {
            $name = studly_case($module->getName());

            if (! in_array($name, $this->modules)) {
                $this->runDemoSeed($command, $name);
            }
        }
    }

    /**
     * @param $command
     * @param $moduleName
     */
    private function runDemoSeed($command, $moduleName)
    {
        $command->info("Seeding {$moduleName} Module");

        $demoSeederClass = "Modules\\{$moduleName}\\Database\\Seeders\\DemoTableSeeder";
        if (! class_exists($demoSeederClass)) {
            return;
        }
        if ($command->option('verbose')) {
            return $command->call('db:seed', ['--class' => $demoSeederClass]);
        }
        $command->call('db:seed', ['--class' => $demoSeederClass]);
    }
}
