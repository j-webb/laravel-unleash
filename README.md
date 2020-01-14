# Laravel Unleash

A simple Unleash client for Laravel. It is compatible with the [Unlesah-hosted.com SaaS offering](https://www.unleash-hosted.com/) and [Unleash Open-Soruce](https://github.com/finn-no/unleash).

## Getting started

### 1. Install the Laravel Unleash via Composer
```bash
composer require j-webb/laravel-unleash
```

### 2. Configure

####Create local configuration (optional)
```bash
php artisan vendor:publish --provider="JWebb\Unleash\Providers\ServiceProvider"
```

####Required .env values

```dotenv
#Your Unleash instance endpoint
UNLEASH_URL=https://app.unleash-hosted.com/demo/api/
```

####Optional .env values
```dotenv
#Enable or disable the Laravel Unleash client. If disabled, all feature checks will return false
UNLEASH_ENABLED=true

#Currently unused, but is sent as a header alongside the Unleash API requests
UNLEASH_APPLICATION_NAME=Laravel 

#Currently unused, but is sent as a header alongside the Unleash API requests
UNLEASH_INSTANCE_ID=production 
```
####Setting up caching/polling
The configuration contains values to enable/disable cache, as well as set a cache TTL. You can mimic the recommended Unleash polling by setting a TTL of 15 seconds.

####Setting up Activation Strategies
Laravel Unleash comes with a selection of activation strategies out of the box. You can enable/disable these by commenting out the required line inside the configuration.

You may also add custom strategy classes by adding them on a new line after the existing strategies.

## Usage

Checking individual features
```php
if (Unleash::feature()->isEnabled('your_feature')) {
    // Your feature is enabled
}

if (Unleash::feature()->isActive('your_feature')) {
    // Your feature is enabled and is applicable (strategy activated)
}

if (Unleash::feature()->isActive('your_feature', false)) {
    // Your feature is active (strategy activated), but may not be enabled
}
```

Using array of features
```php
// List of all features, enabled or disabled
$allFeatures = Unleash::feature()->all();

// List of all enabled features
$enabledFeatures = Unleash::feature()->getEnabled();

// List of all enabled and active features
$activeFeatures = Unleash::feature()->getActive();

// List of all active features, but may not be enabled
$activeFeatures = Unleash::feature()->getActive(false); 
```

