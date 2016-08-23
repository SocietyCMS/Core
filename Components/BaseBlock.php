<?php

namespace Modules\Core\Components;

abstract class BaseBlock extends BaseComponent
{
    /**
     * Get the blocks data to send to the view.
     * @return array
     */
    abstract protected function data();

    /**
     * Get the block view.
     * @return string
     */
    private function view()
    {
        if (isset(static::$view)) {
            return static::$view;
        }

        $classNamespace = $this->getModuleName();
        $className = $this->getComponentName();

        return "{$classNamespace}::blocks.{$className}";
    }

    /**
     * Boot the component.
     */
    public function boot()
    {
        view()->composer($this->view(), function ($view) {
            $view->with('data', $this->data());
        });
    }
}
