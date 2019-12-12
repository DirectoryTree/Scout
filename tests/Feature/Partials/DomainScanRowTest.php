<?php

namespace Tests\Feature\Partials;

use App\LdapScan;
use Tests\Feature\FeatureTestCase;

class DomainScanRowTest extends FeatureTestCase
{
    public function test_scan_rows_can_be_view()
    {
        $this->signIn();

        $scan = factory(LdapScan::class)->create([
            'started_at' => now(),
            'completed_at' => now(),
        ]);

        $this->get(route('partials.domains.scans.row.show', [$scan->domain, $scan]))
            ->assertSee('tr')
            ->assertSee($scan->started_at)
            ->assertSee($scan->completed_at)
            ->assertDontSee('View');
    }

    public function test_scan_row_has_modal_button_when_message_exists()
    {
        $this->signIn();

        $scan = factory(LdapScan::class)->create([
            'started_at' => now(),
            'completed_at' => now(),
            'message' => 'Test message.',
        ]);

        $this->get(route('partials.domains.scans.row.show', [$scan->domain, $scan]))
            ->assertSee('View');
    }
}
