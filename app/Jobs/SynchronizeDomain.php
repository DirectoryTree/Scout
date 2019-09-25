<?php

namespace App\Jobs;

use Exception;
use App\LdapScan;
use App\LdapDomain;
use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\LdapRecordException;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SynchronizeDomain implements ShouldQueue
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

        $conn = $this->getNewLdapConnection();

        // Bind to the LDAP server if not yet bound.
        if (! $conn->getLdapConnection()->isBound()) {
            $config = $conn->getConfiguration();

            try {
                $conn->connect(
                    decrypt($config->get('username')),
                    decrypt($config->get('password'))
                );

                $synchronized = Bus::dispatch(new ImportObjects($this->domain));

                // Update our scans completion stats.
                $this->scan->fill([
                    'success' => true,
                    'synchronized' => $synchronized,
                    'completed_at' => now(),
                ])->save();

                // Update the domains synchronization status.
                $this->domain->update([
                    'synchronized_at' => now(),
                    'status' => LdapDomain::STATUS_ONLINE,
                ]);
            } catch (Exception $ex) {
                $this->handleException($ex);
            }
        }
    }

    /**
     * Handle the given exception and update the scan record.
     *
     * @param Exception $ex
     */
    protected function handleException(Exception $ex)
    {
        if ($ex instanceof LdapRecordException) {
            $status = Str::contains('credentials', $ex->getMessage()) ?
                LdapDomain::STATUS_INVALID_CREDENTIALS :
                LdapDomain::STATUS_OFFLINE;

            $this->domain->update(['status' => $status]);
        }

        $this->scan->fill([
            'success' => false,
            'message' => $ex->getMessage(),
            'completed_at' => now(),
        ])->save();
    }

    /**
     * Get a new LDAP connection.
     *
     * @return Connection
     */
    protected function getNewLdapConnection()
    {
        $conn = new Connection(
            $this->domain->getConnectionAttributes()
        );

        // Add the connection to the container.
        Container::getInstance()->add($conn, $this->domain->slug);

        return $conn;
    }
}
