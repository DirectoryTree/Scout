<?php

namespace App\Http\Middleware;

use Closure;
use App\Installer\Installer;

class IsInstalled
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
        $visitingInstallPage = $request->routeIs('install.*');

        /** @var \App\Installer\Installer $installer */
        $installer = app(Installer::class);

        if ($installer->installed()) {
            if (!$installer->migrated()) {
                if (
                    $request->routeIs('install.migrate') ||
                    $request->routeIs('install.migrations')
                ) {
                    return $next($request);
                }

                // We must enforce users to run migrations if they have not done so yet.
                return redirect()->route('install.migrations');
            }

            // If the application is installed and the user is
            // trying to visit the installation page, we
            // will redirect them to the home URL.
            if ($visitingInstallPage) {
                return redirect()->to('/');
            }

            return $next($request);
        }

        $installer->prepare();

        if ($installer->wasRecentlyPrepared()) {
            // If the installer was recently prepared, we must refresh the
            // application to ensure the application key is set.
            // Otherwise, we will receive an exception.
            return redirect()->route('install.index');
        }

        if ($visitingInstallPage) {
            return $next($request);
        }

        // We need to ensure users are always redirected to the
        // install page, regardless of which route they hit.
        return redirect()->route('install.index');
    }
}
