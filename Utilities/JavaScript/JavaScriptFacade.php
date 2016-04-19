<?php

namespace Modules\Core\Utilities\JavaScript;

use Illuminate\Support\Facades\Facade;

/**
 * Class JavaScriptFacade
 * @package Modules\Core\Utilities\JavaScript
 */
class JavaScriptFacade extends Facade
{
    /**
     * The name of the binding in the IoC container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'JavaScript';
    }
}
