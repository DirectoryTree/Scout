<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\LdapChange;
use App\LdapDomain;
use App\LdapObject;
use App\LdapNotifier;
use App\Notification;
use App\LdapNotifierCondition;

class ChangeNotificationTest extends TestCase
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
        factory(LdapNotifier::class)->state('domain')->create([
            'notifiable_id' => $domain->id,
            'notifiable_type' => get_class($domain),
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
}
