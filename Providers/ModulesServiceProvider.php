<?php

namespace Modules\Core\Providers;

use Config;
use Illuminate\Support\ServiceProvider;
use Pingpong\Modules\Module;

/**
 * Class CoreServiceProvider.
 */
class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Prefix for SocietyCMS modules config files.
     *
     * @var string
     */
    protected $prefix = 'society';

    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->registerModuleResourceNamespaces();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModuleVendorDependencies();
    }

    /**
     * Register the modules aliases.
     */
    private function registerModuleResourceNamespaces()
    {
        foreach ($this->app['modules']->enabled() as $module) {
            $this->registerViewNamespace($module);
            $this->registerLanguageNamespace($module);
            $this->registerConfigNamespace($module);
        }
    }

    /**
     * Register the modules dependencies.
     */
    private function registerModuleVendorDependencies()
    {
        foreach ($this->app['modules']->enabled() as $module) {
            $this->registerVendorConfig($module);
        }
    }

    /**
     * Register the view namespaces for the modules.
     *
     * @param Module $module
     */
    protected function registerViewNamespace(Module $module)
    {
        if ($module->getName() == 'user') {
            return;
        }
        $this->app['view']->addNamespace(
            $module->getName(),
            $module->getPath().'/Resources/views'
        );
    }

    /**
     * Register the language namespaces for the modules.
     *
     * @param Module $module
     */
    protected function registerLanguageNamespace(Module $module)
    {
        $moduleName = $module->getName();

        $langPath = base_path("resources/lang/modules/$moduleName");

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $moduleName);
            $this->app['localization.js-generator']->addSourcePath($langPath);
        } else {
            $this->loadTranslationsFrom($module->getPath().'/Resources/lang', $moduleName);
            $this->app['localization.js-generator']->addSourcePath($module->getPath().'/Resources/lang');
        }
    }

    /**
     * Register the config namespace.
     *
     * @param Module $module
     */
    private function registerConfigNamespace(Module $module)
    {
        $files = $this->app['files']->files($module->getPath().'/Config');

        $package = $module->getName();

        foreach ($files as $file) {
            $filename = $this->getConfigFilename($file, $package);

            $this->mergeConfigFrom(
                $file,
                $filename
            );
        }
    }

    /**
     * @param $file
     * @param $package
     *
     * @return string
     */
    private function getConfigFilename($file, $package)
    {
        $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($file));

        $filename = $this->prefix.'.'.$package.'.'.$name;

        return $filename;
    }

    /**
     * Register the config namespace.
     *
     * @param Module $module
     */
    private function registerVendorConfig(Module $module)
    {
        $files = $this->app['files']->files($module->getPath().'/Config/Vendor');

        foreach ($files as $file) {
            $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($file));

            $this->mergeConfigFrom(
                $file,
                $filename
            );
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
