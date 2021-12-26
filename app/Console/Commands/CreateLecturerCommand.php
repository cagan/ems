<?php

namespace App\Console\Commands;

use App\Models\Department;
use App\Models\Lecturer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLecturerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lecturer:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create lecturer';

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
        $departmentIds = Department::all()->pluck('id')->toArray();

        foreach ($departmentIds as $departmentId) {
            Lecturer::factory()
                ->times(3)
                ->create(['department_id' => $departmentId]);
        }

        $this->comment('lecturer created...');

        return 1;
    }
}
