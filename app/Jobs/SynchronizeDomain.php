<?php

namespace App\Jobs;

use App\LdapDomain;
use LdapRecord\Ldap;
use LdapRecord\Container;
use LdapRecord\Connection;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LdapRecord\Models\ActiveDirectory\Entry;

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
     * Create a new job instance.
     *
     * @param LdapDomain $domain
     *
     * @return void
     */
    public function __construct(LdapDomain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->domain->slug;

        $conn = new Connection(
            $this->domain->getConnectionAttributes(),
            new Ldap($name)
        );

        // Add the connection to the container.
        Container::getInstance()->add($conn, $name);

        // Bind to the LDAP server if not yet bound.
        if (! $conn->getLdapConnection()->isBound()) {
            $config = $conn->getConfiguration();

            $conn->connect(
                decrypt($config->get('username')),
                decrypt($config->get('password'))
            );
        }

        /** TODO: Implement chunking results to prevent memory issues. */
        Entry::on($name)
            ->select('*')
            ->paginate(1000)
            ->each(function (Entry $entry) {
                Bus::dispatch(new SynchronizeObject($this->domain, $entry));
            });

        $this->domain->update([
            'synchronized_at' => now(),
            'status' => LdapDomain::STATUS_ONLINE,
        ]);
    }
}
