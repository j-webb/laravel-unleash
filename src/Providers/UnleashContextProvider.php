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

        foreach (config('unleash.context_items') as $contextItem) {
            $contextResolver = app()->make($contextItem['resolver']);
            $resolved = $contextResolver::resolve();

            // If the context item is not resolved, the context is trying to check whether the feature is enabled
            if(is_null($resolved)){
                $resolved = $this->resolveContextId($contextItem['property']);
            }

            if ($contextItem['property'] === 'userId') {
                $context->setCurrentUserId($resolved);
            } else {
                $context->setCustomProperty($contextItem['property'], $resolved);
            }
        }

        return $context;     
    }

    public function resolveContextId($unleashProperty)
    {
        if($unleashProperty === 'userId'){
            return Auth::id();
        }
        return null;
    }


}