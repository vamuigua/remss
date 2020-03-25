<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    // Notifications Index
    public function index(Request $request){
        $perPage = 25;
        $user = Auth::user();

        $notifications = $user->notifications;

        return view ('user.notifications.index', compact('notifications'));   
    }   

    // Mark all Notifications as Read
    public function markNotificationsAsRead(){
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return redirect()->back()->with('flash_message', 'All Notifications Marked as Read!');;   
    }

    // Mark specific Notification as Read
    public function notificationRead($id){
        $user = Auth::user();
        $user->notifications->find($id)->markAsRead();

        return redirect()->back()->with('flash_message', 'Notification Marked as Read!');  
    }
}
