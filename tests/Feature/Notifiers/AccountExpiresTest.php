<?php

namespace Tests\Feature\Notifiers;

use App\LdapDomain;
use AdSystemNotifierSeeder;
use App\Ldap\Conditions\Validator;
use Tests\Feature\InstalledTestCase;
use LdapRecord\Models\Attributes\Timestamp;

class AccountExpiresTest extends InstalledTestCase
{
    /** @var LdapDomain */
    protected $domain;

    /** @var \App\LdapNotifier */
    protected $notifier;

    protected function setUp(): void
    {
        parent::setUp();

        $this->domain = factory(LdapDomain::class)->create(['type' => LdapDomain::TYPE_ACTIVE_DIRECTORY]);

        $this->seed(AdSystemNotifierSeeder::class);

        $this->notifier = $this->domain->notifiers()
            ->where('notifiable_name', '=', 'Account Expired')
            ->firstOrFail();
    }

    public function test_conditions_pass_with_past_date()
    {
        $conditions = $this->notifier->conditions()->get();

        $timestamp = new Timestamp('windows-int');
        $expiry = now()->subDay();

        // This will pass due to the attribute not existing before and it being expired.
        $validator = new Validator($conditions, ['accountexpires' => $timestamp->fromDateTime($expiry)]);

        $this->assertTrue($validator->passes());
    }

    public function test_conditions_pass_with_past_date_and_new_past_date()
    {
        $conditions = $this->notifier->conditions()->get();

        $timestamp = new Timestamp('windows-int');

        $expiry = now()->subDay();
        $newExpiry = now()->subWeek();

        // Due to the account expires value changing, this should pass.
        $validator = new Validator($conditions,
            ['accountexpires' => $timestamp->fromDateTime($expiry)],
            ['accountexpires' => $timestamp->fromDateTime($newExpiry)]
        );

        $this->assertTrue($validator->passes());
    }

    public function test_conditions_do_not_pass_with_identical_expiry_dates()
    {
        $conditions = $this->notifier->conditions()->get();

        $timestamp = new Timestamp('windows-int');

        $expiry = now()->subDay();

        // This will fail due to the account expires value being the same as the previous value.
        $validator = new Validator($conditions,
            ['accountexpires' => $timestamp->fromDateTime($expiry)],
            ['accountexpires' => $timestamp->fromDateTime($expiry)]
        );

        $this->assertFalse($validator->passes());
    }

    public function test_conditions_do_not_pass_with_future_date()
    {
        $conditions = $this->notifier->conditions()->get();

        $timestamp = new Timestamp('windows-int');

        $expiry = now()->addDay();

        // This will not pass due to the account not yet expiring.
        $validator = new Validator($conditions, ['accountexpires' => $timestamp->fromDateTime($expiry)]);

        $this->assertFalse($validator->passes());
    }

    public function test_conditions_do_not_pass_with_previously_expired_date_and_new_future_date()
    {
        $conditions = $this->notifier->conditions()->get();

        $timestamp = new Timestamp('windows-int');

        $expiry = now()->addDay();
        $newExpiry = now()->addDay();

        // This will not pass due to the account having a new expiry set in the future.
        $validator = new Validator($conditions,
            ['accountexpires' => $timestamp->fromDateTime($expiry)],
            ['accountexpires' => $timestamp->fromDateTime($newExpiry)]
        );

        $this->assertFalse($validator->passes());
    }
}
