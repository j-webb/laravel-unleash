<?php

namespace JWebb\Unleash\Providers;

use Illuminate\Support\Facades\Auth;
use Unleash\Client\Configuration\Context;
use Unleash\Client\Configuration\UnleashContext;
use Unleash\Client\ContextProvider\UnleashContextProvider as BaseUnleashContextProvider;

class UnleashContextProvider implements BaseUnleashContextProvider
{
    /**
     * @return Context
     */
    public function getContext(): Context
    {
        $context = new UnleashContext();

        if (Auth::check()) {
            $context->setCurrentUserId(Auth::id());
        }
        
        return $context;     
    }
}