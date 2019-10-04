<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Notification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NotificationsController
{
    /**
     * The number of seconds to wait until refreshing the clients data.
     *
     * @var int
     */
    protected $refreshInterval = 5;

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
            while(true) {
                echo 'data: ' . $this->getNotifications($request->user()) . "\n\n";
                ob_flush();
                flush();

                sleep($this->refreshInterval);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no',
            'Cache-Control' => 'no-cache',
        ]);
    }

    /**
     * Get the notifications for the user.
     *
     * @param User $user
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getNotifications(User $user)
    {
        return $user->notifications()->with('notifiable')->get()->transform(function (Notification $notification) {
            return [
                'url' => '#',
                'test' => 'test',
            ];
        });
    }
}
