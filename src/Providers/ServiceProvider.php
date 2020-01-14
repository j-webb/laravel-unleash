<?php

namespace JWebb\Unleash\Providers;

use JWebb\Unleash\Unleash;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('unleash', function ($app) {
            $client = new Client([
                'base_uri' => config('unleash.url'),
                'headers' => [
                    'UNLEASH-APPNAME' => config('unleash.application_name'),
                    'UNLEASH-INSTANCEID' => config('unleash.instance_id'),
                ]
            ]);
            return new Unleash($client);
        });

        $this->app->alias('unleash', Unleash::class);

        $this->mergeConfigFrom($this->getConfigPath(), 'unleash');
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->getConfigPath() => config_path('unleash.php'),
        ]);

        Blade::if('featureEnabled', function (string $feature) {
            return app(Unleash::class)->isFeatureEnabled($feature);
        });

        Blade::if('featureDisabled', function (string $feature) {
            return app(Unleash::class)->isFeatureDisabled($feature);
        });
    }

    /**
     * Get the path to the config.
     *
     * @return string
     */
    private function getConfigPath(): string
    {
        return __DIR__ . '/../../config/unleash.php';
    }
}
