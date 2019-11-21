<?php

namespace Tests\Unit\Ldap;

use Tests\TestCase;
use App\LdapObject;
use App\LdapDomain;
use LdapRecord\Models\Entry;
use App\Ldap\Pipes\AssociateDomain;
use App\Ldap\Pipes\AssociateParent;
use App\Ldap\Pipes\HydrateProperties;
use App\Ldap\Pipes\RestoreModelWhenTrashed;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PipesTest extends TestCase
{
    use RefreshDatabase;

    public function test_associate_domain()
    {
        $object = factory(Entry::class)->make();
        $domain = factory(LdapDomain::class)->create();

        $model = new LdapObject();

        $this->assertNull($model->domain_id);

        (new AssociateDomain($domain, $object))->handle($model, function ($model) {});

        $this->assertEquals($domain->id, $model->domain_id);
        $this->assertEquals($domain, $model->domain);
    }

    public function test_associate_parent()
    {
        $object = factory(Entry::class)->make();
        $domain = factory(LdapDomain::class)->create();
        $parent = factory(LdapObject::class)->create();

        $model = new LdapObject();

        $this->assertNull($model->parent_id);

        (new AssociateParent($domain, $object, $parent))->handle($model, function ($model) {});

        $this->assertEquals($parent->id, $model->parent_id);
        $this->assertEquals($parent, $model->parent);
    }

    public function test_restore_when_trashed()
    {
        $object = factory(Entry::class)->make();
        $domain = factory(LdapDomain::class)->create();
        $model = factory(LdapObject::class)->create(['deleted_at' => now()]);

        $this->assertTrue($model->trashed());

        (new RestoreModelWhenTrashed($domain, $object))->handle($model, function ($model) {});

        $this->assertFalse($model->fresh()->trashed());
    }
}
