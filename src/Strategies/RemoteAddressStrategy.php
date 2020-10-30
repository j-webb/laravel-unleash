<?php

namespace JWebb\Unleash\Strategies;

use Illuminate\Support\Arr;
use JWebb\Unleash\Interfaces\Strategy;

class RemoteAddressStrategy extends AbstractStrategy implements Strategy
{
    /**
     * @param  array  $params
     * @return bool
     */
    public function isEnabled(array $params): bool
    {
        $remoteAddressesString = Arr::get($params, 'IPs', '');

        if (!$remoteAddressesString) {
            return false;
        }

        $remoteAddresses = explode(',', $remoteAddressesString);

        return in_array(request()->ip(), $remoteAddresses);
    }
}
