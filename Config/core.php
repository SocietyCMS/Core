<?php

return [
    /*
   |--------------------------------------------------------------------------
   | The prefix that'll be used for the administration
   |--------------------------------------------------------------------------
   */
    'admin-prefix' => 'backend',

    /*
    |--------------------------------------------------------------------------
    | Location where your themes are located
    |--------------------------------------------------------------------------
    */
    'themes_path' => base_path() . '/Themes',

    /*
    |--------------------------------------------------------------------------
    | Which administration theme to use for the back end interface
    |--------------------------------------------------------------------------
    */
    'admin-theme' => 'SocietyAdmin',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    | You can customise the Middleware that should be loaded.
    | The localizationRedirect middleware is automatically loaded for both
    | Backend and Frontend routes.
    */
    'middleware' => [
        'backend' => [
            'auth.backend',
            'permissions',
        ],
        'frontend' => [
        ],
        'api' => [
            'backend' => [
                'api.auth'
            ],
            'frontend' => [
            ],
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | These are the core modules that should NOT be disabled under any circumstance
    |--------------------------------------------------------------------------
    */
    'CoreModules' => [
        'core',
        'dashboard',
        'user',
        'menu',
        'setting',
        'modules'
    ],

];