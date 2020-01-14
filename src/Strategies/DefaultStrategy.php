<?php

namespace JWebb\Unleash\Strategies;

use JWebb\Unleash\Interfaces\Strategy;

class DefaultStrategy extends AbstractStrategy implements Strategy
{
    public function isEnabled(array $params): bool
    {
        return true;
    }
}
