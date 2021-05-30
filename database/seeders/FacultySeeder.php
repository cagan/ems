<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{


    public function facultyData()
    {
        return [
            [
                'name' => 'Engineering',
                'quota' => 100,
                'number_of_years' => 4,
                'created_at' => Carbon::now()->format('d.m.Y'),
            ],
            [
                'name' => 'Medicine',
                'quota' => 60,
                'number_of_years' => 6,
                'created_at' => Carbon::now()->format('d.m.Y'),
            ],
            [
                'name' => 'Education',
                'quota' => 120,
                'number_of_years' => 4,
                'created_at' => Carbon::now()->format('d.m.Y'),
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facultyNames = $this->existingFacultyNames();

        $faculties = collect($this->facultyData())
            ->reject(function($faculty) use ($facultyNames) {
                return in_array(data_get($faculty, 'name'), $facultyNames);
            })->toArray();

        Faculty::insert($faculties);
    }

    public function existingFacultyNames()
    {
        return Faculty::all()->pluck('name')->toArray();
    }
}
