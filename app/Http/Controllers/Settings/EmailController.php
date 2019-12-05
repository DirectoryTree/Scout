<?php

namespace App\Http\Controllers\Settings;

use App\Scout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
     * @param Request $request
     *
     * @return \App\Http\ScoutResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'enabled' => 'boolean',
            'port' => 'required_with:enabled',
            'encryption' => '',
            'username' => 'required_with:enabled',
            'password' => 'confirmed',
            'from_name' => 'required_with:enabled',
            'from_address' => 'required_with:enabled',
        ]);

        setting()->set([
            'app.email.enabled' => $request->has('enabled'),
        ]);

        return Scout::response()->notifyWithMessage('Updated settings.');
    }
}
