<?php

namespace Tests\Feature;

use App\LdapObject;

class ObjectPinTest extends FeatureTestCase
{
    public function test_objects_can_be_pinned()
    {
        $this->signIn();

        $object = factory(LdapObject::class)->create();

        $this->post(route('objects.pin.store', $object))
            ->assertJson(['type' => 'success']);

        $this->assertTrue($object->fresh()->pinned);
    }

    public function test_objects_can_be_unpinned()
    {
        $this->signIn();

        $object = factory(LdapObject::class)->create(['pinned' => true]);

        $this->delete(route('objects.pin.destroy', $object))
            ->assertJson(['type' => 'success']);

        $this->assertFalse($object->fresh()->pinned);
    }
}
