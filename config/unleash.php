<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable/disable Laravel Unleash
    |--------------------------------------------------------------------------
    |
    | Enable/disable switch for the Laravel Unleash wrapper
    |
    */

    'enabled' => env('UNLEASH_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Unleash URL
    |--------------------------------------------------------------------------
    |
    | This should be the base URL to your Unleash instance.
    | Do not include /api or anything else
    |
    */

    'url' => env('UNLEASH_URL'),

    /*
    |--------------------------------------------------------------------------
    | Instance ID
    |--------------------------------------------------------------------------
    |
    | The unique ID of your instance which is passed through to your Unleash
    | instance for identification purposes.
    |
    */

    'instance_id' => env('UNLEASH_INSTANCE_ID', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | The App environment. Useful when using a GitLab integration
    |
    */

    'environment' => env('UNLEASH_ENVIRONMENT', env('app.env')),

    /*
    |--------------------------------------------------------------------------
    | Automatic Registration
    |--------------------------------------------------------------------------
    |
    | Enable the Registration System.
    | GitLab doesn't use registration system, you can set the SDK to disable
    | automatic registration and save one http call.
    |
    */

    'automatic_registration' => env('UNLEASH_AUTOMATIC_REGISTRATION', false),

    /*
    |--------------------------------------------------------------------------
    | Metrics
    |--------------------------------------------------------------------------
    |
    | Pass metrics to the API.
    | GitLab doesn't read metrics, you can disable this to save some http calls.
    |
    */

    'metrics' => env('UNLEASH_METRICS', false),

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Unleash cache settings. This will cache any API object responses for the
    | duration of the TTL.
    |
    */

    'cache' => [
        'enabled' => env('UNLEASH_CACHE_ENABLED', false),
        'ttl' => env('UNLEASH_CACHE_TTL', 30),
    ],

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | API Key for compatibility with Unleash V4
    |
    */

    'api_key' => env('UNLEASH_API_KEY', null)
];
