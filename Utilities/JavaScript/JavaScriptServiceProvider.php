<?php
namespace Modules\Core\Utilities\JavaScript;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Utilities\AssetManager\JavascriptPipeline\JavascriptPipeline;

class JavaScriptServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('JavaScript', function ($app) {
            $namespace = config('society.core.utilities.javascript.js_namespace');
            return new PHPToJavaScriptTransformer(app(JavascriptPipeline::class), $namespace);
        });
    }

    /**
     * Publish the plugin configuration.
     */
    public function boot()
    {
        AliasLoader::getInstance()->alias(
            'JavaScript',
            'Modules\Core\Utilities\JavaScript\JavaScriptFacade'
        );
    }
}