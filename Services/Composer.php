<?php

namespace Modules\Core\Services;

use Symfony\Component\Process\Process;

/**
 * Class Composer
 * @package Modules\Core\Services
 */
class Composer extends \Illuminate\Foundation\Composer
{
    /**
     * @var null
     */
    protected $outputHandler = null;
    /**
     * @var
     */
    private $output;

    /**
     * Enable real time output of all commands.
     *
     * @param $command
     *
     * @return void
     */
    public function enableOutput($command)
    {
        $this->output = function ($type, $buffer) use ($command) {
            if (Process::ERR === $type) {
                $command->info(trim('[ERR] > '.$buffer));
            } else {
                $command->info(trim('> '.$buffer));
            }
        };
    }

    /**
     * Disable real time output of all commands.
     *
     * @return void
     */
    public function disableOutput()
    {
        $this->output = null;
    }

    /**
     * Update all composer packages.
     *
     * @param string $package
     *
     * @return void
     */
    public function update($package = null)
    {
        if (!is_null($package)) {
            $package = '"'.$package.'"';
        }
        $process = $this->getProcess();
        $process->setCommandLine(trim($this->findComposer().' update '.$package));
        $process->run($this->output);
    }

    /**
     * Require a new composer package.
     *
     * @param string $package
     *
     * @return void
     */
    public function install($package)
    {
        if (!is_null($package)) {
            $package = '"'.$package.'"';
        }
        $process = $this->getProcess();
        $process->setCommandLine(trim($this->findComposer().' require '.$package));
        $process->run($this->output);
    }

    /**
     * Dumps the autoloader
     *
     * @return void
     */
    public function dumpAutoload()
    {
        $process = $this->getProcess();
        $process->setCommandLine(trim($this->findComposer().' dump-autoload -o'));
        $process->run($this->output);
    }

    /**
     * Removes a package from the require or require-dev
     * 
     * @param $package
     */
    public function remove($package)
    {
        if (!is_null($package)) {
            $package = '"'.$package.'"';
        }
        $process = $this->getProcess();
        $process->setCommandLine(trim($this->findComposer().' remove '.$package));
        $process->run($this->output);
    }
}
