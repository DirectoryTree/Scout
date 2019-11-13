<?php

namespace Tests\Feature;

use App\User;
use App\LdapObject;

class ObjectPinTest extends FeatureTestCase
{
    public function test_objects_can_be_pinned()
    {
        $this->signIn();

        $object = factory(LdapObject::class)->create();

        $this->post(route('objects.pin.store', $object))
            ->assertJson(['type' => 'success']);

        /** @var User $user */
        $user = auth()->user();

        $this->assertTrue($user->pins()->first()->is($object));
    }

    public function test_objects_can_be_unpinned()
    {
        $this->signIn();

        $object = factory(LdapObject::class)->create();

        /** @var User $user */
        $user = auth()->user();
        $user->pins()->attach($object);

        $this->delete(route('objects.pin.destroy', $object))
            ->assertJson(['type' => 'success']);

        $this->assertNull($user->pins()->first());
    }

    public function test_users_can_see_pins()
    {
        $this->signIn();

        $object = factory(LdapObject::class)->create();

        /** @var User $user */
        $user = auth()->user();
        $user->pins()->attach($object);

        $this->get(route('dashboard'))->assertSee($object->name);
    }

    public function test_users_cannot_see_others_pins()
    {
        $this->signIn();

        /** @var User $user */
        $user = factory(User::class)->create();
        $object = factory(LdapObject::class)->create();

        $user->pins()->attach($object);

        $this->get(route('dashboard'))->assertDontSee($object->name);
    }
}
