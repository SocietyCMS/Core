<?php namespace Modules\Core\Console\Demo;

use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Modules\Core\Services\Composer;

class DemoMode
{
    /**
     * @var array
     */
    protected $scripts = [];

    /**
     * @param Filesystem  $finder
     * @param Application $app
     * @param Composer    $composer
     */
    public function __construct(Application $app, Filesystem $finder, Composer $composer)
    {
        $this->finder = $finder;
        $this->app = $app;
        $this->composer = $composer;
    }

    /**
     * @param  array $scripts
     * @return $this
     */
    public function stack(array $scripts)
    {
        $this->scripts = $scripts;

        return $this;
    }

    /**
     * Fire demo scripts
     * @param  Command $command
     * @return bool
     */
    public function enable(Command $command)
    {
        foreach ($this->scripts as $script) {
            try {
                $this->app->make($script)->fire($command);
            } catch (\Exception $e) {
                $command->error($e->getMessage());

                return false;
            }
        }

        return true;
    }
}
