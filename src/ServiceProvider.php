<?php

namespace JWebb\Unleash;

use GuzzleHttp\Client;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use JWebb\Unleash\Interfaces\UnleashCacheHandlerInterface;
use Unleash\Client\UnleashBuilder;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->bootConfig();
        $this->bootBladeDirectives();
    }

    public function register(): void
    {
        $this->app->singleton(Unleash::class, function (Container $app) {
            $strategyProvider = $app->config->get('unleash.strategy_provider');
            $contextProvider = $app->config->get('unleash.context_provider');

            $builder = UnleashBuilder::create()
                ->withInstanceId($app->config->get('unleash.instance_id'))
                ->withAppUrl($app->config->get('unleash.url'))
                ->withAppName($app->config->get('unleash.environment')) // Same as `withGitlabEnvironment(...)`
                ->withContextProvider(new $contextProvider())
                ->withStrategies(...(new $strategyProvider())->getStrategies())
                ->withAutomaticRegistrationEnabled(!! $app->config->get('unleash.automatic_registration'))
                ->withMetricsEnabled(!! $app->config->get('unleash.metrics'));

            if (!! $app->config->get('unleash.http_client_override.enabled')) {
                $builder = $builder->withHttpClient(new Client($app->config->get('unleash.http_client_override.config')));
            }

            if (!! $app->config->get('unleash.cache.enabled')) {
                /** @var UnleashCacheHandlerInterface $cacheHandler */
                $cacheHandler = $app->config->get('unleash.cache.handler');

                $builder = $builder->withCacheHandler(
                    (new $cacheHandler())->init(),
                    $app->config->get('unleash.cache.ttl')
                );
            }
            if (!! $app->config->get('unleash.api_key')) {
                $builder = $builder->withHeader('Authorization', $app->config->get('unleash.api_key'));
            }

            return new Unleash($builder->build());
        });
    }

    private function bootConfig(): void
    {
        $source = realpath($raw = __DIR__.'/../config/unleash.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => $this->app->configPath('unleash.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('unleash');
        }

        $this->mergeConfigFrom($source, 'unleash');
    }

    /**
     * @throws BindingResolutionException
     */
    private function bootBladeDirectives(): void
    {
        $unleash = $this->app->make(Unleash::class);

        Blade::if('feature', function ($featureName, $context = null, $default = false) use ($unleash) {
            return $unleash->isEnabled($featureName, $context, $default);
        });

        Blade::if('featureEnabled', function (string $feature) use ($unleash) {
            return $this->app->make(Unleash::class)->isEnabled($feature);
        });

        Blade::if('featureDisabled', function (string $feature) use ($unleash) {
            return $this->app->make(Unleash::class)->isEnabled($feature) === false;
        });
    }
}
