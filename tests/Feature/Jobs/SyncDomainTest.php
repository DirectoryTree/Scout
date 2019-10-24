<?php

namespace Tests\Feature\Jobs;

use Mockery as m;
use App\LdapDomain;
use App\Jobs\SyncDomain;
use App\Jobs\ImportObjects;
use App\Ldap\Connectors\DomainConnector;
use Tests\Feature\FeatureTestCase;
use Illuminate\Support\Facades\Bus;

class SyncDomainTest extends FeatureTestCase
{
    public function test_import_objects_is_queued_when_job_is_fired()
    {
        $domain = factory(LdapDomain::class)->create();

        $this->app->bind(DomainConnector::class, function () use ($domain) {
            $connector = m::mock(DomainConnector::class, [$domain]);
            $connector->shouldReceive('connect')->once()->andReturnTrue();

            return $connector;
        });

        $scan = $domain->scans()->create(['synchronized' => 0]);

        $job = new SyncDomain($domain, $scan);

        Bus::shouldReceive('dispatch')->once()->withArgs([ImportObjects::class])->andReturn(5);

        $job->handle();

        $scan->refresh();

        $this->assertEquals(5, $scan->synchronized);
        $this->assertTrue($scan->success);
        $this->assertNotEmpty($scan->completed_at);
    }

    public function test_scan_contains_error_message_and_is_not_successful_when_scan_fails()
    {
        $domain = factory(LdapDomain::class)->create();

        $this->app->bind(DomainConnector::class, function () use ($domain) {
            $connector = m::mock(DomainConnector::class, [$domain]);
            $connector->shouldReceive('connect')->once()->andReturnTrue();

            return $connector;
        });

        $scan = $domain->scans()->create(['synchronized' => 0]);

        $job = new SyncDomain($domain, $scan);

        Bus::shouldReceive('dispatch')->once()->withArgs([ImportObjects::class])
            ->andThrow(new \Exception('Cannot scan'));

        $job->handle();

        $scan->refresh();

        $this->assertEquals('Cannot scan', $scan->message);
        $this->assertEquals(0, $scan->synchronized);
        $this->assertFalse($scan->success);
        $this->assertNotEmpty($scan->completed_at);
    }

    public function test_scan_contains_error_message_and_is_not_successful_when_connecting_fails()
    {
        $domain = factory(LdapDomain::class)->create();

        $this->app->bind(DomainConnector::class, function () use ($domain) {
            $connector = m::mock(DomainConnector::class, [$domain]);
            $connector->shouldReceive('connect')->once()->andThrow(new \Exception('Cannot connect'));

            return $connector;
        });

        $scan = $domain->scans()->create(['synchronized' => 0]);

        $job = new SyncDomain($domain, $scan);

        Bus::shouldReceive('dispatch')->never();

        $job->handle();

        $this->assertEquals('Cannot connect', $scan->message);
        $this->assertEquals(0, $scan->synchronized);
        $this->assertFalse($scan->success);
        $this->assertNotEmpty($scan->completed_at);
    }
}