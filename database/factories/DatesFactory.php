<?php

namespace Database\Factories;

use App\Models\Dates;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dates::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1,200),
            'date_time' => $this->faker->dateTimeBetween('now', '+1year'),
            'pet_id' => \App\Models\Pets::inRandomOrder()->first()->id,
            'employee_id' => \App\Models\Employees::inRandomOrder()->first()->id,
            //
        ];
    }
}
