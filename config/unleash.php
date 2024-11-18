<?php

return [

    /**
     * The name of the project
     */
    'project_name' => env('UNLEASH_PROJECT_NAME', 'DEFAULT'),

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
    | Enable/disable fetching to remote Unleash server
    |--------------------------------------------------------------------------
    |
    | Enable/disable switch for the Laravel Unleash server so you can use bootstrapping
    |
    */

    'fetching_enabled' => env('UNLEASH_FETCHING_ENABLED', true),

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

    'environment' => env('UNLEASH_ENVIRONMENT', config('app.env')),

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
    | The cache is used to prevent stressing the feature flag endpoint.
    |
    */

    'cache' => [
        'enabled' => env('UNLEASH_CACHE_ENABLED', true), // Cache default enabled to use Cache handler below, bc. Unleash builder always uses cache
        'ttl' => env('UNLEASH_CACHE_TTL', 30),
        'handler' => JWebb\Unleash\Cache\CacheHandler::class
    ],


    /*
    |--------------------------------------------------------------------------
    | HTTP Client Override
    |--------------------------------------------------------------------------
    |
    | HTTP Client configuration settings.
    | Setting the timeout settings manually will break the connection to an
    | unstable endpoint and fail early.
    |
    */

    'http_client_override' => [
        'enabled' => env('UNLEASH_HTTP_CLIENT_OVERRIDE', false),
        'config' => [
            'timeout' => env('UNLEASH_HTTP_TIMEOUT', 5),
            'connect_timeout' => env('UNLEASH_HTTP_CONNECT_TIMEOUT', 5),
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | API Key for compatibility with Unleash V4
    |
    */

    'api_key' => env('UNLEASH_API_KEY', null),

    /*
    |--------------------------------------------------------------------------
    | Strategy Provider
    |--------------------------------------------------------------------------
    |
    | The provider which handles and initializes your strategies
    |
    */

    'strategy_provider' => JWebb\Unleash\Providers\UnleashStrategiesProvider::class,

    /*
    |--------------------------------------------------------------------------
    | Context Provider
    |--------------------------------------------------------------------------
    |
    | The provider which handles and initializes the context, giving the option
    | to sent more context, automatically.
    |
    */

    'context_provider' => JWebb\Unleash\Providers\UnleashContextProvider::class,

    'context_items' =>[
        [
            'repository' => '',//TODO Custom repository,
            'resolver' =>  '',//TODO Custom resolver,
            'property' =>  '',//TODO Name of property used in Unleash strategy,
        ],

    ]
];
