<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the authentication guards for your application.
    | A great default setup for most applications is using session storage and
    | the Eloquent user provider. Feel free to explore other guards for your
    | application needs.
    |
    */

    'guards' => [

        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
            'hash' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are retrieved from your database or other storage mechanisms.
    | You may configure multiple providers if you have more than one user
    | table or model.
    |
    */

    'providers' => [

        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Entrenador::class,
        ],

        // Aquí puedes agregar otros proveedores si necesitas autenticar otros modelos

    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset
    |--------------------------------------------------------------------------
    |
    | Here you may configure the password reset settings for your application.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

];
