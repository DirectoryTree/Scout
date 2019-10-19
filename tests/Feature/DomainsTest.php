<?php

namespace Tests\Feature;

use Mockery as m;
use App\LdapDomain;
use App\LdapObject;
use App\LdapNotifier;
use LdapRecord\LdapRecordException;
use App\Ldap\Connectors\ConfigConnector;

class DomainsTest extends InstalledTestCase
{
    public function test_viewing_all_initial_domains()
    {
        $this->signIn();

        $this->get(route('domains.index'))->assertSee('Domains');
    }

    public function test_adding_domain_requires_connection()
    {
        $this->signIn();

        $connector = m::mock(ConfigConnector::class);
        $connector->shouldReceive('with')->once()->andReturnSelf();
        $connector->shouldReceive('connect')->once()->andReturnTrue();

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
        ])->assertJson([
            'type' => 'success',
            'url' => route('domains.show', 'localhost'),
        ]);

        $this->assertDatabaseHas('ldap_domains', ['name' => 'localhost']);
    }

    public function test_adding_domain_connection_fails()
    {
        $this->signIn();

        $connector = m::mock(ConfigConnector::class);
        $connector->shouldReceive('with')->once()->andReturnSelf();
        $connector->shouldReceive('connect')->once()->andThrow(new LdapRecordException('Failed'));

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

    public function test_editing_domain_requires_connection()
    {
        $this->signIn();

        $connector = m::mock(ConfigConnector::class);
        $connector->shouldReceive('with')->once()->andReturnSelf();
        $connector->shouldReceive('connect')->once()->andThrow(new LdapRecordException('Failed'));

        $this->app->instance(ConfigConnector::class, $connector);

        $domain = factory(LdapDomain::class)->create();

        $data = [
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
        ];

        $this->patch(route('domains.update', $domain), $data)
            ->assertRedirect()
            ->assertSessionHasErrors('hosts');
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

    public function test_deleting_domain_deletes_child_records()
    {
        $this->signIn();

        $domain = factory(LdapDomain::class)->create();

        factory(LdapNotifier::class)->times(5)->create([
            'notifiable_id' => $domain->id,
            'notifiable_type' => get_class($domain),
        ]);

        factory(LdapObject::class)->times(5)->create([
            'domain_id' => $domain->id
        ]);

        $this->assertEquals(LdapDomain::count(), 1);
        $this->assertEquals(LdapNotifier::count(), 5);
        $this->assertEquals(LdapObject::count(), 5);

        $domain->delete();

        $this->assertEquals(LdapDomain::count(), 0);
        $this->assertEquals(LdapNotifier::count(), 0);
        $this->assertEquals(LdapObject::count(), 0);
    }
}
