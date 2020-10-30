<?php

namespace JWebb\Unleash\Entities;

use JWebb\Unleash\Interfaces\Strategy;

class Feature extends AbstractEntity
{
    /**
     * Whether the feature is enabled
     *
     * @var boolean
     */
    public $enabled;

    /**
     * Strategies relevant to this feature
     *
     * @var array
     */
    protected $strategies;

    /**
     * @param bool $enabledOnly - Get feature even if it is disabled
     * @return bool
     * @throws \Exception
     */
    public function isActive($enabledOnly = true): bool
    {
        $isEnabled = $this->enabled;

        if ($enabledOnly && !$isEnabled) {
            return false;
        }

        $activeStrategies = config('unleash.strategies', []);

        foreach ($this->strategies as $featureStrategy) {
            $name = $featureStrategy->name;

            if (!array_key_exists($name, $activeStrategies)) {
                return false;
            }

            $strategy = new $activeStrategies[$name]();

            if (!$strategy instanceof Strategy) {
                throw new \Exception("${$name} does not implement base Strategy.");
            }

            if (!$strategy->isEnabled((array)$featureStrategy->parameters)) {
                return false;
            }
        }

        return $isEnabled;
    }
}
