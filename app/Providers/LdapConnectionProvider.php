<?php

namespace App\Providers;

use Exception;
use App\LdapDomain;
use LdapRecord\Container;
use LdapRecord\Connection;
use Illuminate\Support\ServiceProvider;

class LdapConnectionProvider extends ServiceProvider
{
    /**
     * Bootstrap LDAP services.
     *
     * @return void
     */
    public function boot()
    {
        Container::setLogger(logger());

        try {
            // Here we will create each domain connection so it can be easily
            // retrieved throughout the lifecycle of the application.
            LdapDomain::all()->each(function (LdapDomain $domain) {
                Container::addConnection(
                    new Connection($domain->getLdapConnectionAttributes()),
                    $domain->getLdapConnectionName()
                );
            });
        } catch (Exception $e) {
            // Migrations haven't been ran yet.
        }
    }
}
