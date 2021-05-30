<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RegisterLecturerController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View
     */
    public function create()
    {
        $departments = Department::all();
        return view('auth.register_lecturer', ['departments' => $departments]);
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

        $name = $request->get('name');
        $surname = $request->get('surname');

        DB::beginTransaction();

        try {
            $lecturer = $this->createLecturer($request->all());

            $user = User::create([
                'username' => $this->lecturerUsername($name, $surname),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'lecturer_id' => $lecturer->id,
                'user_type' => 'lecturer'
            ]);

            event(new Registered($user));

            Auth::login($user);

            DB::commit();
        } catch (\Exception $exception) {
            Log::error('Can not register lecturer ' . $exception);
            DB::rollBack();
        }



        return redirect(RouteServiceProvider::HOME)->with('success', 'Student created successfully');
    }

    public function createLecturer($params)
    {
        return Lecturer::create([
            'name' => data_get($params, 'name'),
            'surname' => data_get($params, 'surname'),
            'department_id' => data_get($params, 'department_id'),
        ]);
    }

    public function lecturerUsername(string $name, string $surname): string
    {
        return $name . '.' . $surname;
    }

}
