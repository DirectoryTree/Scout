<?php

namespace App\Jobs;

use App\LdapChange;
use App\LdapDomain;
use App\LdapObject;
use LdapRecord\Ldap;
use LdapRecord\Container;
use LdapRecord\Connection;
use Illuminate\Bus\Queueable;
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
     * The global attribute blacklist.
     *
     * @var array
     */
    protected $blacklist = [];

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
        $conn = new Connection(
            $this->domain->getConnectionAttributes(),
            new Ldap($this->domain->name)
        );

        // We'll overwrite each connection. We only need
        //to connect to it during synchronization.
        Container::getInstance()->add($conn);

        if (! $conn->getLdapConnection()->isBound()) {
            $config = $conn->getConfiguration();

            $conn->connect(
                decrypt($config->get('username')),
                decrypt($config->get('password'))
            );
        }

        /** TODO: Implement chunking results to prevent memory issues. */
        Entry::select('*')
            ->paginate(1000)
            ->each(function (Entry $entry) {
                $this->import($entry);
            });
    }

    /**
     * Import the entry into the database.
     *
     * @param Entry $entry
     */
    protected function import(Entry $entry)
    {
        // Retrieve the LDAP entry's attributes and sort them by their key.
        $attributes = $this->filterAttributes($entry);
        ksort($attributes);

        /** @var LdapObject $object */
        $object = LdapObject::firstOrNew(['guid' => $entry->getConvertedGuid()]);

        // Determine any differences from our last sync.
        $modifications = array_diff(
            array_map('serialize', $attributes),
            array_map('serialize', $object->attributes ?? [])
        );

        $object->domain()->associate($this->domain);

        $object->dn = $entry->getDn();
        $object->attributes = $attributes;

        $object->save();

        if (count($modifications) > 0) {
            $change = new LdapChange();

            $change->object()->associate($object);

            $change->fill([
                'before' => $attributes,
                'after' => $object->attributes,
                'attributes' => array_map('unserialize', $modifications),
            ])->save();
        }
    }

    /**
     * Returns the attributes except the blacklisted.
     *
     * @param Entry $entry
     *
     * @return array
     */
    protected function filterAttributes(Entry $entry)
    {
        if (count($this->blacklist) === 0) {
            return $entry->jsonSerialize();
        }

        return array_filter($entry->jsonSerialize(), function ($key) {
            return ! in_array($key, $this->blacklist);
        }, ARRAY_FILTER_USE_KEY);
    }
}
