<?php

namespace App\Jobs;

use App\LdapDomain;
use App\LdapObject;
use LdapRecord\Models\Model;
use Illuminate\Support\Facades\Bus;
use LdapRecord\Models\Entry as UnknownModel;
use LdapRecord\Models\OpenLDAP\Entry as OpenLdapModel;
use LdapRecord\Models\ActiveDirectory\Entry as ActiveDirectoryModel;

class ImportObjects
{
    /**
     * The LDAP domain to import objects upon.
     *
     * @var LdapDomain
     */
    protected $domain;

    /**
     * The number of LDAP objects synchronized.
     *
     * @var int
     */
    protected $synchronized = 0;

    /**
     * Create a new job instance.
     *
     * @param LdapDomain $domain
     */
    public function __construct(LdapDomain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return int
     */
    public function handle()
    {
        $this->import();

        return $this->synchronized;
    }

    /**
     * Import the LDAP objects on the given connection.
     *
     * @param Model|null      $model
     * @param LdapObject|null $parent
     */
    protected function import(Model $model = null, LdapObject $parent = null)
    {
        $this->query($model)->each(function (Model $child) use ($model, $parent) {
            /** @var LdapObject $object */
            $object = Bus::dispatch(new SynchronizeObject($this->domain, $child, $parent));

            $this->synchronized++;

            // If the object is a container, we will import its descendants.
            if ($object->type == 'container') {
                $this->import($child, $object);
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
            $this->getDomainLdapModel();

        if ($filter = $this->domain->filter) {
            $query = $query->rawFilter($filter);
        }

        return $query->listing()
            ->select('*')
            ->paginate(1000);
    }

    /**
     * Get a new LDAP model for the current domains type.
     *
     * @return ActiveDirectoryModel|UnknownModel|OpenLdapModel
     */
    protected function getDomainLdapModel()
    {
        switch($this->domain->type) {
            case LdapDomain::TYPE_ACTIVE_DIRECTORY:
                $model = new ActiveDirectoryModel();
                break;
            case LdapDomain::TYPE_OPEN_LDAP:
                $model = new OpenLdapModel();
                break;
            default:
                $model = new UnknownModel();
                break;
        }

        $model->setConnection($this->domain->slug);

        return $model;
    }
}
