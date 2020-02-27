<?php

namespace JWebb\Unleash\Middleware;

use Closure;
use JWebb\Unleash\Facades\Unleash;

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
        if (!Unleash::feature()->isEnabled($featureName)) {
            abort(404);
        }

        return $next($request);
    }
}
