### Contextprovider

Example contextprovider usage in FeatureFlagContextProvider.php:

```php
<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Unleash\Client\Configuration\Context;
use Unleash\Client\Configuration\UnleashContext;
use JWebb\Unleash\Providers\UnleashContextProvider as UnleashContextProvider;

class FeatureFlagContextProvider extends UnleashContextProvider
{
    /**
     * @return Context
     */
    public function getContext(): Context
    {
        $context = new UnleashContext();

        // Set context properties for strategies
        if (Auth::guard('admin')->check()) {
            // Set current user
            $context->setCurrentUserId(Auth::guard('admin')->user()->getKey());
            $context->setCustomProperty('partnerId', partner_id());
        }

        return $context;
    }
}
```

Setup in [config](config/unleash.php):

```php
    /*
    |--------------------------------------------------------------------------
    | Context Provider
    |--------------------------------------------------------------------------
    |
    | The provider which handles and initializes the context, giving the option
    | to sent more context, automatically.
    |
    */

    'context_provider' => App\Providers\FeatureFlagContextProvider::class,
```