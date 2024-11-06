<?php

namespace JWebb\Unleash\Cache;

use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\CacheInterface;

/**
 * Thanks to leo108 for the `SimpleCacheBridge.php` gist
 * https://gist.github.com/leo108/bd7559654c52000cc9774a80b072c629
 */
class CacheBridge implements CacheInterface
{
    /**
     * @param $key
     * @param  null  $default
     * @return mixed
     */
    public function get($key, $default = null) // Mixed not php 7.4 safe
    {
        return Cache::get($key, $default);
    }

    /**
     * @param $key
     * @param $value
     * @param  null  $ttl
     * @return bool
     */
    public function set($key, $value, $ttl = null): bool
    {
        Cache::put($key, $value, $ttl);

        return true;
    }

    /**
     * @param $key
     * @return bool
     */
    public function delete($key): bool
    {
        return Cache::forget($key);
    }

    /**
     * @return bool
     */
    public function clear(): bool
    {
        return Cache::flush();
    }

    /**
     * @param array $keys
     * @param  null  $default
     * @return array
     */
    public function getMultiple($keys, $default = null): array
    {
        return Cache::many($keys);
    }

    /**
     * @param array $values
     * @param  null  $ttl
     * @return bool
     */
    public function setMultiple($values, $ttl = null): bool
    {
        Cache::putMany($values, $ttl);

        return true;
    }

    /**
     * @param array $keys
     */
    public function deleteMultiple($keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return Cache::has($key);
    }
}
