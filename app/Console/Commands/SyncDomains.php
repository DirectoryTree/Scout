<?php

namespace App\Console\Commands;

use App\LdapDomain;
use Illuminate\Console\Command;
use App\Jobs\QueueSync;
use Illuminate\Support\Facades\Bus;

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
        $this->info("Starting to synchronize directories...");

        $domains = LdapDomain::all();

        $bar = $this->output->createProgressBar($domains->count());

        $bar->start();

        $domains->each(function (LdapDomain $domain) use ($bar) {
            Bus::dispatch(new QueueSync($domain));

            $bar->advance();
        });

        $bar->finish();

        $this->info("\n");
        $this->table(['Domains Queued'], $domains->map->only('name'));
    }
}
