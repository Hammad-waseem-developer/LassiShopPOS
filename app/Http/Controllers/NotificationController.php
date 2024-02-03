<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\NotificationDetail;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function fetchNotifications()
    {
        $notifications = Notification::with('NotificationDetail')
            ->orderBy('id', 'desc')
            ->get();

            $unreadNotificationsCount = NotificationDetail::where('user_id', Auth::user()->id)
            ->where('status', 0)
            ->count();

        return response()->json(['notifications' => $notifications, 'unreadNotificationsCount' => $unreadNotificationsCount]);
    }
}
