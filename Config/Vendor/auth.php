<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Authentication Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the authentication driver that will be utilized.
    | This driver manages the retrieval and authentication of the users
    | attempting to get access to protected areas of your application.
    |
    | Supported: "database", "eloquent"
    |
    */
    'driver' => 'eloquent',
    /*
    |--------------------------------------------------------------------------
    | Authentication Model
    |--------------------------------------------------------------------------
    |
    | When using the "Eloquent" authentication driver, we need to know which
    | Eloquent model should be used to retrieve your users. Of course, it
    | is often just the "User" model but you may use whatever you like.
    |
    */
    'model' => Modules\User\Entities\Entrust\EloquentUser::class,
    /*
    |--------------------------------------------------------------------------
    | Authentication Table
    |--------------------------------------------------------------------------
    |
    | When using the "Database" authentication driver, we need to know which
    | table should be used to retrieve your users. We have chosen a basic
    | default value but you may easily change it to any table you like.
    |
    */
    'table' => 'user__users',

    /*
   |--------------------------------------------------------------------------
   | User Providers
   |--------------------------------------------------------------------------
   |
   | All authentication drivers have a user provider. This defines how the
   | users are actually retrieved out of your database or other storage
   | mechanisms used by this application to persist your user's data.
   |
   | If you have multiple user tables or models you may configure multiple
   | sources which represent each model / table. These sources may then
   | be assigned to any extra authentication guards you have defined.
   |
   | Supported: "database", "eloquent"
   |
   */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => Modules\User\Entities\Entrust\EloquentUser::class,
        ],
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Settings
    |--------------------------------------------------------------------------
    |
    | Here you may set the options for resetting passwords including the view
    | that is your password reset e-mail. You can also set the name of the
    | table that maintains all of the reset tokens for your application.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */
    'password' => [
        'email'  => 'emails.password',
        'table'  => 'password_resets',
        'expire' => 60,
    ],
];
