<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class LecturerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lecturer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        [$name, $surname] = explode(' ', $this->faker->name);

        return [
            'name' => $name,
            'surname' => $surname,
            'department_id' => 1,
        ];
    }
}
