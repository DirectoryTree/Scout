<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

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
        if (Cache::get('scout.installed', false)) {
            return $next($request);
        }

        if (File::exists($this->envFilePath())) {
            Cache::forever('scout.installed', true);

            return $next($request);
        } else {
            $this->prepareForInstallation();
        }

        if (request()->is('install')) {
            return $next($request);
        }

        return redirect()->route('install.index');
    }

    /**
     * Prepare the application for installation.
     *
     * @return void
     */
    protected function prepareForInstallation()
    {
        if (!$this->createEnvFile()) {
            abort(500, 'Unable to create application .env file.');
        }

        Artisan::call('key:generate');

        // We need to refresh the page after generating the application key.
        redirect(request()->url());
    }

    /**
     * Create the application .env file.
     *
     * @return bool
     */
    protected function createEnvFile()
    {
        return File::put($this->envFilePath(), File::get($this->envStubFilePath()));
    }

    /**
     * The .env file path.
     *
     * @return string
     */
    protected function envFilePath()
    {
        return base_path('.env');
    }

    /**
     * The .env stub file path.
     *
     * @return string
     */
    protected function envStubFilePath()
    {
        return base_path('.env.example');
    }
}
