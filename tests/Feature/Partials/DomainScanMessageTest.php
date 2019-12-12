<?php

namespace Tests\Feature\Partials;

use App\LdapScan;
use Tests\Feature\FeatureTestCase;

class DomainScanMessageTest extends FeatureTestCase
{
    public function test_scan_messages_can_be_viewed()
    {
        $this->signIn();

        $scan = factory(LdapScan::class)->create(['message' => 'Test message.']);

        $this->get(route('partials.domains.scans.message.show', [$scan->domain, $scan]))
            ->assertSee($scan->message)
            ->assertSee('Scan #')
            ->assertSee('modal')
            ->assertSee($scan->id);
    }
}
