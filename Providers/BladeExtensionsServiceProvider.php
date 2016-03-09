<?php

namespace Modules\Core\Providers;

use Blade;
use JavaScript;
use Illuminate\Support\ServiceProvider;

class BladeExtensionsServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('assetPipeline', function($expression) {

            JavaScript::put([
                'banane' => 'Apfel'
            ]);

            return '<?php echo $__env->yieldContent("styles"); ?>';
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }
}