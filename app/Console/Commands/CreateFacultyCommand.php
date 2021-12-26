<?php

namespace App\Console\Commands;

use App\Models\Faculty;
use Illuminate\Console\Command;

class CreateFacultyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faculty:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create faculties';

    protected array $faculties = [
        [
            'name' => 'medicine',
            'number_of_years' => 6,
            'quota' => 300,
        ],
        [
            'name' => 'engineering',
            'number_of_years' => 4,
            'quota' => 400
        ],
        [
            'name' => 'dentistry',
            'number_of_years' => 5,
            'quota' => 450,
        ],
        [
            'name' => 'law',
            'number_of_years' => 5,
            'quota' => 600
        ],
    ];

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
        foreach ($this->faculties as $faculty) {
            Faculty::updateOrCreate(
                ['name' => data_get($faculty, 'name')],
                $faculty
            );
        }

        $this->comment('faculties created...');
        return 0;
    }
}
