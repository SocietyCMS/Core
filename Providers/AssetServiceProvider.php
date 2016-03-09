<?php
namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Utilities\AssetManager\Manager\SocietyAssetManager;
use Modules\Core\Utilities\AssetManager\Manager\AssetManager;
use Modules\Core\Utilities\AssetManager\Pipeline\SocietyAssetPipeline;
use Modules\Core\Utilities\AssetManager\Pipeline\AssetPipeline;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->bindAssetClasses();
    }

    /**
     * Bind classes related to assets
     */
    private function bindAssetClasses()
    {
        $this->app->singleton(AssetManager::class, function () {
            return new SocietyAssetManager();
        });
        $this->app->singleton(AssetPipeline::class, function ($app) {
            return new SocietyAssetPipeline($app[AssetManager::class]);
        });
    }
}