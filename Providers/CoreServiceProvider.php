<?php

namespace Modules\Core\Providers;

use Config;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Sidebar\SidebarManager;
use Modules\Core\Sidebar\AdminSidebar;
use Pingpong\Modules\Module;

/**
 * Class CoreServiceProvider.
 */
class CoreServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @var string
     */
    protected $prefix = 'society';

    /**
     * The filters base class name.
     *
     * @var array
     */
    protected $middleware = [
        'Core' => [
            'societyInstalled' => 'SocietyInstalledMiddleware',
            'resolveSidebars'  => 'ResolveSidebars',
            'verifyCsrfToken'  => 'VerifyCsrfToken',
        ],
    ];

    /**
     * Boot the application events.
     *
     * @param SidebarManager $manager
     */
    public function boot(SidebarManager $manager)
    {
        $manager->register(AdminSidebar::class);

        $this->registerMiddleware($this->app['router']);
        $this->registerModuleResourceNamespaces();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('society.isInstalled', function ($app) {
            return
                file_exists(base_path('.env')) &&
                file_exists(storage_path('app/installed')) &&
                Schema::hasTable('migrations');
        });
        $this->registerModuleVendorDependencies();
    }

    /**
     * Register the filters.
     *
     * @param Router $router
     *
     * @return void
     */
    public function registerMiddleware(Router $router)
    {
        foreach ($this->middleware as $module => $middlewares) {
            foreach ($middlewares as $name => $middleware) {
                $class = "Modules\\{$module}\\Http\\Middleware\\{$middleware}";

                $router->middleware($name, $class);
            }
        }
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

            if ($this->app['society.isInstalled']) {
                $permissionManager = new \Modules\Core\Permissions\PermissionManager();
                $permissionManager->registerDefault($module);
            }
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
        } else {
            $this->loadTranslationsFrom($module->getPath().'/Resources/lang', $moduleName);
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
