<?php

namespace Modules\Core\Console\Installers\Scripts;

use Exception;
use Illuminate\Console\Command;
use Modules\Core\Console\Installers\SetupScript;
use Symfony\Component\Console\Helper\Table;

class RequirementsCheck implements SetupScript
{
    private $command;
    private $hasErrors;
    private $requirements;

    /**
     * @var array
     */
    protected $requiredExtensions = [
        'openssl'   => 'OpenSSL PHP Extension',
        'pdo'       => 'PDO PHP Extension',
        'mbstring'  => 'Mbstring PHP Extension',
        'tokenizer' => 'Tokenizer PHP Extension',
        'mcrypt'    => 'Mcrypt PHP Extension',
        'gd'        => 'GD PHP Library',
    ];

    /**
     * Fire the install script.
     *
     * @param Command $command
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function fire(Command $command)
    {
        $this->command = $command;

        if ($command->option('verbose')) {
            $command->blockMessage('Requirements', 'Checking System Requirements ...', 'comment');
        }

        $this->checkPHPVersion();
        $this->checkExtensions();

        $this->showResults();
    }

    private function checkPHPVersion()
    {
        if (version_compare(PHP_VERSION, '5.5.9') >= 0) {
            return $this->requirements[] = ['PHP 5.5.9 or higher', true];
        }

        $this->requirements[] = ['PHP 5.5.9 or higher', false];
        $this->hasErrors = true;
    }

    private function checkExtensions()
    {
        foreach ($this->requiredExtensions as $extension => $extensionName) {
            if (!extension_loaded($extension)) {
                $this->requirements[] = [$extensionName, false];
                $this->hasErrors = true;
                continue;
            }
            $this->requirements[] = [$extensionName, true];
        }
    }

    private function showResults()
    {
        if ($this->hasErrors || $this->command->option('verbose')) {
            array_walk_recursive($this->requirements, function (&$item, $key) {
                if (is_bool($item)) {
                    $item = $item ? '<fg=green>true</>' : '<fg=red>false</>';
                }
            });

            $this->command->table(['Requirement', ''], $this->requirements);
        }

        if ($this->hasErrors) {
            throw new Exception('Your Server does not meet all requirements. Please make sure you install all extensions first.');
        }
    }
}
