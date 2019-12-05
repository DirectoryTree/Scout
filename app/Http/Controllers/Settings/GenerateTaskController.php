<?php

namespace App\Http\Controllers\Settings;

use App\Scout;
use App\System\QueueTask;
use App\System\SchedulerTask;

class GenerateTaskController
{
    /**
     * Generates the scheduler task XML file.
     *
     * @return \App\Http\ScoutResponse
     */
    public function scheduler()
    {
        (new SchedulerTask)->create();

        return Scout::response()
            ->visit(route('settings.edit'))
            ->notifyWithMessage('Generated Scheduler Task XML.');
    }

    /**
     * Generates the queue task XML file.
     *
     * @return \App\Http\ScoutResponse
     */
    public function queue()
    {
        (new QueueTask)->create();

        return Scout::response()
            ->visit(route('settings.edit'))
            ->notifyWithMessage('Generated Queue Runner Task XML.');
    }
}
