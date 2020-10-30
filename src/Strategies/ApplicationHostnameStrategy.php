<?php

namespace JWebb\Unleash\Strategies;

use Illuminate\Support\Arr;
use JWebb\Unleash\Interfaces\Strategy;

class ApplicationHostnameStrategy extends AbstractStrategy implements Strategy
{
    /**
     * @param  array  $params
     * @return bool
     */
    public function isEnabled(array $params): bool
    {
        $hostNamesString = Arr::get($params, 'hostNames', '');

        $hostNames = explode(',', $hostNamesString);
        return $hostNamesString && in_array(request()->getHost(), $hostNames);
    }
}
