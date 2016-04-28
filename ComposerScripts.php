<?php

namespace Modules\Core;

use Composer\Script\Event;
use Illuminate\Foundation\Application;

class ComposerScripts
{
    /**
     * Handle the post-install Composer event.
     *
     * @param  \Composer\Script\Event  $event
     * @return void
     */
    public static function postInstall(Event $event)
    {
        require_once $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';

        static::clearCompiled();
        static::artisanOptimize();
        static::artisanLangJS();
    }

    /**
     * Handle the post-update Composer event.
     *
     * @param  \Composer\Script\Event  $event
     * @return void
     */
    public static function postUpdate(Event $event)
    {
        require_once $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';

        static::clearCompiled();
        static::artisanOptimize();
        static::artisanLangJS();
    }

    /**
     * Clear the cached Laravel bootstrapping files.
     *
     * @return void
     */
    protected static function clearCompiled()
    {
        $laravel = new Application(getcwd());

        if (file_exists($compiledPath = $laravel->getCachedCompilePath())) {
            @unlink($compiledPath);
        }

        if (file_exists($servicesPath = $laravel->getCachedServicesPath())) {
            @unlink($servicesPath);
        }
    }

    /**
     * Generate the compiled class file.
     *
     * @return void
     */
    protected static function artisanOptimize()
    {
        exec('php artisan optimize');
    }

    /**
     * Generate language files.
     *
     * @return void
     */
    protected static function artisanLangJS()
    {
        exec('php artisan lang:js');
    }
}
