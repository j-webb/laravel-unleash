<?php

namespace JWebb\Unleash\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWebb\Unleash\Unleash;

class CheckFeature
{
    public function handle(Request $request, Closure $next, $featureName): mixed
    {
        if (! app(Unleash::class)->isEnabled($featureName)) {
            abort(404);
        }

        return $next($request);
    }
}
