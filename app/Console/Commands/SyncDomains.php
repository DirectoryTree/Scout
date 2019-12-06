<?php

namespace App\Console\Commands;

use App\LdapDomain;
use App\Jobs\ScanDomain;
use Illuminate\Console\Command;

class SyncDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronizes configured LDAP domains.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("---- Scout ----");
        $this->info("Starting to queue domain synchronization...");

        $domains = LdapDomain::toSynchronize();

        if ($domains->isEmpty()) {
            return $this->info('No domains are scheduled to be synchronized.');
        }

        $bar = $this->output->createProgressBar($domains->count());

        $bar->start();

        $domains->each(function (LdapDomain $domain) use ($bar) {
            ScanDomain::dispatch($domain);

            $bar->advance();
        });

        $bar->finish();

        $this->info("\n");
        $this->table(['Domains Queued'], $domains->map->only('name'));
    }
}
