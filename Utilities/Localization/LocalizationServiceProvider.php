<?php

namespace Modules\Core\Utilities\Localization;

use Illuminate\Support\ServiceProvider;

/**
 * Class JavaScriptServiceProvider.
 */
class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['localization.js-generator'] = $this->app->share(function ($app) {
            $files = $app['files'];

            return new Generators\LangJsGenerator($files);
        });
        $this->app['localization.js'] = $this->app->share(function ($app) {
            return new Commands\LangJsCommand($app['localization.js-generator']);
        });
        $this->commands('localization.js');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['localization.js', 'localization.js-generator'];
    }
}
