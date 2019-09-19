<?php

namespace App\Console\Commands;

use App\LdapObject;
use App\LdapChange;
use App\LdapConnection;
use LdapRecord\Ldap;
use LdapRecord\Container;
use LdapRecord\Connection;
use Illuminate\Console\Command;
use LdapRecord\Models\ActiveDirectory\Entry;

class SyncDirectories extends Command
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
    protected $description = 'Synchronizes configured LDAP servers.';

    /**
     * The global attribute blacklist.
     *
     * @var array
     */
    protected $blacklist = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("--- Scout ---");
        $this->info("Starting to synchronize directories...");

        foreach ($this->setupContainer()->all() as $name => $connection)
        {
            if (! $connection->getLdapConnection()->isBound()) {
                $this->info("Connecting to $name...");

                $connection->connect(
                    decrypt($connection->getConfiguration()->get('username')),
                    decrypt($connection->getConfiguration()->get('password'))
                );

                $this->info("Successfully connected to $name.");
            }

            $this->info("Retrieving LDAP objects...");

            /** TODO: Implement chunking results to prevent memory issues. */
            Entry::on($name)
                ->select('*')
                ->paginate(1000)
                ->each(function (Entry $entry) use ($name) {
                    $this->import($entry, $name);
                });
        }
    }

    /**
     * Setup the LDAP connection container.
     *
     * @return Container
     */
    protected function setupContainer()
    {
        $container = Container::getInstance();

        foreach ($this->getConnections() as $connection) {
            $config = $connection->only([
                'username',
                'password',
                'hosts',
                'base_dn',
                'port',
                'use_ssl',
                'use_tls',
                'timeout',
                'follow_referrals'
            ]);

            $container->add(
                new Connection($config, new Ldap($connection->name)),
                $connection->name
            );
        }

        return $container;
    }

    /**
     * Get all the setup LDAP connections.
     *
     * @return LdapConnection[]
     */
    protected function getConnections()
    {
        return LdapConnection::all();
    }

    /**
     * Import the entry into the database.
     *
     * @param Entry  $entry
     * @param string $domain
     */
    protected function import(Entry $entry, $domain)
    {
        $this->info("Synchronizing '{$entry->getDn()}'.");

        // Retrieve the LDAP entry's attributes and sort them by their key.
        $attributes = $this->filterAttributes($entry);
        ksort($attributes);

        $object = LdapObject::firstOrNew(['guid' => $entry->getConvertedGuid()]);

        if ($object->exists) {
            $this->info("Object exists. Synchronizes attributes...");
        } else {
            $this->info("Object does not exist. Importing...");
        }

        // Determine any differences from our last sync.
        $modifications = array_diff(
            array_map('serialize', $attributes),
            array_map('serialize', $object->attributes ?? [])
        );

        $object->dn = $entry->getDn();
        $object->domain = $domain;
        $object->attributes = $attributes;

        $object->save();

        $this->info("Successfully synchronized object.");

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
