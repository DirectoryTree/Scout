<?php

namespace App\Jobs;

use App\LdapScan;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteMissingObjects implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The LDAP scan to process.
     *
     * @var LdapScan
     */
    protected $scan;

    /**
     * Create a new job instance.
     *
     * @param LdapScan $scan
     *
     * @return void
     */
    public function __construct(LdapScan $scan)
    {
        $this->scan = $scan;
    }

    /**
     * Soft-delete all LDAP objects that were missing from the scan.
     *
     * @return void
     */
    public function handle()
    {
        $guids = $this->scan->entries()->pluck('guid');

        $this->scan->domain->objects()
            ->whereNotIn('guid', $guids)
            ->delete();
    }
}
