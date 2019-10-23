<?php

namespace Tests\Feature;

use App\LdapChange;
use App\LdapDomain;
use App\LdapObject;
use App\LdapNotifier;
use LdapRecord\Models\Attributes\Timestamp;
use LdapRecord\Utilities;
use App\LdapNotifierCondition;

class ChangeNotificationTest extends InstalledTestCase
{
    public function test_notification_is_created_with_domain_notifier()
    {
        $user = $this->signIn();

        $domain = factory(LdapDomain::class)->create();

        // Create a domain notifier.
        $notifier = factory(LdapNotifier::class)->create([
            'notifiable_id' => $domain->id,
            'notifiable_type' => get_class($domain),
        ]);

        factory(LdapNotifierCondition::class)->create([
            'notifier_id' => $notifier->id,
            'type' => 'string',
            'attribute' => 'foo',
            'operator' => LdapNotifierCondition::OPERATOR_EQUALS,
            'value' => 'bar',
        ]);

        $object = factory(LdapObject::class)->create([
            'domain_id' => $domain->id,
        ]);

        // Modify the object.
        $object->values = ['foo' => 'bar'];
        $object->save();

        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $user->id,
            'notifiable_type' => get_class($user),
        ]);
    }

    public function test_notification_is_not_created_for_non_notifiable_attribute()
    {
        $domain = factory(LdapDomain::class)->create();

        // Create a domain notifier.
        $notifier = factory(LdapNotifier::class)->create([
            'notifiable_id' => $domain->id,
            'notifiable_type' => get_class($domain),
        ]);

        factory(LdapNotifierCondition::class)->create([
            'notifier_id' => $notifier->id,
            'type' => 'string',
            'operator' => LdapNotifierCondition::OPERATOR_EQUALS,
            'attribute' => 'foo',
            'value' => 'bar',
        ]);

        $object = factory(LdapObject::class)->create([
            'domain_id' => $domain->id,
        ]);

        // Generate the change (non-matching attribute).
        factory(LdapChange::class)->create([
            'object_id' => $object->id,
            'attribute' => 'invalid',
            'before' => ['baz'],
            'after' => ['bar']
        ]);

        $this->assertDatabaseMissing('notifications', [
            'notifiable_id' => $domain->id,
            'notifiable_type' => get_class($domain),
        ]);
    }

    public function test_notification_is_past()
    {
        $user = $this->signIn();

        $domain = factory(LdapDomain::class)->create();

        // Create a domain notifier.
        $notifier = factory(LdapNotifier::class)->create([
            'notifiable_id' => $domain->id,
            'notifiable_type' => get_class($domain),
        ]);

        factory(LdapNotifierCondition::class)->create([
            'notifier_id' => $notifier->id,
            'type' => 'timestamp',
            'attribute' => 'lockouttime',
            'operator' => LdapNotifierCondition::OPERATOR_PAST,
            'value' => null,
        ]);

        $object = factory(LdapObject::class)->create([
            'domain_id' => $domain->id,
            'values' => ['lockouttime' => null],
        ]);

        $timestamp = new Timestamp('windows-int');

        $object->values = [
            'lockouttime' => $timestamp->fromDateTime(now()->subDay())
        ];

        $object->save();

        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $user->id,
            'notifiable_type' => get_class($user),
        ]);
    }
}
