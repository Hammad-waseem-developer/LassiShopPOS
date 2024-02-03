<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\NotificationCreate;
use App\Models\NotificationDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function fetchNotifications()
    {
        // $notifications = Notification::with('NotificationDetail')
        //     ->where('notification_details.user_id', Auth::user()->id)
        //     ->orderBy('id', 'desc')
        //     ->get();

        $notifications = DB::table('notification')
            ->select('*')
            ->join('notification_details', 'notification.id', '=', 'notification_details.notification_id')
            ->where('notification_details.user_id', Auth::user()->id)
            ->where('notification_details.status', 0)
            ->get();


        $unreadNotificationsCount = NotificationDetail::where('user_id', Auth::user()->id)
            ->where('status', 0)
            ->count();

        return response()->json(['notifications' => $notifications, 'unreadNotificationsCount' => $unreadNotificationsCount]);
    }

    public function fetchNotificationsMessage(Request $request)
    {
        $notificationId = $request->id;
        $notificationDetails = NotificationDetail::with('notification')->where('notification_id', $notificationId)->where('user_id', Auth::user()->id)->first();
        // dd($notificationDetails);
        $notificationDetails->status = 1;
        $notificationDetails->read_at = now();
        $notificationDetails->save();
        $notification = Notification::where('id', $notificationId)->get();
        event(new NotificationCreate($notification));
        return response()->json(['notificationDetails' => $notificationDetails]);
    }
}
