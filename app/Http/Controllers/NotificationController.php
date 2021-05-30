<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function showNotifications()
    {

        $notificationMessages = collect(Auth::user()->notifications)
            ->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'message' => str_replace('{{lesson_name}}', $notification->data['lesson_name'], $notification->data['message']),
                ];
            });

        return view('student_notifications', compact('notificationMessages'));
    }

    public function markAsRead($id)
    {
        dd($id);
    }
}
