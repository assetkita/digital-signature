<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Digital Signature
    |--------------------------------------------------------------------------
    |
    | This option controls the default digital signature connection that gets used while
    | using this digital signature library. This connection is used when another is
    | not explicitly specified when executing a given digital signature function.
    |
    */
    'default'  => env('DIGITAL_SIGNATURE_DRIVER', 'privy'),

    /*
    |--------------------------------------------------------------------------
    | Digital Signature Services
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many digital signature "services" as you wish, and you
    | may even configure multiple services of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "privy",
    |
    */
    'services' => [

        'privy' => [
            'merchant_key' => env('PRIVY_MERCHANT_KEY'),
            'username'     => env('PRIVY_USERNAME'),
            'password'     => env('PRIVY_PASSWORD'),
            'development'  => [
                'endpoint'         => env('PRIVY_DEVELOPMENT_ENDPOINT'),
                'enterprise_token' => env('PRIVY_DEVELOPMENT_ENTERPRISE_TOKEN'),
                'web_sdk_endpoint' => env('PRIVY_DEVELOPMENT_WEB_SDK_ENDPOINT'),
            ],
            'production'   => [
                'endpoint'         => env('PRIVY_PRODUCTION_ENDPOINT'),
                'enterprise_token' => env('PRIVY_PRODUCTION_ENTERPRISE_TOKEN'),
                'web_sdk_endpoint' => env('PRIVY_PRODUCTION_WEB_SDK_ENDPOINT'),
            ],
        ],

    ],

];
