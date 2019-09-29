<?php

namespace App\Ldap;

use Exception;
use App\LdapDomain;
use LdapRecord\Container;
use Illuminate\Support\Str;

class DomainConnector
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
     * Connects to the LDAP domain.
     *
     * @return bool
     *
     * @throws Exception
     */
    public function connect()
    {
        $connection = Container::getInstance()->get($this->domain->getLdapConnectionName());

        // Before connecting, we will ensure we're not already bound
        // to the LDAP server as to prevent needlessly rebinding.
        if (! $connection->getLdapConnection()->isBound()) {
            $config = $connection->getConfiguration();

            try {
                $connection->connect(
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
}
