<?php

namespace App\Http\Controllers\Settings;

use App\Scout;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\EmailRequest;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

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
            $baseSettings = [
                'app.email.enabled' => true,
                'app.email.driver' => $request->driver,
                'app.email.host' => $request->host,
                'app.email.port' => $request->port,
                'app.email.encryption' => $request->encryption,
                'app.email.username' => $request->username,
                'app.email.from.name' => $request->from_name,
                'app.email.from.address' => $request->from_address,
            ];

            if ($request->filled('password')) {
                $baseSettings['app.email.password'] = $request->password;
            }

            $extra = [];

            switch ($request->driver) {
                case 'mailgun':
                    $extra = [
                        'app.email.mailgun.domain' => $request->mailgun_domain,
                        'app.email.mailgun.secret' => $request->mailgun_secret,
                        'app.email.mailgun.endpoint' => $request->mailgun_endpoint,
                    ];
                    break;
                case 'ses':
                    $extra = [
                        'app.email.ses.key' => $request->ses_key,
                        'app.email.ses.secret' => $request->ses_secret,
                    ];
                    break;
            }

            setting()->set(array_merge($baseSettings, $extra));
        } else {
            setting()->set('app.email.enabled', false);
        }

        return Scout::response()->notifyWithMessage('Updated settings.');
    }

    /**
     * Send a test email to the given email address.
     *
     * @param Request $request
     *
     * @return \App\Http\ScoutResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function test(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        Mail::raw('This email is test from Scout.', function (Message $message) use ($request) {
            $message->to($request->email);
        });

        return Scout::response()->notifyWithMessage('Successfully sent test email.');
    }
}
