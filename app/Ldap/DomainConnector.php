<?php

namespace App\Ldap;

use Exception;
use App\LdapDomain;
use Illuminate\Support\Str;
use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\ContainerException;

class DomainConnector
{
    /**
     * The LDAP domain to connect to.
     *
     * @var LdapDomain
     */
    protected $domain;

    /**
     * The LDAP connection.
     *
     * @var Connection
     */
    protected $connection;

    /**
     * Constructor.
     *
     * @param LdapDomain $domain
     */
    public function __construct(LdapDomain $domain)
    {
        $this->domain = $domain;
        $this->connection = $this->getLdapConnection();
    }

    /**
     * Connects to the LDAP domain.
     *
     * @return bool
     *
     * @throws \LdapRecord\Auth\BindException
     * @throws \LdapRecord\ConnectionException
     */
    public function connect()
    {
        // Before connecting, we will ensure we're not already bound
        // to the LDAP server as to prevent needlessly rebinding.
        if (! $this->connection->getLdapConnection()->isBound()) {
            $config = $this->connection->getConfiguration();

            try {
                $this->connection->connect(
                    decrypt($config->get('username')),
                    decrypt($config->get('password'))
                );

                // Update the domains connection status.
                $this->domain->update([
                    'attempted_at' => now(),
                    'status' => LdapDomain::STATUS_ONLINE,
                ]);
            } catch (Exception $ex) {
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
        }

        return true;
    }

    /**
     * Get the LDAP connection for the domain.
     *
     * @return Connection
     */
    public function getLdapConnection()
    {
        $container = Container::getInstance();

        try {
            // Try to retrieve the connection from the container.
            $conn = $container->get($this->getConnectionName());
        } catch (ContainerException $ex) {
            // Connection does not exist. Create and add it here so
            // it is available throughout the current request.
            $conn = $this->getNewLdapConnection();

            $container->add($conn, $this->getConnectionName());
        }

        return $conn;
    }

    /**
     * Get a new LDAP connection.
     *
     * @return Connection
     */
    protected function getNewLdapConnection()
    {
        return new Connection(
            $this->domain->getConnectionAttributes()
        );
    }

    /**
     * Get the domains LDAP connection name.
     *
     * @return string
     */
    protected function getConnectionName()
    {
        return $this->domain->slug;
    }
}
