<?php

namespace Tests\Feature;

use App\LdapNotifier;
use App\LdapNotifierCondition;

class NotifierConditionTest extends InstalledTestCase
{
    public function test_user_must_be_signed_in_to_create_conditions()
    {
        $notifier = factory(LdapNotifier::class)->states('domain')->create();

        $this->post(route('notifiers.conditions.store', $notifier))
            ->assertRedirect(route('login'));
    }

    public function test_conditions_can_be_created()
    {
        $this->signIn();

        $notifier = factory(LdapNotifier::class)->states('domain')->create();

        $this->post(route('notifiers.conditions.store', $notifier), [
            'attribute' => 'company',
            'type' => LdapNotifierCondition::TYPE_STRING,
            'operator' => LdapNotifierCondition::OPERATOR_CHANGED,
        ])->assertTurbolinksRedirect();
    }

    public function test_condition_type_is_required()
    {
        $this->signIn();

        $notifier = factory(LdapNotifier::class)->states('domain')->create();

        $this->post(route('notifiers.conditions.store', $notifier), [
            'attribute' => 'company',
            'operator' => LdapNotifierCondition::OPERATOR_CHANGED,
        ])->assertSessionHasErrors('type');
    }

    public function test_condition_attribute_is_required()
    {
        $this->signIn();

        $notifier = factory(LdapNotifier::class)->states('domain')->create();

        $this->post(route('notifiers.conditions.store', $notifier), [
            'type' => LdapNotifierCondition::TYPE_STRING,
            'operator' => LdapNotifierCondition::OPERATOR_CHANGED,
        ])->assertSessionHasErrors('attribute');
    }

    public function test_condition_operator_is_required()
    {
        $this->signIn();

        $notifier = factory(LdapNotifier::class)->states('domain')->create();

        $this->post(route('notifiers.conditions.store', $notifier), [
            'attribute' => 'company',
            'type' => LdapNotifierCondition::TYPE_STRING,
        ])->assertSessionHasErrors('operator');
    }
}
