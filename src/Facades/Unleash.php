<?php

namespace JWebb\Unleash\Facades;

use Illuminate\Support\Facades\Facade;

class Unleash extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'JWebb\Unleash\Unleash';
    }
}
