<?php

namespace JWebb\Unleash\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array setClient(Unleash\Client\Unleash $client)
 * @method static bool isEnabled(string $featureName, ?\Unleash\Client\Configuration\Context $context = null, bool $default = false)
 * @method static array getFeatures(bool $onlyEnabled = false, ?\Unleash\Client\Configuration\Context $context = null)
 * @method static \Unleash\Client\DTO\Variant getVariant(string $featureName, ?\Unleash\Client\Configuration\Context $context = null, ?\Unleash\Client\DTO\Variant $fallbackVariant = null)
 * @method static void register()
 * @method static void getRepository()
 */
class Unleash extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \JWebb\Unleash\Unleash::class;
    }
}
