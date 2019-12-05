<?php

namespace App\System;

class QueueTask extends ScheduledTask
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
        'user_id' => 'S-1-5-18',
        'interval' => 'PT5M',
        'time_limit' => 'PT72H',
        // We will use the queue:listen command in case updates are
        // performed on the application. This is to prevent having
        // to restart the task manually on the server.
        'command' => 'queue:listen --tries=3',
    ];
}
