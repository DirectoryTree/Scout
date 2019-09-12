<?php

namespace App\Providers;

use LdapRecord\Container;
use LdapRecord\Connection;
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
        $conn = new Connection([
            'hosts' => explode(',', env('LDAP_HOSTS')),
            'username' => env('LDAP_USERNAME'),
            'password' => env('LDAP_PASSWORD'),
            'base_dn' => env('LDAP_BASE_DN'),
        ]);

        $conn->connect();

        Container::getInstance()->add($conn);
    }
}
