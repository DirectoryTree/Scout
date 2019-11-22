<?php

namespace App\Http\Controllers\Settings;

use App\Scout;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        ]);

        setting()->set('app.pinning', $request->has('pinning'));
        setting()->set('app.calendar', $request->has('calendar'));

        return Scout::response()->notifyWithMessage('Updated settings.');
    }
}
