<?php

namespace App\Http\Middleware;

use App\Scout;
use Closure;

class EmailEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Scout::email()->enabled()) {
            return $next($request);
        }

        abort(404);
    }
}
