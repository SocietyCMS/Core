<?php
namespace Modules\Core\Utilities\JavaScript;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

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
            $view = config('society.core.utilities.javascript.bind_js_vars_to_this_view');
            $namespace = config('society.core.utilities.javascript.js_namespace');
            $binder = new LaravelViewBinder($app['events'], $view);
            return new PHPToJavaScriptTransformer($binder, $namespace);
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