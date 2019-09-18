<?php

namespace App\Providers;

use App\LdapChange;
use App\LdapConnection;
use App\Observers\LdapChangeObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        LdapChange::observe(LdapChangeObserver::class);

        View::composer('layouts.app', function ($view) {
            $view->with(['counts' => [
                'connections' => LdapConnection::count(),
            ]]);
        });

        View::composer('connections.form', function ($view) {
            $view->with(['types' => [
                LdapConnection::TYPE_ACTIVE_DIRECTORY => __('Active Directory'),
                LdapConnection::TYPE_OPEN_LDAP => __('OpenLDAP'),
                LdapConnection::TYPE_UNKNOWN => __('Other'),
            ]]);
        });
    }
}
