<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Modules\Core\Components\BaseBlock;
use Pingpong\Modules\Module;

class ComponentsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBlockBladeDirective();

        /*
         * Delayed until app is fully booted, because we need the current theme to be registered.
         * Modules\Setting\Providers\ThemeServiceProvider::register()
         */
        $this->app->booted(function () {
            $this->bootModuleComponents();
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Register the Blade directive for Blocks.
     */
    protected function registerBlockBladeDirective()
    {
        Blade::directive('block', function ($expression) {
            if (Str::startsWith($expression, '(')) {
                $expression = substr($expression, 1, -1);
            }

            list($module, $component) = $segments = explode('::', $expression);

            return "<?php echo \$__env->make($module::blocks.$component, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
        });
    }

    /**
     * Boot components for all enabled modules.
     */
    protected function bootModuleComponents()
    {
        foreach ($this->app['modules']->enabled() as $module) {
            if ($this->moduleHasBlocks($module)) {
                $this->bootModuleBlocks($module);
            }
        }
    }

    /**
     * @param Module $module
     */
    protected function bootModuleBlocks(Module $module)
    {
        foreach ($module->get('blocks') as $block) {
            $module = studly_case($module->getName());
            $block = studly_case($block);
            $class = "Modules\\{$module}\\Components\\{$block}Block";

            if (class_exists($class)) {
                /* @var BaseBlock $moduleBlock */
                $moduleBlock = app()->make($class)
                        ->setModuleName($module)
                        ->setComponentName($block);

                $moduleBlock->boot($module, $block);
            }
        }
    }

    /**
     * @param $module
     * @return bool
     */
    protected function moduleHasBlocks($module)
    {
        return ! empty($module->get('blocks'));
    }
}
