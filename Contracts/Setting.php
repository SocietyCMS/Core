<?php namespace Modules\Core\Contracts;

interface Setting
{
    /**
     * Determine if the given configuration value exists.
     *
     * @param  string $key
     * @return bool
     */
    public function has($key);

    /**
     * Get the specified configuration value in the given language
     *
     * @param  string $key
     * @param  string $locale
     * @param  mixed $default
     * @return string
     */
    public function get($key, $default = null);

    /**
     * Set a given configuration value.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function set($key, $value);
}
