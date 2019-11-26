<?php

namespace Tests\Unit\Ldap;

use Tests\TestCase;
use App\LdapDomain;
use LdapRecord\Container;
use App\Ldap\DomainQueryFactory;
use App\Ldap\DomainModelFactory;
use LdapRecord\Connection;
use LdapRecord\Query\Model\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomainQueryFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->domain = factory(LdapDomain::class)->create();

        Container::getInstance()->add(new Connection(), $this->domain->getLdapConnectionName());
    }

    public function test_queries_are_made()
    {
        $model = DomainModelFactory::on($this->domain)->make();
        $query = (new DomainQueryFactory($this->domain))->make($model);

        $this->assertInstanceOf(Builder::class, $query);
        $this->assertEquals($model, $query->getModel());
    }

    public function test_global_filters_are_applied_to_queries()
    {
        $this->domain->filter = '(foo=bar)';
        $model = DomainModelFactory::on($this->domain)->make();
        $query = (new DomainQueryFactory($this->domain))->make($model);

        $this->assertEquals(['(foo=bar)'], $query->getFilters()['raw']);
    }
}
