<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterStudentController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View
     */
    public function create()
    {
        $departments = Department::all();
        return view('auth.register_student', ['departments' => $departments]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:30',
            'surname' => 'required|string|max:30',
            'department_id' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $student = $this->createStudent($request->all());

            $user = User::create([
                'username' => $this->uniqueStudentName(),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'student_id' => $student->id,
                'user_type' => 'student'
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME)->with('success', 'Student created successfully');
    }

    public function createStudent($params)
    {
        return Student::create([
            'name' => data_get($params, 'name'),
            'surname' => data_get($params, 'surname'),
            'department_id' => data_get($params, 'department_id'),
        ]);
    }

    public function uniqueStudentName()
    {
        return strtoupper(substr(uniqid('EXT'), 0, 11));
    }
}
