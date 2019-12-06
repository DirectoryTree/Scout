<?php

namespace Tests\Unit;

use App\LdapDomain;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LdapDomainTest extends TestCase
{
    use RefreshDatabase;

    public function test_to_synchronize_returns_models_to_synchronize_with_proper_frequency()
    {
        $this->assertCount(0, LdapDomain::toSynchronize());

        $domain = factory(LdapDomain::class)->create();
        $this->assertCount(1, LdapDomain::toSynchronize());

        // Default is 15 minutes.
        $domain->scans()->create(['started_at' => now()->subMinutes(15)]);

        $toSync = LdapDomain::toSynchronize();
        $this->assertCount(1, $toSync);
        $this->assertTrue($domain->is($toSync->first()));

        setting()->set('app.scan.frequency', 20);
        $this->assertCount(0, LdapDomain::toSynchronize());
    }
}
