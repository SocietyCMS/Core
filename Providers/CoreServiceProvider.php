<?php

namespace Modules\Core\Providers;

use Carbon\Carbon;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Sidebar\SidebarManager;
use Modules\Core\Permissions\PermissionManager;
use Modules\Core\Sidebar\AdminSidebar;

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
     * The filters base class name.
     *
     * @var array
     */
    protected $middleware = [
        'Core' => [
            'societyInstalled' => 'SocietyInstalledMiddleware',
            'resolveSidebars' => 'ResolveSidebars',
            'verifyCsrfToken' => 'VerifyCsrfToken',
        ],
    ];

    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->setLocale();
        $this->registerSidebar();
        $this->registerMiddleware($this->app['router']);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerModulePermissions();
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
     * Register the modules dependencies.
     */
    private function registerModulePermissions()
    {
        foreach ($this->app['modules']->enabled() as $module) {
            if ($this->app['society.isInstalled']) {
                $permissionManager = new PermissionManager();
                $permissionManager->registerDefault($module);
            }
        }
    }

    /**
     * Register general App-Bindings.
     */
    private function registerBindings()
    {
        $this->app->bind('society.isInstalled', function ($app) {
            return
                file_exists(base_path('.env')) &&
                file_exists(storage_path('app/installed')) &&
                Schema::hasTable('migrations');
        });
    }

    /**
     * Register the AdminSidebar.
     *
     * @return mixed
     */
    private function registerSidebar()
    {
        $manager = app(SidebarManager::class);

        return $manager->register(AdminSidebar::class);
    }

    /**
     * Set the application local for Carbon
     */
    private function setLocale()
    {
        Carbon::setLocale(config('app.locale'));
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
