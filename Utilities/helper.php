<?php

if (! function_exists('apiRoute')) {
    /**
     * Generate a URL to a named route.
     *
     * @param string                    $name
     * @param array                     $parameters
     * @param bool                      $absolute
     * @param \Illuminate\Routing\Route $route
     *
     * @return string
     */
    function apiRoute($version, $name, $parameters = [], $absolute = true, $route = null)
    {
        return app('Dingo\Api\Routing\UrlGenerator')->version($version)->route($name, $parameters, $absolute, $route);
    }
}
