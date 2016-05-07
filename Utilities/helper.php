<?php

use Illuminate\Support\Collection;

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

if (! function_exists('lang_replace')) {
    /**
     * Replace keys in language line.
     *
     * @param $line
     * @param array $replace
     * @return string
     */
    function lang_replace($line, array $replace)
    {
        $replace = (new Collection($replace))->sortBy(function ($value, $key) {
            return mb_strlen($key) * -1;
        });;

        foreach ($replace as $key => $value) {
            $line = str_replace(':'.$key, $value, $line);
        }

        return $line;
    }
}