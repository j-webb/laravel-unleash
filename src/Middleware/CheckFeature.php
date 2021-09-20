<?php

namespace JWebb\Unleash\Middleware;

use Closure;
use JWebb\Unleash\Unleash;

class CheckFeature
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $featureName
     * @return mixed
     */
    public function handle($request, Closure $next, $featureName)
    {
        if (!app(Unleash::class)->isEnabled($featureName)) {
            abort(404);
        }

        return $next($request);
    }
}
