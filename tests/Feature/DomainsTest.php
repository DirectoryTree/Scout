<?php

namespace Tests\Feature;

use Mockery as m;
use App\LdapDomain;
use Tests\TestCase;
use LdapRecord\LdapRecordException;
use App\Ldap\Connectors\ConfigConnector;

class DomainsTest extends TestCase
{
    public function test_viewing_all_initial_domains()
    {
        $this->signIn();

        $this->get(route('domains.index'))->assertSee('Domains');
    }

    public function test_adding_domain()
    {
        $this->signIn();

        $connector = m::mock(ConfigConnector::class);
        $connector->shouldReceive('with')->once()->andReturnSelf();
        $connector->shouldReceive('connect')->andReturnTrue();

        $this->app->instance(ConfigConnector::class, $connector);

        $this->post(route('domains.store'), [
            'type' => LdapDomain::TYPE_ACTIVE_DIRECTORY,
            'name' => 'localhost',
            'hosts' => 'localhost',
            'username' => 'username',
            'password' => 'password',
            'base_dn' => 'dc=local,dc=com',
            'filter' => '(attribute=value)',
            'port' => 389,
            'timeout' => 5,
            'encryption' => 'tls',
        ])->assertRedirect(route('domains.show', 'localhost'));

        $this->assertDatabaseHas('ldap_domains', ['name' => 'localhost']);
    }

    public function test_adding_domain_connection_fails()
    {
        $this->signIn();

        $connector = m::mock(ConfigConnector::class);
        $connector->shouldReceive('with')->once()->andReturnSelf();
        $connector->shouldReceive('connect')->andThrow(new LdapRecordException('Failed'));

        $this->app->instance(ConfigConnector::class, $connector);

        $this->post(route('domains.store'), [
            'type' => LdapDomain::TYPE_ACTIVE_DIRECTORY,
            'name' => 'localhost',
            'hosts' => 'localhost',
            'username' => 'username',
            'password' => 'password',
            'base_dn' => 'dc=local,dc=com',
            'filter' => '(attribute=value)',
            'port' => 389,
            'timeout' => 5,
            'encryption' => 'tls',
        ])->assertRedirect()->assertSessionHasErrors(['hosts' => 'Failed']);
    }

    public function test_viewing_added_domain_works()
    {
        $this->signIn();

        $domain = factory(LdapDomain::class)->create();

        $this->get(route('domains.index'))->assertSee($domain->name);
        $this->get(route('domains.show', $domain))
            ->assertSee($domain->name)
            ->assertSee($domain->base_dn);
    }
}
