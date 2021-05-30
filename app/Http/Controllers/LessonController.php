<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLessonRequest;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Lesson;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LessonController extends Controller
{
    public function create()
    {
        $semesters = Semester::all();
        $departments = Department::all();
        return view('create_lesson', ['semesters' => $semesters, 'departments' => $departments]);
    }

    public function store(CreateLessonRequest $request)
    {
        list($name, $departmentId, $semesterId) = $this->params($request);

        if ($this->lessonExists($name)) {
            throw ValidationException::withMessages(['Lesson already exists']);
        }

        $lesson = $this->newLesson($request->all());

        return redirect()->back()->with('success', 'New lesson created successfully');
    }

    private function params($request): array
    {
        return [
            $request->get('name'),
            $request->get('department_id'),
            $request->get('semester_id'),
        ];
    }

    private function newLesson(array $params): Lesson
    {
        return Lesson::create([
            'name' => $params['name'],
            'department_id' => $params['department_id'],
            'semester_id' => $params['semester_id'],
            'lesson_code' => $this->lessonCode($params['name']),
            'quota' => $params['quota'] ?? 50,
        ]);
    }

    private function lessonExists(string $name)
    {
        return Lesson::where('name', $name)->exists();
    }

    private function lessonCode(string $name): string
    {
        $nameParts = collect(explode(' ', $name));
        return $nameParts
            ->map(fn($part) => strtoupper(substr($part, 0, 1)))
            ->splice(0, 3)
            ->implode('');
    }

    public function showLectureAssignView($id)
    {
        $lesson = Lesson::find($id);
        $lecturers = Lecturer::where('department_id', $lesson->department_id)->get();

        return view('assign_lecturer', compact('lesson', 'lecturers'));
    }

    public function assignLecturer($lessonId, Request $request)
    {
        $lecturerId = $request->get('lecturer_id');

        Lesson::find($lessonId)->update([
            'lecturer_id' => $lecturerId
        ]);

        return redirect()->route('show_assignments')->with('success', 'Lecturer assigned to a lesson successfully.');
    }
}

