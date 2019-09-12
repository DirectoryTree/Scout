<?php

namespace App\Console\Commands;

use App\LdapChange;
use App\LdapObject;
use LdapRecord\Container;
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (Container::getInstance()->all() as $name => $connection)
        {
            if (! $connection->getLdapConnection()->isBound()) {
                $connection->connect();
            }

            Entry::on($name)
                ->select('*')
                ->paginate(1000)
                ->each(function (Entry $entry) use ($name) {
                    $this->import($entry, $name);
                });
        }
    }

    /**
     * Import the entry into the database.
     *
     * @param Entry  $entry
     * @param string $domain
     */
    protected function import(Entry $entry, $domain)
    {
        // Retrieve the LDAP entry's attributes and sort them by their key.
        $attributes = $this->filterAttributes($entry);
        ksort($attributes);

        $object = LdapObject::firstOrNew(['guid' => $entry->getConvertedGuid()]);

        // Determine any differences from our last sync.
        $results = array_diff(
            array_map('serialize', $attributes),
            array_map('serialize', $object->attributes ?? [])
        );

        $object->dn = $entry->getDn();
        $object->domain = $domain;
        $object->attributes = $attributes;

        $object->save();

        if (count($results) > 0) {
            $change = new LdapChange();

            $change->object()->associate($object);

            $change->fill([
                'before' => $attributes,
                'after' => $object->attributes,
                'attributes' => array_map('unserialize', $results),
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
