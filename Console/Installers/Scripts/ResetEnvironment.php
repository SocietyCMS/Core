<?php namespace Modules\Core\Console\Installers\Scripts;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Modules\Core\Console\Installers\SetupScript;
use Modules\Core\Console\Installers\Writers\EnvFileWriter;

class ResetEnvironment implements SetupScript
{
    /**
     * @var EnvFileWriter
     */
    protected $env;

    /**
     * @param EnvFileWriter $env
     * @internal param Filesystem $finder
     */
    public function __construct(EnvFileWriter $env)
    {
        $this->env = $env;
    }

    /**
     * Fire the install script
     * @param  Command   $command
     * @return mixed
     * @throws Exception
     */
    public function fire(Command $command)
    {
        $this->env->reset();
    }
}
