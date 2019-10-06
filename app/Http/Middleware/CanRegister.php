<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class CanRegister
{
    /**
     * Handle an incoming request.
     *
     * Determines whether the user can register an admin account.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (User::exists()) {
            return abort(404);
        }

        return $next($request);
    }
}
