<?php

namespace JWebb\Unleash\Strategies;

use JWebb\Unleash\Interfaces\Strategy;

class DefaultStrategy extends AbstractStrategy implements Strategy
{
    /**
     * @param  array  $params
     * @return bool
     */
    public function isEnabled(array $params): bool
    {
        return true;
    }
}
