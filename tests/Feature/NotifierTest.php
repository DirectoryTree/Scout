<?php

namespace Tests\Feature;

use App\LdapNotifier;

class NotifierTest extends InstalledTestCase
{
    public function test_user_must_be_signed_in_to_update_notifier()
    {
        $notifier = factory(LdapNotifier::class)->state('domain')->create();

        $this->patch(route('notifiers.update', $notifier))
            ->assertRedirect(route('login'));
    }

    public function test_notifiers_can_be_modified()
    {
        $this->signIn();

        $notifier = factory(LdapNotifier::class)->state('domain')->create();

        $this->patch(route('notifiers.update', $notifier), [
            'name' => 'New Name',
            'short_name' => 'New Short Name',
            'description' => 'New Description',
        ])->assertTurbolinksRedirect();

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

        $notifier = factory(LdapNotifier::class)->state('domain')->create();

        $this->delete(route('notifiers.destroy', $notifier))
            ->assertTurbolinksRedirect();
    }
}
