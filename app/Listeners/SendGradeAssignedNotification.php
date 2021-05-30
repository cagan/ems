<?php

namespace App\Listeners;

use App\Events\GradeAssigned;
use App\Models\Exam;
use App\Models\Lesson;
use App\Models\User;
use App\Notifications\GradeAssignedNotification;
use Illuminate\Support\Facades\Notification;


class SendGradeAssignedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GradeAssigned  $event
     * @return void
     */
    public function handle(GradeAssigned $event)
    {
        $user = User::where('student_id', $event->studentId)->first();
        $lessonId = $event->examResults->exam()->pluck('lesson_id')->first();
        $lessonName = Lesson::find($lessonId)->name;

        Notification::send($user, new GradeAssignedNotification($lessonName));
    }
}
