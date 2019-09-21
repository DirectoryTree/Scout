<?php

namespace App\Jobs;

use App\LdapDomain;
use App\LdapObject;
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

        // Run the import on the given connection.
        $this->import($name);

        // Update the domains synchronization status.
        $this->domain->update([
            'synchronized_at' => now(),
            'status' => LdapDomain::STATUS_ONLINE,
        ]);
    }

    /**
     * Import the LDAP objects on the given connection.
     *
     * @param string          $connection
     * @param Entry|null      $entry
     * @param LdapObject|null $parent
     */
    protected function import($connection, Entry $entry = null, LdapObject $parent = null)
    {
        $this->query($connection, $entry)->each(function (Entry $child) use ($connection, $entry, $parent) {
            /** @var LdapObject $object */
            $object = Bus::dispatch(new SynchronizeObject($this->domain, $child, $parent));

            // If the object is a container, we will import its descendants.
            if ($object->type == 'container') {
                $this->import($connection, $child, $object);
            }
        });
    }

    /**
     * Queries the LDAP directory.
     *
     * If an entry is supplied, it will query leaf LDAP entries.
     *
     * @param string     $connection
     * @param Entry|null $entry
     *
     * @return \LdapRecord\Query\Collection
     */
    protected function query($connection, Entry $entry = null)
    {
        $query = $entry ? $entry->in($entry->getDn()) : Entry::on($connection);

        return $query->listing()
            ->select('*')
            ->paginate(1000);
    }
}
