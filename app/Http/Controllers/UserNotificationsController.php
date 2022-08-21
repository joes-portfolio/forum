<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;

class UserNotificationsController extends Controller
{
    public function index()
    {
        return auth()->user()->unreadNotifications->take(5);
    }

    public function update($userName, $notificationId)
    {
        auth()->user()->notifications()
            ->findOrFail($notificationId)
            ->markAsRead();
    }
}
