<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Injectors\NotificationInjector;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NotificationsController
{
    /**
     * The number of seconds to wait until refreshing the clients data.
     *
     * @var int
     */
    protected $refreshInterval = 15 * 1000;

    /**
     * Returns the notification event stream.
     *
     * @param Request $request
     *
     * @return StreamedResponse
     */
    public function index(Request $request)
    {
        return new StreamedResponse(function() use ($request) {
            $latestNotifications = (new NotificationInjector($request))->get()
                ->transform(function ($notification) {
                    return view('notifications.notification', compact('notification'))->render();
                });

            echo "data:$latestNotifications \n\nretry:{$this->refreshInterval}\n\n";
            ob_flush();
            flush();
        }, 200, $this->getHeaders());
    }

    /**
     * Get the stream headers.
     *
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no',
            'Cache-Control' => 'no-cache',
        ];
    }
}
