<?php

namespace App\System;

class QueueTask extends StoredScheduledTask
{
    /**
     * The task attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'ScoutQueueRunner',
        'author' => 'Scout',
        'description' => 'Processes the Scout job queue.',
        'user_id' => ScheduledTask::USER_SYSTEM,
        'interval' => 'PT5M',
        'time_limit' => 'PT72H',
        // We will use the queue:listen command in case updates are
        // performed on the application. This is to prevent having
        // to restart the task manually on the server.
        'command' => 'queue:listen --tries=3',
    ];
}
