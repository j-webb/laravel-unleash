<?php

namespace JWebb\Unleash\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use JWebb\Unleash\Interfaces\UnleashCacheHandlerInterface;
use JWebb\Unleash\Unleash;
use Unleash\Client\UnleashBuilder;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'unleash');

        $this->app->singleton(Unleash::class, function ($app) {
            $builder = UnleashBuilder::create()
                ->withInstanceId(config('unleash.instance_id'))
                ->withAppUrl(config('unleash.url'))
                ->withAppName(config('unleash.environment')) // Same as `withGitlabEnvironment(...)`
                ->withContextProvider(new UnleashContextProvider());

            if (config('unleash.automatic_registration')) {
                $builder = $builder->withAutomaticRegistrationEnabled(config('unleash.automatic_registration'));
            }
            if (config('unleash.metrics')) {
                $builder = $builder->withMetricsEnabled(config('unleash.metrics'));
            }
            if (config('unleash.cache.enabled')) {
                /** @var UnleashCacheHandlerInterface $cacheHandler */
                $cacheHandler = config('unleash.cache.handler');

                $builder = $builder->withCacheHandler(
                    (new $cacheHandler())->init(),
                    config('unleash.cache.ttl')
                );
            }
            if (config('unleash.api_key')) {
                $builder = $builder->withHeader('Authorization', config('unleash.api_key'));
            }

            return new Unleash($builder->build());
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        if (! config('unleash.enabled')) {
            return;
        }

        $this->publishes([
            $this->getConfigPath() => config_path('unleash.php'),
        ]);

        Blade::if('featureEnabled', function (string $feature) {
            return app(Unleash::class)->isEnabled($feature);
        });

        Blade::if('featureDisabled', function (string $feature) {
            return app(Unleash::class)->isEnabled($feature);
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
