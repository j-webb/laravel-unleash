<?php

namespace JWebb\Unleash\Providers;

use GuzzleHttp\Client;
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
            $strategyProvider = config('unleash.strategy_provider');
            $contextProvider = config('unleash.context_provider');

            $builder = UnleashBuilder::create()
                ->withInstanceId(config('unleash.instance_id'))
                ->withAppUrl(config('unleash.url'))
                ->withAppName(config('unleash.environment')) // Same as `withGitlabEnvironment(...)`
                ->withContextProvider(new $contextProvider())
                ->withStrategies(...(new $strategyProvider())->getStrategies())
                ->withAutomaticRegistrationEnabled(!! config('unleash.automatic_registration'))
                ->withMetricsEnabled(!! config('unleash.metrics'));

            if (!! config('unleash.http_client_override.enabled')) {
                $builder = $builder->withHttpClient(new Client(config('unleash.http_client_override.config')));
            }

            if (!! config('unleash.cache.enabled')) {
                /** @var UnleashCacheHandlerInterface $cacheHandler */
                $cacheHandler = config('unleash.cache.handler');

                $builder = $builder->withCacheHandler(
                    (new $cacheHandler())->init(),
                    config('unleash.cache.ttl')
                );
            }
            if (!! config('unleash.api_key')) {
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
