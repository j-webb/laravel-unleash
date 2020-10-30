<?php

namespace JWebb\Unleash\Strategies;

use Illuminate\Support\Arr;
use JWebb\Unleash\Interfaces\Strategy;

class UserWithIdStrategy extends AbstractStrategy implements Strategy
{
    /**
     * @param  array  $params
     * @return bool
     */
    public function isEnabled(array $params): bool
    {
        $userIds = explode(',', Arr::get($params, 'userIds', ''));

        if (count($userIds) === 0 || !$user = request()->user()) {
            return false;
        }

        return in_array($user->id, $userIds);
    }
}
