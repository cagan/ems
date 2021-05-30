<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Auth::routes([
    'register' => false
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'student'], function() {
    Route::get('/student/register_lesson', [StudentController::class, 'viewRegisterLesson'])
        ->name('student_register_lesson');

    Route::post('/student/register_lesson', [StudentController::class, 'storeRegisterLesson'])
        ->name('student_register_lesson_store');

    Route::get('/student/my_exams', [StudentController::class, 'showMyExams'])
        ->name('student_my_exams');

    Route::get('/student/notifications', [NotificationController::class, 'showNotifications'])
        ->name('student_show_notifications');

    Route::get('/student/notification/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])
        ->name('student_mark_as_read_notification');
});

// Lecturer
Route::group(['middleware' => 'lecturer'], function() {
    Route::get('/exams', [ExamController::class, 'create'])
        ->name('exam.create');

    Route::post('/exams', [ExamController::class, 'store'])
        ->name('exam.store');

    Route::get('/my-exams', [ExamController::class, 'showMyExams'])
        ->name('exam.my_exams');

    Route::get('/exams/update/{id}', [ExamController::class, 'updateExam'])
        ->name('exam.update');

    Route::put('/exams/update/{id}', [ExamController::class, 'saveUpdatedExam'])
        ->name('exam.update.save');

    Route::get('/exam/assign-grade/{id}', [ExamController::class, 'showAssignGradeView'])
        ->name('show_assign_grade');

    Route::post('/exam-assign-grade/{id}', [ExamController::class, 'assignGrade'])
        ->name('store_assign_grade');

    Route::get('/lecturer/my_lessons', [ExamController::class, 'showMyLessons'])
        ->name('lecturer_my_lessons');
});

// Admin
Route::group(['middleware' => 'admin'], function() {
    Route::get('/lesson', [LessonController::class, 'create'])
        ->name('create_lesson');

    Route::post('/lesson', [LessonController::class, 'store'])
        ->name('store_lesson');

    Route::get('/show-assignments', [LecturerController::class, 'showLessonAssignments'])
        ->name('show_assignments');

    Route::get('/assign-lecturer/{id}', [LessonController::class, 'showLectureAssignView'])
        ->name('show_assign_lecturer');

    Route::post('/assign-lecturer/{id}', [LessonController::class, 'assignLecturer'])
        ->name('assign_lecturer');
});
