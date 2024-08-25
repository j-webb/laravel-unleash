<?php

namespace JWebb\Unleash\Facades;

use Illuminate\Support\Facades\Facade;
use Unleash\Client\Configuration\Context;
use Unleash\Client\DTO\Variant;

/**
 * @method static array setClient(\Unleash\Client\Unleash $client)
 * @method static bool isEnabled(string $featureName, ?Context $context = null, bool $default = false)
 * @method static array getFeatures(bool $onlyEnabled = false, ?Context $context = null)
 * @method static Variant getVariant(string $featureName, ?Context $context = null, ?Variant $fallbackVariant = null)
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
