<?php

namespace App\Providers;

use Exception;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            config()->set('app.timezone', setting('app.timezone', env('APP_TIMEZONE')));
        } catch (Exception $ex) {
            // Migrations have not been ran yet.
        }
    }
}
