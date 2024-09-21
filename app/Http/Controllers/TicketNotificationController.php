<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class TicketNotificationController extends Controller
{
    //
    $user = App\Models\User::find(1);
 
    foreach ($user->notifications as $notification) {
        echo $notification->type;
    }

    //If you want to retrieve only the "unread" notifications
    foreach ($user->unreadNotifications as $notification) {
        echo $notification->type;
    }
    
    //Marking Notifications as Read
    foreach ($user->unreadNotifications as $notification) {
        $notification->markAsRead();
    }

    //However, instead of looping through each notification,
    //you may use the markAsRead method directly on a collection
    // of notifications:
    $user->unreadNotifications->markAsRead();

  //You may also use a mass-update query to mark all of the notifications as read
    $user->unreadNotifications()->update(['read_at' => now()]);

    //You may delete the notifications to remove them from the table entirely:
    $user->notifications()->delete();
}
