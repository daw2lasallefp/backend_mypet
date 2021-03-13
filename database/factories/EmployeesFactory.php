<?php

namespace Database\Factories;

use App\Models\Employees;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employees::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1,200),
            'name'=> $this->faker->name,
            'surname'=> $this->faker->name,
            'email'=> $this->faker->unique()->safeEmail,
            'password'=> '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'admin'=> $this->faker->randomElement([true, false]),
            'work_shift'=> $this->faker->randomElement(['tarde','mañana']),
            'speciality_id'=> \App\Models\Specialities::inRandomOrder()->first()->id,
            //
        ];
    }
}
