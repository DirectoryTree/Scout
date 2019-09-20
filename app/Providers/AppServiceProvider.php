<?php

namespace App\Providers;

use App\LdapChange;
use App\LdapDomain;
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
                'domains' => LdapDomain::count(),
            ]]);
        });

        View::composer('domains.form', function ($view) {
            $view->with(['types' => [
                LdapDomain::TYPE_ACTIVE_DIRECTORY => __('Active Directory'),
                LdapDomain::TYPE_OPEN_LDAP => __('OpenLDAP'),
                LdapDomain::TYPE_UNKNOWN => __('Other'),
            ]]);
        });
    }
}
