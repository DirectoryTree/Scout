<?php

namespace Tests\Unit\Ldap;

use App\LdapChange;
use Tests\TestCase;
use App\LdapScan;
use App\LdapObject;
use App\LdapScanEntry;
use App\Jobs\Pipes\DetectChanges;
use App\Jobs\Pipes\AssociateDomain;
use App\Jobs\Pipes\AssociateParent;
use App\Jobs\Pipes\HydrateProperties;
use App\Jobs\Pipes\RestoreModelWhenTrashed;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PipesTest extends TestCase
{
    use RefreshDatabase;

    public function test_associate_domain()
    {
        $scan = factory(LdapScan::class)->create();
        $entry = factory(LdapScanEntry::class)->create(['scan_id' => $scan->id]);

        $model = new LdapObject();

        $this->assertNull($model->domain_id);

        (new AssociateDomain($scan, $entry))->handle($model, function ($model) {});

        $this->assertEquals($scan->domain->id, $model->domain_id);
        $this->assertEquals($scan->domain, $model->domain);
    }

    public function test_associate_parent()
    {
        $scan = factory(LdapScan::class)->create();
        $parentScanEntry = factory(LdapScanEntry::class)->create(['scan_id' => $scan]);
        $childScanEntry = factory(LdapScanEntry::class)->create([
            'scan_id' => $scan->id,
            'parent_id' => $parentScanEntry->id,
        ]);

        $parentObject = factory(LdapObject::class)->create(['guid' => $parentScanEntry->guid]);
        $object = new LdapObject();

        $this->assertNull($object->parent_id);

        (new AssociateParent($scan, $childScanEntry))->handle($object, function ($model) {});

        $this->assertEquals($parentObject->id, $object->parent_id);
        $this->assertTrue($parentObject->is($object->parent));
    }

    public function test_restore_when_trashed()
    {
        $scan = factory(LdapScan::class)->create();
        $entry = factory(LdapScanEntry::class)->create(['scan_id' => $scan->id]);

        $model = factory(LdapObject::class)->create(['deleted_at' => now()]);

        $this->assertTrue($model->trashed());

        (new RestoreModelWhenTrashed($scan, $entry))->handle($model, function ($model) {});

        $this->assertFalse($model->fresh()->trashed());
    }

    public function test_properties_are_hydrated()
    {
        $scan = factory(LdapScan::class)->create();
        $entry = factory(LdapScanEntry::class)->create(['scan_id' => $scan->id]);

        $object = new LdapObject();

        (new HydrateProperties($scan, $entry))->handle($object, function ($model) {});

        $this->assertEquals($object->dn, $entry->dn);
        $this->assertEquals($object->name, $entry->name);
        $this->assertEquals($object->type, $entry->type);
        $this->assertEquals($object->values, $entry->values);
    }

    public function test_changes_are_detected()
    {
        $scan = factory(LdapScan::class)->create();
        $entry = factory(LdapScanEntry::class)->create([
            'scan_id' => $scan->id,
            'values' => ['foo' => ['bar']],
        ]);

        $object = factory(LdapObject::class)->create([
            'values' => ['foo' => ['baz']]
        ]);

        (new DetectChanges($scan, $entry))->handle($object, function ($model) {});

        $change = LdapChange::where('object_id', '=', $object->id)->firstOrFail();
        $this->assertTrue($change->object->is($object));
        $this->assertEquals($change->before, $object->values['foo']);
        $this->assertEquals($change->after, $entry->values['foo']);
    }
}
