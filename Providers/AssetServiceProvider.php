<?php
namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Utilities\AssetManager\JavascriptPipeline\JavascriptPipeline;
use Modules\Core\Utilities\AssetManager\JavascriptPipeline\SocietyJavascriptPipeline;

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
        $this->app->singleton(JavascriptPipeline::class, function () {
            return new SocietyJavascriptPipeline();
        });
    }
}