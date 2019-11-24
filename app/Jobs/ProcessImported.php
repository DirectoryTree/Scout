<?php

namespace App\Jobs;

use App\LdapScan;
use App\LdapObject;
use App\LdapScanEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessImported implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Process the imported scan entries.
     *
     * @return void
     */
    public function handle()
    {
        $this->process($this->scan->rootEntries());
    }

    /**
     * Synchronize the entries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    protected function process($query)
    {
        $query->cursor()->each(function (LdapScanEntry $entry) {
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

            $this->process($entry->children());
        });

        // Mark the entries as processed.
        $query->update(['processed' => true]);
    }
}
