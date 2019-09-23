<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\LdapDomain;
use App\LdapObject;
use App\Ldap\TypeGuesser;
use LdapRecord\Utilities;
use LdapRecord\Models\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Bus;
use LdapRecord\Models\Types\ActiveDirectory;

class SynchronizeObject
{
    /**
     * The global attribute blacklist.
     *
     * @var array
     */
    protected $blacklist = [];

    /**
     * The domain the entry is being imported from.
     *
     * @var LdapDomain
     */
    protected $domain;

    /**
     * The LDAP object being imported.
     *
     * @var Model
     */
    protected $model;

    /**
     * The parent LDAP object.
     *
     * @var LdapObject|null
     */
    protected $parent;

    /**
     * Create a new job instance.
     *
     * @param LdapDomain      $domain
     * @param Model           $model
     * @param LdapObject|null $parent
     */
    public function __construct(LdapDomain $domain, Model $model, LdapObject $parent = null)
    {
        $this->domain = $domain;
        $this->model = $model;
        $this->parent = $parent;
    }

    /**
     * Execute the job.
     *
     * @return LdapObject
     */
    public function handle()
    {
        // Retrieve the LDAP entry's attributes and sort them by their key.
        $newAttributes = $this->getFilteredAttributes();
        ksort($newAttributes);

        /** @var LdapObject $object */
        $object = LdapObject::firstOrNew(['guid' => $this->getObjectGuid()]);

        $oldAttributes = $object->attributes ?? [];

        // Determine any differences from our last sync.
        $modifications = array_diff(
            array_map('serialize', $newAttributes),
            array_map('serialize', $oldAttributes)
        );

        $object->domain()->associate($this->domain);

        if ($this->parent) {
            $object->parent()->associate($this->parent);
        } else {
            $object->parent()->dissociate();
        }

        $object->name = $this->getObjectName();
        $object->dn = $this->getObjectDn();
        $object->type = $this->getObjectType();
        $object->attributes = $newAttributes;

        $object->save();

        // We don't want to create changes for newly imported objects.
        if (!$object->wasRecentlyCreated && count($modifications) > 0) {
            $when = $this->getObjectUpdatedDate();

            Bus::dispatch(new GenerateObjectChanges($object, $when, $modifications, $oldAttributes));
        }

        return $object;
    }

    /**
     * Returns the objects GUID.
     *
     * @return string|null
     */
    protected function getObjectGuid()
    {
        return $this->model->getConvertedGuid();
    }

    /**
     * Returns the objects distinguished named.
     *
     * @return string|null
     */
    protected function getObjectDn()
    {
        return $this->model->getDn();
    }

    /**
     * Get the LDAP objects name.
     *
     * @return mixed
     */
    protected function getObjectName()
    {
        $parts = Utilities::explodeDn($this->model->getDn(), true);

        return Arr::first(Arr::except($parts, 'count'));
    }

    /**
     * Get the LDAP objects modified date.
     *
     * @return Carbon
     */
    protected function getObjectUpdatedDate()
    {
        $attribute = 'modifytimestamp';

        if ($this->model instanceof ActiveDirectory) {
            $attribute = 'whenchanged';
        }

        $timestamp = $this->model->{$attribute};

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
        return (new TypeGuesser($this->model->objectclass ?? []))->get();
    }

    /**
     * Returns the attributes except the blacklisted.
     *
     * @return array
     */
    protected function getFilteredAttributes()
    {
        if (count($this->blacklist) === 0) {
            return $this->model->jsonSerialize();
        }

        return array_filter($this->model->jsonSerialize(), function ($key) {
            return ! in_array($key, $this->blacklist);
        }, ARRAY_FILTER_USE_KEY);
    }
}
