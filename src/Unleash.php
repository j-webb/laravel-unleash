<?php

namespace JWebb\Unleash;

use Unleash\Client\Configuration\Context;
use Unleash\Client\DTO\Feature;
use Unleash\Client\DTO\Variant;
use Unleash\Client\Repository\UnleashRepository;
use Unleash\Client\Unleash as UnleashClient;

class Unleash implements UnleashClient
{
    /**
     * @var UnleashClient
     */
    public UnleashClient $client;

    /**
     * Unleash constructor.
     * @param  UnleashClient  $client
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
        try {
            return $this->client->isEnabled($featureName, $context, $default);
        } catch (\Exception $e) {
            return $default;
        }
    }


    /**
     * @param  bool  $onlyEnabled
     * @param  Context|null  $context
     * @return array
     * @throws \ReflectionException
     */
    public function getFeatures(bool $onlyEnabled = false, ?Context $context = null): array
    {
        try {
            $features = $this->getRepository()->getFeatures();

            $mappedFeatures = array_map(function ($item) use ($context) {
                /** @var $item Feature */
                return [
                    'enabled' => $this->isEnabled($item->getName(), $context),
                    'name' => $item->getName(),
                ];
            }, $features);

            $toggles['toggles'] = $onlyEnabled ? array_filter($mappedFeatures, function ($item) {
                return $item['enabled'];
            }) : $mappedFeatures;

            return $toggles;
        } catch (\Exception $e) {
            if (config('app.env') === 'development') {
                // Throw exception
                throw new \Exception('Unleash error: ' . $e->getMessage());
            }
        }
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
