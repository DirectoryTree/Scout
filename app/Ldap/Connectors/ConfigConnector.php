<?php

namespace App\Ldap\Connectors;

use Exception;
use LdapRecord\Connection;

class ConfigConnector extends Connector
{
    /**
     * The domain configuration.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Set the configuration to use for connecting.
     *
     * @param array $config
     *
     * @return $this
     */
    public function with(array $config = [])
    {
        $this->config = $config;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function connected()
    {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function failed(Exception $ex)
    {
        throw $ex;
    }

    /**
     * Get the LDAP connection to utilize.
     *
     * @return Connection
     */
    public function getConnection()
    {
        return new Connection($this->config);
    }
}
