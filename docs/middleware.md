### Middleware

The module comes bundled with middleware for you to perform a feature check on routes and/or controllers.
```php
#/app/Http/Kernel.php
protected $routeMiddleware = [
    ...
    'feature' => \JWebb\Unleash\Middleware\CheckFeature::class,
    ...
];
```

Once added to your `Kernel.php` file, you can use this in any area where middleware is applicable.
As an example, you could use this in a controller.
```php

public function __construct()
{
    $this->middleware('feature:your_feature_name');
}

```
See the [Laravel Docs](https://laravel.com/docs/middleware) for more information.