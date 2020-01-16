<?php

namespace JWebb\Unleash\Entities\Api;

use JWebb\Unleash\Entities\Feature as FeatureEntity;
use JWebb\Unleash\Interfaces\Api\Feature as FeatureInterface;

class Feature extends AbstractApi implements FeatureInterface
{
    /**
     * The class of the entity we are working with
     *
     * @var FeatureEntity
     */
    protected $class = FeatureEntity::class;

    /**
     * The API endpoint for the entity
     *
     * @var string
     */
    protected $endpoint = "/api/client";

    /**
     * The API entity name
     *
     * @var string
     */
    protected $entityName = "features";


    /**
     * Get all of the Features from the API resource.
     *
     * @return mixed
     * @throws \Exception
     */
    public function all()
    {
        if (config('unleash.cache.enabled')) {
            return cache()->remember('unleash.features', config('unleash.cache.ttl'), function () {
                return parent::all();
            });
        }

        return parent::all();
    }

    /**
     * Get all of the Entities for the API resource, but only return the ones that are enabled
     *
     * @return array
     * @throws \Exception
     */
    public function getEnabled(): array
    {
        $features = $this->all();

        $enabledFeatures = collect($features)->filter(function ($feature) {
                return $feature->enabled;
            })
            ->toArray();

        return $enabledFeatures;
    }

    /**
     * Get all of the Entities for the API resource, but only return the ones that are active
     *
     * @param bool $enabledOnly - Get feature even if it is disabled
     * @return array
     * @throws \Exception
     */
    public function getActive(bool $enabledOnly = true): array
    {
        $features = $this->all();

        $activeFeatures = collect($features)->filter(function ($feature) use($enabledOnly) {
                return $feature->isActive($enabledOnly);
            })
            ->toArray();

        return $activeFeatures;
    }

    /**
     * Check if named feature is enabled
     *
     * @param string $name
     * @return bool
     * @throws \Exception
     */
    public function isEnabled(string $name): bool
    {
        $features = $this->getEnabled();

        return collect($features)->contains('name', $name);
    }

    /**
     * Check if named feature is active
     *
     * @param string $name
     * @param bool $enabledOnly - Get feature even if it is disabled
     * @return bool
     * @throws \Exception
     */
    public function isActive(string $name, bool $enabledOnly = true): bool
    {
        $features = $this->getActive($enabledOnly);

        return collect($features)->contains('name', $name);
    }
}