<?php

namespace App\Http\Controllers;

use App\Events\GradeAssigned;
use App\Http\Requests\AssignGradeRequest;
use App\Http\Requests\CreateExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Models\Exam;
use App\Models\ExamResults;
use App\Models\ExamStudent;
use App\Models\Lecturer;
use App\Models\Lesson;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


class ExamController extends Controller
{

    public function create()
    {
        $lecturerId = Auth::user()->lecturer_id;
        $lessons = Lesson::where('lecturer_id', $lecturerId)->get();

        return view('exam_create', ['lessons' => $lessons]);
    }

    public function store(CreateExamRequest $request)
    {
        $validated = $request->all();
        DB::beginTransaction();

        $lecturerId = data_get(Auth::user(), 'lecturer_id');

        $examExists = Exam::where('lecturer_id', $lecturerId)
            ->where('lesson_id', data_get($validated, 'lesson_id'))
            ->exists();

        if ($examExists) {
            throw ValidationException::withMessages(['You already created exam with this lesson']);
        }

        try {
            $exam = Exam::create([
                'lesson_id' => data_get($validated, 'lesson_id'),
                'exam_date' => data_get($validated, 'datetime'),
                'lecturer_id' => $lecturerId,
                'duration' => data_get($validated, 'duration'),
                'notes' => data_get($validated, 'notes'),
            ]);

            $departmentId = data_get(Lecturer::find($lecturerId), 'department_id');
            $studentIds = Student::where('department_id', $departmentId)->pluck('id');

            $studentExamData = collect($studentIds)
                ->map(function ($id) use ($exam) {
                    return [
                        'exam_id' => data_get($exam, 'id'),
                        'student_id' => $id,
                    ];
                })->toArray();

            ExamStudent::insert($studentExamData);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            throw ValidationException::withMessages(['Oops something went wrong. Can not create new exam']);
        }

        return redirect()->back()->with('exam_create_success', 'New exam created successfully');
    }

    public function showMyExams()
    {
        $lecturerId = Auth::user()->lecturer_id;
        $exams = Exam::where('lecturer_id', $lecturerId)->with(['lesson'])->get();

        return view('my_exams', compact('exams'));
    }

    public function updateExam($id)
    {
        $lecturerId = Auth::user()->lecturer_id;
        $exam = Exam::where('lecturer_id', $lecturerId)->where('id', $id)->with(['lesson'])->first();
        if (!$exam) {
            throw ValidationException::withMessages(['Can not find any exam for that lecturer']);
        }

        $exam->exam_date = Carbon::parse($exam->exam_date)->format('Y-m-d H:i');

        return view('exam_update', compact('exam'));
    }

    public function saveUpdatedExam($id, UpdateExamRequest $request)
    {
        $updated = Exam::find($id)->update([
            'exam_date' => $request->get('datetime'),
            'duration' => $request->get('duration'),
            'notes' => $request->get('notes'),
        ]);

        if (!$updated) {
            throw ValidationException::withMessages(['Can not update exam.']);
        }

        return redirect()->route('exam.my_exams')->with('success', 'Exam updated successfully');
    }

    public function showAssignGradeView($examId)
    {
        $students = Exam::find($examId)->students()->get();

        return view('assign_grade', compact('students', 'examId'));
    }

    public function showMyLessons()
    {
        $lecturerId = data_get(Auth::user(), 'lecturer_id');
        $lessons = Lesson::where('lecturer_id', $lecturerId)->get();

        return view('teacher_lessons', compact('lessons'));
    }

    public function assignGrade($examId, AssignGradeRequest $request)
    {
        $studentId = $request->get('student_id');

       $examResults = ExamResults::updateOrCreate([
            'exam_id' => $examId,
            'student_id' => $studentId,
        ], [
            'exam_id' => $examId,
            'student_id' => $studentId,
            'point' => $request->get('grade'),
        ]);

        event(new GradeAssigned($studentId, $examResults));

        return redirect()->back()->with('success', 'Grade assigned to the student successfully');
    }
}
