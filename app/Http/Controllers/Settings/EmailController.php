<?php

namespace App\Http\Controllers\Settings;

use App\Scout;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\EmailRequest;

class EmailController extends Controller
{
    /**
     * Displays the form for editing email settings.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('settings.email.edit');
    }

    /**
     * Updates the application email settings.
     *
     * @param EmailRequest $request
     *
     * @return \App\Http\ScoutResponse
     */
    public function update(EmailRequest $request)
    {
        if ($request->has('enabled')) {
            setting()->set([
                'app.email.enabled' => true,
                'app.email.driver' => $request->driver,
                'app.email.port' => $request->port,
                'app.email.encryption' => $request->encryption,
                'app.email.username' => $request->username,
                'app.email.password' => $request->password,
                'app.email.from.name' => $request->from_name,
                'app.email.from.address' => $request->from_address,
            ]);
        } else {
            setting()->set('app.email.enabled', false);
        }

        return Scout::response()->notifyWithMessage('Updated settings.');
    }
}
