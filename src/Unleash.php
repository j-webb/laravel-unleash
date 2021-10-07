<?php

namespace JWebb\Unleash;

use Unleash\Client\Configuration\Context;
use Unleash\Client\DTO\Feature;
use Unleash\Client\DTO\Variant;
use Unleash\Client\Repository\UnleashRepository;
use Unleash\Client\Unleash as UnleashClient;
use Unleash\Client\Unleash as UnleashImplemtation;

class Unleash implements UnleashImplemtation
{
    /**
     * @var UnleashImplemtation
     */
    public UnleashClient $client;

    /**
     * Unleash constructor.
     * @param  UnleashImplemtation  $client
     */
    public function __construct(UnleashClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    /**
     * @param  string  $featureName
     * @param  Context|null  $context
     * @param  bool  $default
     * @return bool
     */
    public function isEnabled(string $featureName, ?Context $context = null, bool $default = false): bool
    {
        return $this->client->isEnabled($featureName, $context, $default);
    }

    /**
     * @param  bool  $onlyEnabled
     * @param  Context|null  $context
     * @return array
     * @throws \ReflectionException
     */
    public function getFeatures(bool $onlyEnabled = false, ?Context $context = null): array
    {
        $features = $this->getRepository()->getFeatures();

        $allFeatures = array_map(fn (Feature $f) => $this->isEnabled($f->getName(), $context), $features);

        return $onlyEnabled ?
            array_filter($allFeatures, fn ($f) => !!$f) :
            $allFeatures;
    }

    /**
     * @param  string  $featureName
     * @param  Context|null  $context
     * @param  Variant|null  $fallbackVariant
     * @return Variant
     */
    public function getVariant(string $featureName, ?Context $context = null, ?Variant $fallbackVariant = null): Variant
    {
        return $this->client->getVariant($featureName, $context, $fallbackVariant);
    }

    /**
     * @return bool
     */
    public function register(): bool
    {
        return $this->client->register();
    }

    /**
     * @throws \ReflectionException
     */
    protected function getRepository(): UnleashRepository
    {
        $reflectionProperty = new \ReflectionProperty(get_class($this->client), 'repository');
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue($this->client);
    }
}