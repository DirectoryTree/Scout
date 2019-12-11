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

            config()->set([
                'mail.driver' => setting('app.email.driver'),
                'mail.host' => setting('app.email.host'),
                'mail.port' => setting('app.email.port'),
                'mail.encryption' => setting('app.email.encryption'),
                'mail.username' => setting('app.email.username'),
                'mail.password' => setting('app.email.password'),
                'mail.from' => [
                    'address' => setting('app.email.from.address'),
                    'name' => setting('app.email.from.name'),
                ],
            ]);
        } catch (Exception $ex) {
            // Migrations have not been ran yet.
        }
    }
}
