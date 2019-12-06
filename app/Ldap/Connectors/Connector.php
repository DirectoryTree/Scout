<?php

namespace App\Ldap\Connectors;

use Exception;
use LdapRecord\Connection;

abstract class Connector
{
    /**
     * Connect to the LDAP server.
     *
     * @return void
     *
     * @throws Exception
     */
    public function connect()
    {
        $connection = $this->getConnection();

        try {
            // We'll only attempt connecting if we're not already bound to
            // the LDAP server so we prevent multiple rebind attempts.
            if (! $connection->isConnected()) {
                $this->attempt($connection);
            }

            $this->connected();
        } catch (Exception $ex) {
            $this->failed($ex);
        }
    }

    /**
     * Attempt connecting to the LDAP server.
     *
     * @param Connection $connection
     *
     * @throws \LdapRecord\Auth\BindException
     * @throws \LdapRecord\ConnectionException
     */
    public function attempt(Connection $connection)
    {
        $connection->connect();
    }

    /**
     * Operations to run after successfully connecting.
     *
     * @return void
     */
    abstract public function connected();

    /**
     * Operations to run after failing connecting.
     *
     * @param Exception $ex
     *
     * @return void
     *
     * @throws Exception
     */
    abstract public function failed(Exception $ex);

    /**
     * Get the LDAP connection to utilize.
     *
     * @return Connection
     */
    abstract public function getConnection();
}
