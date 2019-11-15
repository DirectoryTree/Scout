<?php

namespace App\Http\Controllers;

use App\Scout;
use App\LdapDomain;
use App\Jobs\QueueSync;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\ExecuteScanRequest;

class ExecuteController extends Controller
{
    /**
     * Executes a scan on the domain by the requested token.
     *
     * @param ExecuteScanRequest $request
     *
     * @return \App\Http\ScoutResponse
     */
    public function scan(ExecuteScanRequest $request)
    {
        $domain = LdapDomain::whereToken($request->token)->firstOrFail();

        Bus::dispatch(new QueueSync($domain));

        return Scout::response()->type('success')->message('Queued.');
    }

    /**
     * Runs the queue until all jobs have been completed.
     *
     * @param Request $request
     *
     * @return \App\Http\ScoutResponse
     */
    public function queue(Request $request)
    {
        Artisan::call('queue:work', ['--stop-when-empty', '--tries' => 3]);

        return Scout::response()->type('success')->message('Queue is running.');
    }
}
