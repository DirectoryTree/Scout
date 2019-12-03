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
        'command' => 'queue:listen --tries=3',
    ];
}
