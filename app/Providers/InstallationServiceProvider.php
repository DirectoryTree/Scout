<?php

namespace App\Providers;

use App\Installer\Installer;
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
            return new Installer();
        });
    }
}
