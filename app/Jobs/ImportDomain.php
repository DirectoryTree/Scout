<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use App\LdapScan;
use App\LdapScanEntry;
use App\Ldap\TypeGuesser;
use LdapRecord\Models\Model;
use App\Ldap\DomainModelFactory;
use App\Ldap\DomainQueryFactory;
use App\Ldap\Connectors\DomainConnector;
use LdapRecord\Models\Types\ActiveDirectory;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportDomain implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The current scan.
     *
     * @var \App\LdapScan|null
     */
    protected $scan;

    /**
     * The guids of the LDAP objects scanned.
     *
     * @var array
     */
    protected $guids = [];

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
     * Import all of the domains objects.
     *
     * @return void
     *
     * @throws Exception
     */
    public function handle()
    {
        $this->scan->update(['started_at' => now()]);

        DomainConnector::on($this->scan->domain)->connect();

        $factory = DomainModelFactory::on($this->scan->domain);

        // We'll initialize a database transaction so all of our
        // inserts and updates are pushed at once. Otherwise
        // each update or insert would be done separately,
        // becoming very resource intensive.
        DB::transaction(function () use ($factory) {
            $this->import($factory->make());
        });

        // Upon successful completion, we'll update our scan
        // stats to ensure it is not processed again.
        $this->scan->fill([
            'success' => true,
            'synchronized' => count($this->guids),
            'completed_at' => now(),
        ])->save();
    }

    /**
     * The job failed to process.
     *
     * @param Exception $ex
     *
     * @return void
     */
    public function failed(Exception $ex)
    {
        $this->scan->fill([
            'success' => false,
            'message' => $ex->getMessage(),
            'completed_at' => now(),
        ])->save();
    }

    /**
     * Import the LDAP objects on the given connection.
     *
     * @param Model              $model
     * @param LdapScanEntry|null $parent
     *
     * @return void
     */
    protected function import(Model $model, LdapScanEntry $parent = null)
    {
        $this->query($model)->each(function (Model $object) use ($model, $parent) {
            $values = $object->jsonSerialize();
            ksort($values);

            $type = $this->getObjectType($object);
            $updated = $this->getObjectUpdatedAt($object);

            /** @var LdapScanEntry $entry */
            $entry = $this->scan->entries()->make();

            $entry->parent()->associate(optional($parent)->id);
            $entry->dn = $object->getDn();
            $entry->name = $object->getName();
            $entry->guid = $object->getConvertedGuid();
            $entry->type = $type;
            $entry->values = $values;
            $entry->ldap_updated_at = $updated;

            $entry->save();

            $this->guids[] = $object->getConvertedGuid();

            // If the object is a container, we will
            // recursively import its descendants.
            if ($type == TypeGuesser::TYPE_CONTAINER) {
                $this->import($object, $entry);
            }
        });
    }

    /**
     * Queries the LDAP directory.
     *
     * @param Model $model
     *
     * @return \LdapRecord\Query\Collection
     */
    protected function query(Model $model)
    {
        $query = (new DomainQueryFactory($this->scan->domain))->make($model);

        if ($model->exists) {
            $query->in($model->getDn());
        }

        return $query->listing()->select('*')->paginate(1000);
    }

    /**
     * Attempt to determine the objects type.
     *
     * @param Model $object
     *
     * @return string|null
     */
    protected function getObjectType(Model $object)
    {
        return (new TypeGuesser($object->getAttribute('objectclass') ?? []))->get();
    }

    /**
     * Attempt to determine the objects update timestamp.
     *
     * @param Model $object
     *
     * @return Carbon
     */
    protected function getObjectUpdatedAt(Model $object)
    {
        $attribute = 'modifytimestamp';

        if ($object instanceof ActiveDirectory) {
            $attribute = 'whenchanged';
        }

        $timestamp = $object->{$attribute};

        // We must set the timezone, as LDAP timestamps are formatted for UTC.
        return $timestamp instanceof Carbon ?
            $timestamp->setTimezone(config('app.timezone')) :
            now();
    }
}
