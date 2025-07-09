<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationSeenController extends Controller
{
    public function __invoke(DatabaseNotification $notification)
    {
        Gate::authorize('update', $notification);

        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }
}
