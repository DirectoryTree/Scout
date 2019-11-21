<?php

namespace App\Jobs;

use Exception;
use App\LdapScan;
use App\LdapDomain;
use Illuminate\Bus\Queueable;
use App\Actions\ImportDomainAction;
use Illuminate\Queue\SerializesModels;
use App\Ldap\Connectors\DomainConnector;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncDomain implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The LDAP domain.
     *
     * @var LdapDomain
     */
    protected $domain;

    /**
     * The current LDAP scan record.
     *
     * @var LdapScan
     */
    protected $scan;

    /**
     * Create a new job instance.
     *
     * @param LdapDomain $domain
     * @param LdapScan   $scan
     *
     * @return void
     */
    public function __construct(LdapDomain $domain, LdapScan $scan)
    {
        $this->domain = $domain;
        $this->scan = $scan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Set the scan start time.
        $this->scan->fill(['started_at' => now()])->save();

        $connector = app(DomainConnector::class, ['domain' => $this->domain]);

        try {
            $connector->connect();

            /** @var ImportDomainAction $action */
            $action = app(ImportDomainAction::class, ['domain' => $this->domain]);

            $synchronized = $action->execute();

            // Update our scans completion stats.
            $this->scan->fill([
                'success' => true,
                'synchronized' => $synchronized ?? 0,
                'completed_at' => now(),
            ])->save();
        } catch (Exception $ex) {
            report($ex);

            $this->scan->fill([
                'success' => false,
                'message' => $ex->getMessage(),
                'completed_at' => now(),
            ])->save();
        }
    }
}
