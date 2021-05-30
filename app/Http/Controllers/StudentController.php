<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterLessonRequest;
use App\Models\Exam;
use App\Models\ExamResults;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\StudentLesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{

    public function viewRegisterLesson()
    {
        $student = Student::find(data_get(Auth::user(), 'student_id'));
        $lessons = Lesson::where('department_id', data_get($student, 'department_id'))->get();
        return view('student_register_lesson', compact('lessons'));
    }

    /**
     * @throws ValidationException
     */
    public function storeRegisterLesson(RegisterLessonRequest $request)
    {
        $lessonId = $request->get('lesson_id');
        $studentId = data_get(Auth::user(), 'student_id');

        $exists = StudentLesson::where('student_id', $studentId)->where('lesson_id', $lessonId)->exists();

        if ($exists) {
            throw ValidationException::withMessages(['Error: Lesson already has been registered']);
        }

        Student::find($studentId)->lessons()->attach($lessonId);

        return redirect()->back()->with('success', 'New lesson has been registered.');
    }

    public function showMyExams()
    {
        $studentId = data_get(Auth::user(), 'student_id');
        $studentLessonsIds = Student::find($studentId)->lessons()->orderBy('lesson_id', 'desc')->pluck('lesson_id');

        // $exams = Exam::whereIn('lesson_id', $studentLessonsIds)->with('examResult')->get();

//        $exams = Exam::query()
//            ->select('exams.lesson_id', 'exams.lecturer_id', 'exams.exam_date', 'exams.duration', 'exam_results.point', 'exam_results.student_id')
//            ->leftJoin('exam_results',  function($join) use ($studentId) {
//                $join->on('exam_results.exam_id', '=', 'exams.id');
//            })
//            ->where('exam_results.student_id', $studentId)
//            ->get();

//        $examResults = DB::table('exam_results')
//                        ->select('point', 'exam_id')
//                        ->where('student_id', $studentId);

//        $exams = DB::table('exams')
//            ->joinSub($examResults, 'er', function($join) {
//                $join->on('exams.id', '=',' exam_results.exam_id');
//            })
//            ->get();

        $exams = DB::select("select e.lesson_id, e.lecturer_id, e.exam_date, e.duration, er.point, l.`name`, e.is_date_passed from exams as e
	left join exam_results as er on er.exam_id = e.id and er.student_id = :student_id
	left join lessons as l on l.id = e.lesson_id;", ['student_id' => $studentId]);

//        $exams = Exam::query()
//            ->select('exams.lesson_id', 'exams.lecturer_id', 'exams.exam_date', 'exams.duration', 'exam_results.point', 'exam_results.student_id')
//            ->joinSub($subQuery, 'er', function($join) {
//                $join->on('exams.id', '=', 'er.exam_id');
//            })
//            ->get();
//
//        dd($exams);

        if (count($exams) < 1) {
            Session::flash('message', 'You don\'t have any exams yet.');
        }

        return view('student_exams', compact('exams'));
    }

}
