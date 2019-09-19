<?php

namespace App\Providers;

use LdapRecord\Container;
use Illuminate\Support\ServiceProvider;

class LdapConnectionProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Container::setLogger(logger());
    }
}
