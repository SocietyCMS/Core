<?php namespace Modules\Core\Console\Demo\Scripts;

use Dotenv;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Modules\Core\Console\Installers\SetupScript;

class DisableCache implements SetupScript
{
    /**
     * @var Filesystem
     */
    private $finder;
    
    /**
     * @var string
     */
    protected $file = '.env';

    /**
     * @var array
     */
    protected $search = [
        "CACHE_DRIVER=memcached",
    ];


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
        $this->disableCache();
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function disableCache()
    {
        Dotenv::makeMutable();

        $environmentFile = $this->finder->get($this->file);

        $replace = [
            "CACHE_DRIVER=array",
        ];

        $newEnvironmentFile = str_replace($this->search, $replace, $environmentFile);

        $this->finder->put($this->file, $newEnvironmentFile);

        Dotenv::makeImmutable();
    }
}
