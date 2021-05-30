<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lessons = [
            'name' => 'Introduction to Computer Engineering',
            'department_id' => 1,
            'semester_id' => '',
        ];
    }
}
