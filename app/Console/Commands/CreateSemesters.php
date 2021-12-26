<?php

namespace App\Console\Commands;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateSemesters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'semester:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new semesters for each faculty';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        // for each faculty create semester, cron job will work for each year.
        $faculties = Faculty::all();

        foreach ($faculties as $faculty) {
            $currentYear = Carbon::now()->year;
            $newYear = false;

            for ($year = 0; $year < $faculty->number_of_years * 2; $year++) {
                if ($newYear === true) {
                    $currentYear += 1;
                    $newYear = false;
                }

                if ($year % 2 === 0) {
                    Semester::create([
                        'faculty_id' => $faculty->id,
                        'year' => $currentYear,
                        'type' => 'fall'
                    ]);
                } else {
                    Semester::create([
                        'faculty_id' => $faculty->id,
                        'year' => $currentYear,
                        'type' => 'spring'
                    ]);
                    $newYear = true;
                }
            }
        }

        $this->info('Semester created');

        return 1;
    }
}
