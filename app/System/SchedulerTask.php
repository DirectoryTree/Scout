<?php

namespace App\System;

class SchedulerTask extends ScheduledTask
{
    /**
     * The task attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'ScoutScheduleRunner',
        'author' => 'Scout',
        'description' => 'Processes the Scout scheduled commands.',
        'user_id' => ScheduledTask::USER_SYSTEM,
        'interval' => 'PT1M',
        'time_limit' => 'PT30M',
        'command' => 'schedule:run',
    ];
}
