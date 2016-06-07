<?php

namespace Modules\Core\Components;

use Illuminate\Support\Str;

/**
 * Class BaseComponent
 * @package Modules\Core\Components
 */
abstract class BaseComponent
{

    /**
     * @var
     */
    private $moduleName;

    /**
     * @var
     */
    private $componentName;

    /**
     * @return mixed
     */
    public function getModuleName()
    {
        return Str::lower($this->moduleName);
    }

    /**
     * @param $moduleName
     * @return BaseComponent
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComponentName()
    {
        return Str::lower($this->componentName);
    }

    /**
     * @param mixed $componentName
     * @return BaseComponent
     */
    public function setComponentName($componentName)
    {
        $this->componentName = $componentName;

        return $this;
    }

    /**
     * Boot the component
     * @return mixed
     */
    abstract protected function boot();
}