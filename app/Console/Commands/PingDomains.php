<?php

namespace App\Console\Commands;

use App\LdapDomain;
use App\Ldap\Connectors\DomainHostConnector;
use Illuminate\Console\Command;

class PingDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:ping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ping the configured LDAP domains.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("---- Scout ----");
        $this->info("Starting to ping configured directories...");

        LdapDomain::all()->each(function (LdapDomain $domain) {
            foreach(array_unique($domain->hosts) as $host) {
                $connector = new DomainHostConnector($domain, $host);

                rescue(function () use ($domain, $host, $connector) {
                    $connector->connect();

                    $this->info(sprintf("Successfully connected to '%s' on domain '%s'", $host, $domain->name));
                }, function () use ($domain, $host, $connector)  {
                    $this->info(sprintf("Unable to connect to '%s' on domain '%s'", $host, $domain->name));
                });
            }
        });

        $this->info('Completed pinging configured domains.');
    }
}
