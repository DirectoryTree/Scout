<?php

namespace App\Console\Commands;

use App\LdapDomain;
use App\Ldap\Connectors\DomainConnector;
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
            rescue(function () use ($domain) {
                DomainConnector::on($domain)->connect();

                $this->info(sprintf("Successfully connected to '%s'", $domain->name));
            }, function () use ($domain) {
                $this->info(sprintf("Unable to connect to '%s'", $domain->name));
            });
        });

        $this->info('Completed pinging configured domains.');
    }
}
