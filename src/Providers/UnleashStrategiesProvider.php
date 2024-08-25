<?php

namespace JWebb\Unleash\Providers;

use JWebb\Unleash\Interfaces\UnleashStrategiesProviderInterface;
use Unleash\Client\Stickiness\MurmurHashCalculator;
use Unleash\Client\Strategy\AbstractStrategyHandler;
use Unleash\Client\Strategy\ApplicationHostnameStrategyHandler;
use Unleash\Client\Strategy\DefaultStrategyHandler;
use Unleash\Client\Strategy\GradualRolloutStrategyHandler;
use Unleash\Client\Strategy\IpAddressStrategyHandler;
use Unleash\Client\Strategy\UserIdStrategyHandler;

class UnleashStrategiesProvider implements UnleashStrategiesProviderInterface
{
    /**
     * @return array
     */
    public function getStrategies(): array
    {
        $rolloutStrategyHandler = new GradualRolloutStrategyHandler(new MurmurHashCalculator());
        $strategies = [
            new DefaultStrategyHandler(),
            new IpAddressStrategyHandler(),
            new UserIdStrategyHandler(),
            $rolloutStrategyHandler,
            new ApplicationHostnameStrategyHandler(),
        ];

        foreach ($strategies as $k => $strategy) {
            if (! $strategy instanceof AbstractStrategyHandler) {
                unset($strategies[$k]);
            }
        }

        return $strategies;
    }
}