### Bootstrapping

Use [bootstrapping](https://docs.getunleash.io/reference/sdks/php#bootstrapping) via config file to use during development or when Unleash server fails.
Publish the [config](/config/features.php) file to your project first.

Example
```php
return [
    'features' => [
        // Short syntax (minimal usage)
        [   'enabled' => true, 'name' => 'prefix.FEATURE', 'strategies' => [[ 'name' => 'default' ]],  ],
        // All defaults
        [
            'enabled' => true,
            'name' => 'BootstrapDemo',
            'description' => '',
            'project' => 'default',
            'stale' => false,
            'type' => 'release',
            'variants' => [],
            'strategies' => [[ 'name' => 'default' ]],
        ],
    ]
];
```