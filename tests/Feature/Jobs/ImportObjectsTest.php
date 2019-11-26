<?php

namespace Tests\Feature\Jobs;

use Mockery as m;
use App\LdapScan;
use App\LdapDomain;
use App\Jobs\ImportDomain;
use LdapRecord\Ldap;
use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\Models\Entry;
use LdapRecord\Query\Model\Builder;
use Tests\Feature\FeatureTestCase;

class ImportObjectsTest extends FeatureTestCase
{
    public function test_ldap_objects_can_be_imported()
    {
        $models = factory(Entry::class)->times(10)->make()->each(function (Entry $entry) {
            $entry->setDn("cn={$entry->getFirstAttribute('cn')},dc=acme,dc=org");
        });

        $builder = m::mock(Builder::class);
        $builder->shouldReceive('listing')->once()->withNoArgs()->andReturnSelf();
        $builder->shouldReceive('select')->once()->withArgs(['*'])->andReturnSelf();
        $builder->shouldReceive('paginate')->once()->withArgs([1000])->andReturn($models);

        $ldap = m::mock(Ldap::class);
        $ldap->shouldReceive('isBound')->andReturnTrue();

        $connection = m::mock(Connection::class);
        $connection->shouldReceive('getLdapConnection')->once()->andReturn($ldap);
        $connection->shouldReceive('query')->once()->andReturnSelf();
        $connection->shouldReceive('model')->once()->andReturn($builder);
        $connectionName = 'default';

        Container::getInstance()->add($connection, $connectionName);

        $domain = factory(LdapDomain::class)->create(['slug' => $connectionName]);
        $scan = factory(LdapScan::class)->create(['domain_id' => $domain->id]);

        (new ImportDomain($scan))->handle();

        $entries = $scan->entries()->get();

        $this->assertEquals(10, $entries->count());

        // Make sure each entry was imported.
        $models->each(function (Entry $model) use ($entries) {
            $this->assertEquals(1, $entries->where('guid', '=', $model->getConvertedGuid())->count());
        });
    }
}
