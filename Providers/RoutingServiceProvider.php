<?php

namespace Modules\Core\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

abstract class RoutingServiceProvider extends ServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = '';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $api = app('Dingo\Api\Routing\Router');

        $this->loadApiRoutes($api, $router);

        $router->group(['namespace' => $this->namespace], function (Router $router) {
            $this->loadBackendRoutes($router);
            $this->loadFrontendRoutes($router);
        });
    }

    /**
     * @param Router $router
     */
    private function loadApiRoutes($api, Router $router)
    {
        $apiRoutes = $this->getApiRoute();

        if ($apiRoutes && file_exists($apiRoutes)) {
            require $apiRoutes;
        }
    }

    /**
     * @return string
     */
    abstract protected function getApiRoute();

    /**
     * @param Router $router
     */
    private function loadBackendRoutes(Router $router)
    {
        $backend = $this->getBackendRoute();

        if ($backend && file_exists($backend)) {
            $router->group([
                'namespace'  => 'backend',
                'prefix'     => config('society.core.core.admin-prefix'),
                'middleware' => config('society.core.core.middleware.backend', []),
            ], function (Router $router) use ($backend) {
                require $backend;
            });
        }
    }

    /**
     * @return string
     */
    abstract protected function getBackendRoute();

    /**
     * @param Router $router
     */
    private function loadFrontendRoutes(Router $router)
    {
        $frontend = $this->getFrontendRoute();

        if ($frontend && file_exists($frontend)) {
            $router->group([
                'middleware' => config('society.core.core.middleware.frontend', []), ],
                function (Router $router) use ($frontend) {
                    require $frontend;
                });
        }
    }

    /**
     * @return string
     */
    abstract protected function getFrontendRoute();
}
