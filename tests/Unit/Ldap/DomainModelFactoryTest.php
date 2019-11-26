<?php

namespace Tests\Unit\Ldap;

use Tests\TestCase;
use App\LdapDomain;
use App\Ldap\DomainModelFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LdapRecord\Models\Entry as DefaultLdapModel;
use LdapRecord\Models\OpenLDAP\Entry as OpenLdapModel;
use LdapRecord\Models\ActiveDirectory\Entry as ActiveDirectoryModel;

class DomainModelFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_make_returns_models_by_type()
    {
        $default = factory(LdapDomain::class)->create();
        $ad = factory(LdapDomain::class)->create(['type' => LdapDomain::TYPE_ACTIVE_DIRECTORY]);
        $adlds = factory(LdapDomain::class)->create(['type' => LdapDomain::TYPE_ACTIVE_DIRECTORY_LDS]);
        $openLdap = factory(LdapDomain::class)->create(['type' => LdapDomain::TYPE_OPEN_LDAP]);

        $this->assertInstanceOf(DefaultLdapModel::class, DomainModelFactory::on($default)->make());
        $this->assertInstanceOf(ActiveDirectoryModel::class, DomainModelFactory::on($ad)->make());
        $this->assertInstanceOf(ActiveDirectoryModel::class, DomainModelFactory::on($adlds)->make());
        $this->assertInstanceOf(OpenLdapModel::class, DomainModelFactory::on($openLdap)->make());
    }

    public function test_make_sets_the_ldap_model_connection()
    {
        /** @var LdapDomain $domain */
        $domain = factory(LdapDomain::class)->create();
        $model = DomainModelFactory::on($domain)->make();
        $this->assertEquals($domain->getLdapConnectionName(), $model->getConnectionName());
    }
}
