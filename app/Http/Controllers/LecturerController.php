<?php

namespace App\Http\Controllers;


use App\Models\Lesson;

class LecturerController extends Controller
{

    public function showLessonAssignments()
    {
        $lessons = Lesson::with(['lecturer', 'department', 'semester'])->get();
        return view('lesson_assignments', compact('lessons'));
    }
}
