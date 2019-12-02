<?php

namespace App\System;

use Illuminate\Support\Str;
use Illuminate\Support\Fluent;
use Spatie\ArrayToXml\ArrayToXml;
use Symfony\Component\Process\PhpExecutableFinder;

class ScheduledTask extends Fluent
{
    /**
     * The format to use for the scheduled task dates.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d\TH:i:s';

    /**
     * Generate the XML document.
     *
     * @return string
     */
    public function generate()
    {
        return ArrayToXml::convert(
            $this->template(),
            $this->rootAttributes(),
            $replaceSpacesByUnderScoresInKeyNames = true,
            $xmlEncoding = 'UTF-16',
            $xmlVersion = '1.0',
            ['formatOutput' => true]
        );
    }

    /**
     * The XML template.
     *
     * @return array
     */
    protected function template()
    {
        return [
            'RegistrationInfo' => [
                'Date' => $this->get('date', now()->format($this->dateFormat)),
                'Author' => $this->get('author', 'Scout'),
                'Description' => $this->get('description', 'Processes the Scout job queue.'),
                'URI' => Str::start($this->get('name', 'ScoutQueueRunner'), '\\'),
            ],
            'Triggers' => [
                'CalendarTrigger' => [
                    'Repetition' => [
                        'Interval' => $this->get('interval', 'PT5M'),
                        'StopAtDurationEnd' => 'false',
                    ],
                    'StartBoundary' => $this->get('start', now()->format($this->dateFormat)),
                    'Enabled' => 'true',
                    'ScheduleByDay' => [
                        'DaysInterval' => 1
                    ],
                ],
            ],
            'Principals' => [
                'Principal' => [
                    '_attributes' => [
                        'id' => 'Author',
                    ],
                    'UserId' => $this->get('user_id', 'S-1-5-18'),
                    'RunLevel' => 'LeastPrivilege',
                ],
            ],
            'Settings' => [
                'MultipleInstancesPolicy' => 'IgnoreNew',
                'DisallowStartIfOnBatteries' => 'true',
                'StopIfGoingOnBatteries' => 'true',
                'AllowHardTerminate' => 'true',
                'StartWhenAvailable' => 'true',
                'RunOnlyIfNetworkAvailable' => 'false',
                'IdleSettings' => [
                    'StopOnIdleEnd' => 'true',
                    'RestartOnIdle' => 'true',
                ],
                'AllowStartOnDemand' => 'true',
                'Enabled' => 'true',
                'Hidden' => 'false',
                'RunOnlyIfIdle' => 'false',
                'WakeToRun' => 'false',
                'ExecutionTimeLimit' => 'PT72H',
                'Priority' => 7,
            ],
            'Actions' => [
                '_attributes' => [
                    'Context' => 'Author',
                ],
                'Exec' => [
                    'Command' => $this->phpExecutable(),
                    'Arguments' => 'artisan queue:listen --tries=3',
                    'WorkingDirectory' => $this->get('path', base_path()),
                ],
            ]
        ];
    }

    /**
     * The root XML document properties.
     *
     * @return array
     */
    protected function rootAttributes()
    {
        return [
            'rootElementName' => 'Task',
            '_attributes' => [
                'xmlns' => 'http://schemas.microsoft.com/windows/2004/02/mit/task',
                'version' => '1.2',
            ],
        ];
    }

    /**
     * Get the PHP executable path.
     *
     * @return string
     */
    protected function phpExecutable()
    {
        return (new PhpExecutableFinder())->find() ?? 'php';
    }
}
