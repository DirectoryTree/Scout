<?php

namespace App\Ldap\Connectors;

use Exception;
use App\LdapDomain;
use App\LdapDomainPing;
use LdapRecord\Connection;

class DomainHostConnector extends DomainConnector
{
    /**
     * Force attempting connectivity.
     *
     * @var bool
     */
    protected $force = true;

    /**
     * The host to attempt connecting to.
     *
     * @var string
     */
    protected $host;

    /**
     * The start time of the connection attempt.
     *
     * @var int
     */
    protected $start;

    /**
     * The ping record of the domain host.
     *
     * @var LdapDomainPing
     */
    protected $ping;

    /**
     * Constructor.
     *
     * @param LdapDomain $domain
     * @param string     $host
     */
    public function __construct(LdapDomain $domain, $host)
    {
        parent::__construct($domain);

        $this->host = $host;
        $this->start = microtime(true);
        $this->ping = $domain->pings()->make(['host' => $host]);
    }

    /**
     * Attempt connecting to the domain host.
     *
     * @param Connection $connection
     *
     * @throws \LdapRecord\Auth\BindException
     * @throws \LdapRecord\ConnectionException
     * @throws \LdapRecord\Configuration\ConfigurationException
     *
     * @return void
     */
    public function attempt(Connection $connection)
    {
        // Clone the configuration and connection so we don't override
        // it's values throughout the request lifecycle.
        $config = clone $connection->getConfiguration();
        $connection = clone $connection;

        $config->set('hosts', [$this->host]);

        $connection->setConfiguration($config);

        parent::attempt($connection);
    }

    /**
     * Generate a successful ping record of the domain host.
     *
     * @return void
     */
    public function connected()
    {
        parent::connected();

        $this->ping->fill([
            'success' => true,
            'response_time' => $this->getElapsedTime($this->start),
        ])->save();
    }

    /**
     * Generate a failure ping record of the domain host.
     *
     * @param Exception $ex
     *
     * @throws Exception
     *
     * @return void
     */
    public function failed(Exception $ex)
    {
        $this->ping->fill([
            'success' => false,
            'message' => $ex->getMessage(),
            'response_time' => $this->getElapsedTime($this->start),
        ])->save();

        // We'll call the parent method after we generate
        // a ping record, as the exception is re-thrown.
        parent::failed($ex);
    }

    /**
     * Get the elapsed time since a given starting point.
     *
     * @param int $start
     *
     * @return float
     */
    protected function getElapsedTime($start)
    {
        return round((microtime(true) - $start) * 1000, 2);
    }
}
