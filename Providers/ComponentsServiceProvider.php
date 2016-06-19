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
        $this->bootModuleComponents();

        /*
         * Delayed until app is fully booted, because we need the current theme to be registered.
         * Modules\Setting\Providers\ThemeServiceProvider::register()
         */
        $this->app->booted(function () {
            $this->registerBlockBladeDirective();
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

            $expression = $this->sanitizeExpression($expression);

            list($module, $component) = explode('::', $expression);

            if (view()->exists("$module::blocks.$component")) {
                return "<?php echo \$__env->make('$module::blocks.$component', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
            }
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
            $moduleName = studly_case($module->getName());
            $block = studly_case($block);
            $class = "Modules\\{$moduleName}\\Components\\{$block}Block";

            if (class_exists($class)) {
                /* @var BaseBlock $moduleBlock */
                $moduleBlock = app()->make($class)
                    ->setModuleName($moduleName)
                    ->setComponentName($block);

                $moduleBlock->boot($moduleName, $block);
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

    /**
     * @param $expression
     * @return mixed|string
     */
    protected function sanitizeExpression($expression)
    {
        if (Str::startsWith($expression, '(')) {
            $expression = substr($expression, 1, -1);
            $expression = str_replace(['\'', '"'], "", $expression);
        }

        return $expression;
    }
}
