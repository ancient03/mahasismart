<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();
        $unreadCount = $user->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark the specified notification as read.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['message' => 'Notification marked as read.']);
    }

    /**
     * Mark all unread notifications as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update(['is_read' => true]);

        return response()->json(['message' => 'All notifications marked as read.']);
    }
}
