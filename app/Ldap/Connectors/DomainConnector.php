<?php

namespace App\Ldap\Connectors;

use Exception;
use App\LdapDomain;
use LdapRecord\Container;
use LdapRecord\Connection;
use Illuminate\Support\Str;

class DomainConnector extends Connector
{
    /**
     * The LDAP domain to connect to.
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
     * {@inheritDoc}
     */
    public function attempt(Connection $connection)
    {
        $config = $connection->getConfiguration();

        $connection->connect(
            decrypt($config->get('username')),
            decrypt($config->get('password'))
        );
    }

    /**
     * {@inheritDoc}
     */
    public function connected()
    {
        // Update the domains connection status.
        $this->domain->update([
            'attempted_at' => now(),
            'status' => LdapDomain::STATUS_ONLINE,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function failed(Exception $ex)
    {
        // Determine if the error is due to invalid credentials.
        $status = Str::contains('credentials', $ex->getMessage()) ?
            LdapDomain::STATUS_INVALID_CREDENTIALS :
            LdapDomain::STATUS_OFFLINE;

        $this->domain->update([
            'attempted_at' => now(),
            'status' => $status,
        ]);

        // Rethrow the exception.
        throw $ex;
    }

    /**
     * {@inheritDoc}
     */
    public function getConnection()
    {
        return Container::getInstance()->get($this->getConnectionName());
    }

    /**
     * Get the domains connection name.
     *
     * @return string
     */
    public function getConnectionName()
    {
        return $this->domain->getLdapConnectionName();
    }
}
