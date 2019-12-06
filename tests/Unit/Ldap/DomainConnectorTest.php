<?php

namespace Tests\Unit\Ldap;

use Mockery as m;
use Carbon\Carbon;
use Tests\TestCase;
use App\LdapDomain;
use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\Configuration\DomainConfiguration;
use App\Ldap\Connectors\DomainConnector;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomainConnectorTest extends TestCase
{
    use RefreshDatabase;

    public function test_connection_is_retrieved_from_container()
    {
        $domain = factory(LdapDomain::class)->create();
        $conn = new Connection();

        Container::getInstance()->add($conn, $domain->getLdapConnectionName());

        $this->assertEquals($conn, DomainConnector::on($domain)->getConnection());
    }

    public function test_successful_connections_update_domain_status()
    {
        /** @var LdapDomain $domain */
        $domain = factory(LdapDomain::class)->create();
        $conn = m::mock(Connection::class);

        Container::getInstance()->add($conn, $domain->getLdapConnectionName());

        $conn->shouldReceive('isConnected')->once()->andReturnFalse();
        $conn->shouldReceive('connect')->once();

        $config = new DomainConfiguration($domain->getLdapConnectionAttributes());
        $conn->shouldReceive('getConfiguration')->once()->andReturn($config);

        DomainConnector::on($domain)->connect();

        $domain = $domain->fresh();

        $this->assertInstanceOf(Carbon::class, $domain->attempted_at);
        $this->assertEquals($domain->status, LdapDomain::STATUS_ONLINE);
    }
}
