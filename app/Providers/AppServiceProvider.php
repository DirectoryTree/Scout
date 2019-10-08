<?php

namespace App\Providers;

use App\LdapObject;
use App\Observers\LdapObjectObserver;
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
       LdapObject::observe(LdapObjectObserver::class);
    }
}
