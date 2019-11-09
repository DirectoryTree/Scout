<?php

namespace App\Ldap;

use Carbon\Carbon;
use App\LdapDomain;
use App\LdapObject;
use LdapRecord\Utilities;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Bus;
use App\Jobs\GenerateObjectChanges;
use LdapRecord\Models\Model as LdapModel;
use LdapRecord\Models\Types\ActiveDirectory;
use Illuminate\Database\Eloquent\Model as DatabaseModel;

class ObjectImporter
{
    /**
     * The LDAP domain that the object belongs to.
     *
     * @var LdapDomain
     */
    protected $domain;

    /**
     * The LDAP object to import.
     *
     * @var LdapModel
     */
    protected $object;

    /**
     * Constructor.
     *
     * @param LdapDomain $domain
     * @param LdapModel  $object
     */
    public function __construct(LdapDomain $domain, LdapModel $object)
    {
        $this->domain = $domain;
        $this->object = $object;
    }

    /**
     * Import / synchronize the object into the database.
     *
     * @param DatabaseModel|null $parent
     *
     * @return LdapObject
     */
    public function run(DatabaseModel $parent = null)
    {
        $model = $this->firstOrNewModelByGuid($this->getObjectGuid());

        // If the object has been deleted but the relating
        // LDAP object exists, we must restore it.
        if ($model->trashed()) {
            $model->restore();
        }

        $newAttributes = $this->object->jsonSerialize();
        ksort($newAttributes);

        $oldAttributes = $model->values ?? [];

        // Determine any differences from our last sync.
        $modifications = array_diff(
            array_map('serialize', $newAttributes),
            array_map('serialize', $oldAttributes)
        );

        $model->domain()->associate($this->domain);

        if ($parent) {
            $model->parent()->associate($parent);
        } else {
            $model->parent()->dissociate();
        }

        $model->name = $this->getObjectName();
        $model->dn = $this->getObjectDn();
        $model->type = $this->getObjectType();
        $model->values = $newAttributes;

        $model->save();

        // We don't want to create changes for newly imported objects.
        if (!$model->wasRecentlyCreated && count($modifications) > 0) {
            $when = $this->getObjectUpdatedDate();

            Bus::dispatch(new GenerateObjectChanges($model, $when, $modifications, $oldAttributes));
        }

        return $model;
    }

    /**
     * Returns the objects GUID.
     *
     * @return string|null
     */
    protected function getObjectGuid()
    {
        return $this->object->getConvertedGuid();
    }

    /**
     * Returns the objects distinguished named.
     *
     * @return string|null
     */
    protected function getObjectDn()
    {
        return $this->object->getDn();
    }

    /**
     * Get the LDAP objects name.
     *
     * @return mixed
     */
    protected function getObjectName()
    {
        $parts = Utilities::explodeDn($this->object->getRdn(), true);

        return Arr::first($parts);
    }

    /**
     * Get the LDAP objects modified date.
     *
     * @return Carbon
     */
    protected function getObjectUpdatedDate()
    {
        $attribute = 'modifytimestamp';

        if ($this->object instanceof ActiveDirectory) {
            $attribute = 'whenchanged';
        }

        $timestamp = $this->object->{$attribute};

        return $timestamp instanceof Carbon ?
            $timestamp->setTimezone(config('app.timezone')) :
            now();
    }

    /**
     * Get the LDAP objects type.
     *
     * @var string
     */
    protected function getObjectType()
    {
        return (new TypeGuesser($this->object->objectclass ?? []))->get();
    }

    /**
     * Get the first matching model by its guid, or a new instance.
     *
     * @param string $guid
     *
     * @return LdapObject
     */
    protected function firstOrNewModelByGuid($guid)
    {
        return $this->getNewModel()->withTrashed()->firstOrNew(['guid' => $guid]);
    }

    /**
     * Get a new model for importing.
     *
     * @return LdapObject
     */
    protected function getNewModel()
    {
        return new LdapObject();
    }
}
