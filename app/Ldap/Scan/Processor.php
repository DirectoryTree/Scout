<?php

namespace App\Ldap\Scan;

use App\LdapScan;
use App\LdapObject;
use App\LdapScanEntry;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\LazyCollection;

class Processor
{
    /**
     * The LDAP scan being processed.
     *
     * @var LdapScan
     */
    protected $scan;

    /**
     * The pipes to run through the pipeline.
     *
     * @var array
     */
    protected $pipes = [
        Pipes\RestoreModelWhenTrashed::class,
        Pipes\AssociateDomain::class,
        Pipes\AssociateParent::class,
        Pipes\DetectChanges::class,
        Pipes\HydrateProperties::class,
    ];

    /**
     * Constructor.
     *
     * @param LdapScan $scan
     */
    public function __construct(LdapScan $scan)
    {
        $this->scan = $scan;
    }

    /**
     * Process the scan.
     *
     * @return void
     */
    public function run()
    {
        $query = $this->scan->rootEntries();

        $this->synchronize($query->cursor());

        // Mark the entries as processed.
        $query->update(['processed' => true]);
    }

    /**
     * Synchronize the entries.
     *
     * @param LazyCollection $entries
     *
     * @param $domainId
     */
    protected function synchronize(LazyCollection $entries)
    {
        $entries->each(function (LdapScanEntry $entry) {
            /** @var LdapObject $object */
            $object = LdapObject::withTrashed()->firstOrNew(['guid' => $entry->guid]);

            $pipes = collect($this->pipes)->transform(function ($pipe) use ($entry) {
                return new $pipe($this->scan, $entry);
            })->toArray();

            app(Pipeline::class)
                ->send($object)
                ->through($pipes)
                ->then(function (LdapObject $object) {
                    $object->save();
                });

            $children = $entry->children()->cursor();

            if ($children->isNotEmpty()) {
                $this->synchronize($children);
            }
        });
    }
}
