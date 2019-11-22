<?php

namespace App\Providers;

use App\Installer\Installer;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\ServiceProvider;

class InstallationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Installer::class, function () {
            return new Installer(Valuestore::make($this->getInstallerFilePath()));
        });
    }

    /**
     * Get the installer file path.
     *
     * @return string
     */
    public function getInstallerFilePath()
    {
        return storage_path('app/installer');
    }
}
