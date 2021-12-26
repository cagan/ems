<?php

namespace App\Console\Commands;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Console\Command;

class CreateDepartmentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'department:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create departments';


    private function findFacultyByWord(string $word)
    {
        $faculty = Faculty::where('name', 'like', $word)->first();
        return data_get($faculty, 'id');
    }

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $facultyIds = [];

        foreach (Faculty::all() as $department) {
            $facultyIds[data_get($department, 'name')] = $this->findFacultyByWord(data_get($department, 'name'));
        }

        $departments = [
            [
                'name' => 'computer engineering',
                'faculty_id' => $facultyIds['engineering'],
            ],
            [
                'name' => 'electrical engineering',
                'faculty_id' => $facultyIds['engineering']
            ],
            [
                'name' => 'civil engineering',
                'faculty_id' => $facultyIds['engineering'],
            ],
            [
                'name' => 'Dental and Maxillofacial Surgery',
                'faculty_id' => $facultyIds['dentistry'],
            ],
            [
                'name' => 'Periodontal',
                'faculty_id' => $facultyIds['dentistry'],
            ],
            [
                'name' => 'Brain Surgery',
                'faculty_id' => $facultyIds['medicine'],
            ],
            [
                'name' => 'Cardiovascular Surgerye',
                'faculty_id' => $facultyIds['medicine']
            ],
            [
                'name' => 'Orthopedics and Traumatology',
                'faculty_id' => $facultyIds['medicine'],
            ],
            [
                'name' => 'Aesthetic, Plastic & Reconstruction Surgery',
                'faculty_id' => $facultyIds['medicine']
            ],
            [
                'name' => 'Bankruptcy Law',
                'faculty_id' => $facultyIds['law'],
            ],
            [
                'name' => 'Criminal Law',
                'faculty_id' => $facultyIds['law'],
            ],
            [
                'name' => 'Entertainment Law',
                'faculty_id' => $facultyIds['law'],
            ],
            [
                'name' => 'Family Law',
                'faculty_id' => $facultyIds['law'],
            ],
        ];

        Department::insert($departments);

        return 0;
    }
}
