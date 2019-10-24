<?php

namespace Tests\Feature;

use App\LdapNotifier;
use App\LdapNotifierCondition;

class NotifierTest extends FeatureTestCase
{
    public function test_user_must_be_signed_in_to_update_notifier()
    {
        $notifier = factory(LdapNotifier::class)->state('domain')->create();

        $this->patch(route('notifiers.update', $notifier))
            ->assertRedirect(route('login'));
    }

    public function test_notifiers_can_be_updated()
    {
        $this->signIn();

        $notifier = factory(LdapNotifier::class)->state('domain')->create();

        $this->patch(route('notifiers.update', $notifier), [
            'name' => 'New Name',
            'short_name' => 'New Short Name',
            'description' => 'New Description',
        ])->assertJson(['type' => 'success']);

        $this->assertDatabaseHas('ldap_notifiers', [
            'name' => 'New Name',
            'notifiable_name' => 'New Short Name',
            'description' => 'New Description',
        ]);
    }

    public function test_user_must_be_signed_in_to_delete_notifier()
    {
        $notifier = factory(LdapNotifier::class)->state('domain')->create();

        $this->delete(route('notifiers.destroy', $notifier))
            ->assertRedirect(route('login'));
    }

    public function test_notifiers_can_be_deleted()
    {
        $this->signIn();

        /** @var LdapNotifier $notifier */
        $notifier = factory(LdapNotifier::class)->state('domain')->create();

        factory(LdapNotifierCondition::class)->times(3)->create([
            'notifier_id' => $notifier->id,
        ]);

        $this->assertEquals(3, $notifier->conditions()->count());

        $this->delete(route('notifiers.destroy', $notifier))
            ->assertJson(['type' => 'success']);

        $this->assertNull($notifier->fresh());
        $this->assertEquals(0, $notifier->conditions()->count());
    }
}
