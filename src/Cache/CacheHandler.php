<?php

namespace JWebb\Unleash\Cache;

use JWebb\Unleash\Interfaces\UnleashCacheHandlerInterface;

class CacheHandler implements UnleashCacheHandlerInterface
{
    /**
     * @return CacheBridge
     */
    public function init(): CacheBridge
    {
        return new CacheBridge();
    }
}