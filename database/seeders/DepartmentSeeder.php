<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{

    public function run()
    {
        $faculties = Faculty::all()->toArray();
        $departmentNames = Department::all()->pluck('name')->toArray();

         $departmentsData = [
            [
                'name' => 'Computer Engineering',
                'faculty_id' => data_get($faculties[0], 'id'),
            ],
            [
                'name' => 'Electrical Engineering',
                'faculty_id' => data_get($faculties[0], 'id'),
            ],
            [
                'name' => 'Dentist',
                'faculty_id' => data_get($faculties[1], 'id'),
            ],
            [
                'name' => 'Surgery',
                'faculty' => data_get($faculties[1], 'id'),
            ],
            [
                'name' => 'English Teacher',
                'faculty' => data_get($faculties[2], 'id'),
            ],
            [
                'name' => 'Math Teacher',
                'faculty' => data_get($faculties[2], 'id'),
            ]
        ];

         $departments = collect($departmentsData)
             ->reject(function($department) use ($departmentNames) {
                 return in_array(data_get($department, 'name'), $departmentNames);
             })->toArray();

         Department::insert($departments);
    }
}
