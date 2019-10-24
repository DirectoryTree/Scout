<?php

namespace Tests\Feature\Jobs;

use App\LdapScan;
use App\LdapDomain;
use App\Jobs\QueueSync;
use App\Jobs\SyncDomain;
use Tests\Feature\FeatureTestCase;

class QueueSyncTest extends FeatureTestCase
{
    public function test_sync_is_queued_when_job_is_fired()
    {
        $domain = factory(LdapDomain::class)->create();

        $job = new QueueSync($domain);

        $this->expectsJobs(SyncDomain::class);

        $job->handle();

        $scan = LdapScan::where('domain_id', '=', $domain->id)->first();

        $this->assertFalse($scan->success);
        $this->assertNull($scan->message);
        $this->assertEquals(0, $scan->synchronized);
    }
}
