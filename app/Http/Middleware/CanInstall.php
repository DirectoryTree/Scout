<?php

namespace App\Http\Middleware;

use Closure;
use App\Installer\Installer;

class CanInstall
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
        /** @var Installer $installer */
        $installer = app(Installer::class);

        if ($installer->installed()) {
            abort(404);
        }

        $installer->prepare();

        if ($installer->wasRecentlyPrepared()) {
            // If the installer was recently prepared, we must refresh the
            // application to ensure the application key is set.
            // Otherwise, we will receive an exception.
            return redirect()->route('install.index');
        }

        return $next($request);
    }
}
