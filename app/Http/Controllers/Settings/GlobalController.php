<?php

namespace App\Http\Controllers\Settings;

use App\Http\Injectors\TimezoneInjector;
use App\Scout;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GlobalController extends Controller
{
    /**
     * Displays the global application settings.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('settings.edit');
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
            'frequency' => 'required|integer|max:59',
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
