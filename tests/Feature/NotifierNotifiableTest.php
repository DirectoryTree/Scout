<?php

namespace Tests\Feature;

use App\LdapDomain;

class NotifierNotifiableTest extends InstalledTestCase
{
    public function test_notifiable_type_must_be_provided()
    {
        $this->signIn();

        $domain = factory(LdapDomain::class)->create();

        $this->post(route('notifiers.notifiable.store', ['other', $domain]))
            ->assertNotFound();
    }

    public function test_notifiable_model_must_be_provided()
    {
        $this->signIn();

        $this->post(route('notifiers.notifiable.store', ['domain', 'invalid']))
            ->assertNotFound();
    }

    public function test_user_must_be_signed_in_to_create_notifier()
    {
        $domain = factory(LdapDomain::class)->create();

        $this->post(route('notifiers.notifiable.store', ['domain', $domain]))
            ->assertRedirect(route('login'));
    }

    public function test_notifiers_can_be_created()
    {
        $this->signIn();

        $domain = factory(LdapDomain::class)->create();

        $this->post(route('notifiers.notifiable.store', ['domain', $domain]), [
            'name' => 'Notifier Name',
            'short_name' => 'Short Name',
            'description' => 'Description',
        ])->assertTurbolinksRedirect();

        $this->assertDatabaseHas('ldap_notifiers', [
            'notifiable_type' => LdapDomain::class,
            'notifiable_id' => $domain->getKey(),
            'name' => 'Notifier Name',
            'notifiable_name' => 'Short Name',
            'description' => 'Description',
        ]);
    }
}
