<?php namespace Modules\Core\Console\Demo\Scripts;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Modules\Core\Console\Installers\SetupScript;

class ProtectInstallation implements SetupScript
{
    /**
     * @var Filesystem
     */
    protected $finder;

    /**
     * @param Filesystem $finder
     */
    public function __construct(Filesystem $finder)
    {
        $this->finder = $finder;
    }

    /**
     * Fire the install script
     * @param  Command   $command
     * @return mixed
     * @throws Exception
     */
    public function fire(Command $command)
    {
        if (!$this->finder->isFile('.env')) {
            throw new Exception('SocietyCMS is not installed. Please run "php artisan society:install" first.');
        }

        if (!$command->option('force')) {
            if (!$command->confirm('Are you sure you want to start Demo Mode?')) {
                throw new Exception('Demo Mode cancelled');
            }
        }
    }
}
