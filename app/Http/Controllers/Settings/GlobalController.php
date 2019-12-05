<?php

namespace App\Http\Controllers\Settings;

use App\Scout;
use App\System\QueueTask;
use App\System\SchedulerTask;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Injectors\TimezoneInjector;
use SebastianBergmann\Environment\OperatingSystem;

class GlobalController extends Controller
{
    /**
     * Displays the global application settings.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $os = (new OperatingSystem)->getFamily();

        return view('settings.edit', [
            'os' => $os,
            'tasks' => [
                'queue' => new QueueTask(),
                'scheduler' => new SchedulerTask(),
            ]
        ]);
    }

    /**
     * Update global application settings.
     *
     * @param Request $request
     *
     * @return \App\Http\ScoutResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'pinning' => 'boolean',
            'calendar' => 'boolean',
            'frequency' => 'required|integer|min:5|max:59',
            'timezone' => [
                'required',
                Rule::in((new TimezoneInjector)->get())
            ],
        ]);

        setting()->set([
            'app.pinning' => $request->has('pinning'),
            'app.calendar' => $request->has('calendar'),
            'app.timezone' => $request->get('timezone', 'UTC'),
            'app.scan.frequency' => $request->get('frequency', '15'),
        ]);

        return Scout::response()->notifyWithMessage('Updated settings.');
    }
}
