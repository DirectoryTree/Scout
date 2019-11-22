<?php

namespace App\Http\Middleware;

use Closure;
use App\Scout;

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
        if (setting('app.email', false)) {
            return $next($request);
        }

        abort(404);
    }
}
