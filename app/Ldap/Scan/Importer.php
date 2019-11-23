<?php

namespace App\Ldap\Scan;

use Exception;
use Carbon\Carbon;
use App\LdapDomain;
use App\LdapScanEntry;
use App\Ldap\TypeGuesser;
use LdapRecord\Models\Model;
use Illuminate\Support\Facades\DB;
use LdapRecord\Models\Types\ActiveDirectory;

class Importer
{
    /**
     * The domain to perform scan operations upon.
     *
     * @var LdapDomain
     */
    protected $domain;

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
     * @param LdapDomain $domain
     */
    public function __construct(LdapDomain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Import all of the domains objects.
     *
     * @return int
     */
    public function run()
    {
        $this->initialize();

        try {
            // We'll initialize a database transaction so all of our
            // inserts and updates are pushed at once. Otherwise
            // each update or insert would be done separately,
            // becoming very resource intensive.
            DB::transaction(function () {
                $this->import();
            });

            // Update our scans completion stats.
            $this->scan->fill([
                'success' => true,
                'synchronized' => count($this->guids),
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

        return $this->scan->synchronized ?? 0;
    }

    /**
     * Initializes a new scan.
     *
     * @return void
     */
    protected function initialize()
    {
        $this->scan = $this->domain->scans()->create(['started_at' => now()]);
    }

    /**
     * Import the LDAP objects on the given connection.
     *
     * @param Model|null         $model
     * @param LdapScanEntry|null $parent
     */
    protected function import(Model $model = null, LdapScanEntry $parent = null)
    {
        $this->query($model)->each(function (Model $object) use ($model, $parent) {
            $values = $object->jsonSerialize();
            ksort($values);

            $type = $this->getObjectType($object);
            $updated = $this->getObjectUpdatedAt($object);

            /** @var LdapScanEntry $entry */
            $entry = $this->scan->entries()->create([
                'parent_id' => optional($parent)->id,
                'guid' => $object->getConvertedGuid(),
                'ldap_updated_at' => $updated,
                'name' => $object->getName(),
                'dn' => $object->getDn(),
                'values' => $values,
                'type' => $type,
            ]);

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
     * If an entry is supplied, it will query leaf LDAP entries.
     *
     * @param Model|null $model
     *
     * @return \LdapRecord\Query\Collection
     */
    protected function query(Model $model = null)
    {
        $query = $model ?
            $model->in($model->getDn()) :
            $this->domain->getLdapModel();

        if ($filter = $this->domain->filter) {
            $query = $query->rawFilter($filter);
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
        return (new TypeGuesser($object->getAttribute('objectclass')))->get();
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
