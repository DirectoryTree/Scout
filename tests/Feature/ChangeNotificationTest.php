<?php

namespace Tests\Feature;

use App\LdapChange;
use App\LdapDomain;
use App\LdapObject;
use App\LdapNotifier;
use App\Notification;
use LdapRecord\Utilities;
use App\LdapNotifierCondition;

class ChangeNotificationTest extends InstalledTestCase
{
    public function test_notification_is_created_with_domain_notifier()
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
            'attribute' => 'foo',
            'operator' => LdapNotifierCondition::OPERATOR_EQUALS,
            'value' => 'bar',
        ]);

        $object = factory(LdapObject::class)->create([
            'domain_id' => $domain->id,
        ]);

        // Generate the change.
        $change = factory(LdapChange::class)->create([
            'object_id' => $object->id,
            'attribute' => 'foo',
            'before' => ['baz'],
            'after' => ['bar']
        ]);

        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $domain->id,
            'notifiable_type' => get_class($domain),
        ]);

        $notification = Notification::first();

        $this->assertEquals($notification->data, [
            'change_id' => $change->id,
            'attribute' => $change->attribute,
            'before' => $change->before,
            'after' => $change->after,
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
        $domain = factory(LdapDomain::class)->create();

        // Create a domain notifier.
        $notifier = factory(LdapNotifier::class)->create([
            'notifiable_id' => $domain->id,
            'notifiable_type' => get_class($domain),
        ]);

        factory(LdapNotifierCondition::class)->create([
            'notifier_id' => $notifier->id,
            'type' => 'string',
            'attribute' => 'accountexpires',
            'operator' => LdapNotifierCondition::OPERATOR_PAST,
        ]);

        $object = factory(LdapObject::class)->create([
            'domain_id' => $domain->id,
        ]);

        // Generate the change.
        factory(LdapChange::class)->create([
            'object_id' => $object->id,
            'attribute' => 'accountexpires',
            'before' => [],
            'after' => [Utilities::convertUnixTimeToWindowsTime(now()->subDay()->timestamp)]
        ]);

        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $domain->id,
            'notifiable_type' => get_class($domain),
        ]);
    }
}
