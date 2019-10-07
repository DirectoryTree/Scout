<?php

namespace App\Providers;

use App\LdapChange;
use App\Observers\LdapChangeObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        LdapChange::observe(LdapChangeObserver::class);
    }
}
