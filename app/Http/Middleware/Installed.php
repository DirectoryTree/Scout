<?php

namespace App\Http\Middleware;

use Closure;
use App\Installer\Installer;

class Installed
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var \App\Installer\Installer $installer */
        $installer = app(Installer::class);

        if ($installer->installed()) {
            return $next($request);
        }

        if ($request->routeIs('install.*')) {
            $installer->prepare();

            return $next($request);
        }

        // We need to ensure users are always redirected to the
        // install page, regardless of which route they hit.
        return redirect()->route('install.index');
    }
}
