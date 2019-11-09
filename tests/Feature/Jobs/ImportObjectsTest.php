<?php

namespace Tests\Feature\Jobs;

use Mockery as m;
use App\LdapDomain;
use App\LdapObject;
use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\Models\Entry;
use LdapRecord\Query\Model\Builder;
use App\Actions\ImportDomainAction;
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

        $connection = m::mock(Connection::class);
        $connection->shouldReceive('query')->once()->andReturnSelf();
        $connection->shouldReceive('model')->once()->andReturn($builder);

        $connectionName = 'default';

        Container::getInstance()->add($connection, $connectionName);

        $domain = factory(LdapDomain::class)->create(['slug' => $connectionName]);

        $action = new ImportDomainAction($domain);

        $this->assertEquals(10, $action->execute());
        $this->assertEquals(10, LdapObject::count());
    }
}
