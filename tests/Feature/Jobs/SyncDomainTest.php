<?php

namespace Tests\Feature\Jobs;

use Mockery as m;
use App\LdapDomain;
use App\Jobs\ScanDomain;
use App\Jobs\ImportDomain;
use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\Query\Model\Builder;
use LdapRecord\Configuration\DomainConfiguration;
use Tests\Feature\FeatureTestCase;

class SyncDomainTest extends FeatureTestCase
{
    public function test_import_action_is_executed_when_job_is_fired()
    {
        $domain = factory(LdapDomain::class)->create();

        $this->expectsJobs(ImportDomain::class);

        (new ScanDomain($domain))->handle();

        $this->assertTrue($domain->scans()->exists());
    }

    public function test_scan_contains_error_message_and_is_not_successful_when_scan_fails()
    {
        $domain = factory(LdapDomain::class)->create();

        $builder = m::mock(Builder::class);
        $builder->shouldReceive('listing')->once()->withNoArgs()->andReturnSelf();
        $builder->shouldReceive('select')->once()->withArgs(['*'])->andReturnSelf();
        $builder->shouldReceive('paginate')->once()->withArgs([1000])->andThrow(new \Exception('Cannot scan'));

        $connection = m::mock(Connection::class);
        $connection->shouldReceive('getConfiguration')->andReturn(new DomainConfiguration([
            'username' => encrypt('user'),
            'password' => encrypt('secret'),
        ]));
        $connection->shouldReceive('isConnected')->once()->andReturnTrue();
        $connection->shouldReceive('query')->once()->andReturnSelf();
        $connection->shouldReceive('model')->once()->andReturn($builder);

        Container::getInstance()->add($connection, $domain->getLdapConnectionName());

        try {
            ScanDomain::dispatch($domain);

            $this->fail('Exception not thrown.');
        } catch (\Exception $ex) {
            $scan = $domain->scans()->latest()->firstOrFail();

            $this->assertEquals('Cannot scan', $scan->message);
            $this->assertEquals(0, $scan->synchronized);
            $this->assertFalse($scan->success);
            $this->assertNotEmpty($scan->completed_at);
        }
    }

    public function test_scan_contains_error_message_and_is_not_successful_when_connecting_fails()
    {
        $domain = factory(LdapDomain::class)->create();

        $connection = m::mock(Connection::class);
        $connection->shouldReceive('getConfiguration')->andReturn(new DomainConfiguration([
            'username' => encrypt('user'),
            'password' => encrypt('secret'),
        ]));
        $connection->shouldReceive('isConnected')->once()->andReturnFalse();
        $connection->shouldReceive('connect')->once()->andThrow(new \Exception('Cannot connect'));

        Container::getInstance()->add($connection, $domain->getLdapConnectionName());

        try {
            ScanDomain::dispatch($domain);

            $this->fail('Exception not thrown.');
        } catch (\Exception $ex) {
            $scan = $domain->scans()->latest()->firstOrFail();

            $this->assertEquals('Cannot connect', $scan->message);
            $this->assertEquals(0, $scan->synchronized);
            $this->assertFalse($scan->success);
            $this->assertNotEmpty($scan->completed_at);
        }
    }
}
