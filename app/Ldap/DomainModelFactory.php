<?php

namespace App\Ldap;

use App\LdapDomain;
use LdapRecord\Models\Model;
use LdapRecord\Models\Entry as UnknownModel;
use LdapRecord\Models\OpenLDAP\Entry as OpenLdapModel;
use LdapRecord\Models\ActiveDirectory\Entry as ActiveDirectoryModel;

class DomainModelFactory
{
    /**
     * The LDAP domain.
     *
     * @var LdapDomain
     */
    protected $domain;

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
     * Create a new model factory.
     *
     * @param LdapDomain $domain
     *
     * @return static
     */
    public static function on(LdapDomain $domain)
    {
        return new static($domain);
    }

    /**
     * Create a new model for the given type and connection.
     *
     * @return ActiveDirectoryModel|UnknownModel|OpenLdapModel
     */
    public function make()
    {
        return tap($this->create(), function (Model $model) {
            $model->setConnection($this->domain->getLdapConnectionName());
        });
    }

    /**
     * Create a new model for the given type.
     *
     * @return ActiveDirectoryModel|UnknownModel|OpenLdapModel
     */
    protected function create()
    {
        switch($this->domain->type) {
            case LdapDomain::TYPE_ACTIVE_DIRECTORY:
            case LdapDomain::TYPE_ACTIVE_DIRECTORY_LDS:
                return new ActiveDirectoryModel();
            case LdapDomain::TYPE_OPEN_LDAP:
                return new OpenLdapModel();
            default:
                return new UnknownModel();
        }
    }
}
